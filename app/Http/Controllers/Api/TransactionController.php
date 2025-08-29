<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    /**
     * Menampilkan detail sebuah transaksi.
     *
     * @param Transaction $transaction
     * @return JsonResponse
     */
    public function show(Transaction $transaction): JsonResponse
    {
        if (Auth::id() !== $transaction->user_id) {
            return ResponseHelper::error(null, 'Akses ditolak.', Response::HTTP_FORBIDDEN);
        }

        $transaction->load('position.formation');

        $data = new TransactionResource($transaction);

        return ResponseHelper::success($data, 'Berhasil mengambil detail transaksi.');
    }
}
