<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentMethodResource;
use App\Http\Resources\TransactionResource;
use App\Services\TripayService;
use Illuminate\Http\JsonResponse;
use App\Models\Position;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function getPaymentChannels(TripayService $tripay): JsonResponse
    {
        $response = $tripay->getPaymentChannels();
        $data = PaymentMethodResource::collection(collect($response));
        return ResponseHelper::success($data, 'Berhasil mengambil metode pembayaran.');
    }

    public function createTransaction(Request $request, TripayService $tripay): JsonResponse
    {
        $request->validate([
            'position_id' => 'required|exists:positions,id',
            'package_type' => 'required|in:mandiri,bimbingan',
            'payment_method' => 'required|string',
        ]);

        $user = $request->user();
        $position = Position::find($request->position_id);

        // Logika harga (termasuk upgrade)
        $price = $request->package_type === 'mandiri' ? $position->price_mandiri : $position->price_bimbingan;

        $hasMandiri = $user->purchasedPositions()->where('position_id', $position->id)->where('package_type', 'mandiri')->exists();
        $hasBimbel = $user->purchasedPositions()->where('position_id', $position->id)->where('package_type', 'bimbingan')->exists();

        if ($request->package_type === 'bimbingan' && $hasMandiri && !$hasBimbel) {
            $price -= $position->price_mandiri;
        }

        // Buat record transaksi lokal
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'position_id' => $position->id,
            'package_type' => $request->package_type,
            'reference' => 'INV-' . $user->id . '-' . time(),
            'payment_method' => $request->payment_method,
            'amount' => max(0, $price),
            'status' => 'pending',
            'phone_number' => $user->phone_number,
        ]);

        // Buat transaksi di Tripay
        $tripayResponse = $tripay->createTransaction($transaction, $user, $position, $request->package_type, $request->payment_method, $user->phone_number);

        if (isset($tripayResponse['success']) && $tripayResponse['success']) {
            $tripayData = $tripayResponse['data'];
            $transaction->update([
                'checkout_url' => $tripayData['checkout_url'],
                'payment_code' => $tripayData['pay_code'] ?? null,
                'qr_url' => $tripayData['qr_string'] ?? null,
                'expired_at' => \Carbon\Carbon::createFromTimestamp($tripayData['expired_time']),
            ]);

            return ResponseHelper::success(new TransactionResource($transaction), 'Transaksi berhasil dibuat.');
        } else {
            $transaction->update(['status' => 'failed']);
            return ResponseHelper::error(null, 'Gagal membuat transaksi: ' . ($tripayResponse['message'] ?? 'Error tidak diketahui'), 500);
        }
    }
}
