<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TripayCallbackController extends Controller
{
    public function handle(Request $request)
    {
        $privateKey = config('services.tripay.private_key');
        $callbackSignature = $request->server('HTTP_X_CALLBACK_SIGNATURE');
        $json = $request->getContent();
        $signature = hash_hmac('sha256', $json, $privateKey);

        if ($signature !== $callbackSignature) {
            return response()->json(['success' => false, 'message' => 'Invalid Signature'], 403);
        }

        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['success' => false, 'message' => 'Invalid JSON'], 400);
        }

        if ($data['status'] == 'PAID') {
            $transaction = Transaction::where('reference', $data['merchant_ref'])->first();

            if ($transaction && $transaction->status === 'pending') {
                $transaction->update(['status' => 'paid']);

                $user = $transaction->user;
                $packageType = explode('-', $transaction->position->sku)[0];
                dd($packageType);
                $user->purchasedPositions()->attach($transaction->position_id, ['package_type' => $packageType]);
            }
        }

        return response()->json(['success' => true]);
    }
}
