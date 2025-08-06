<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use Illuminate\Http\Request;

class TransactionHistoryController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $transactions = $user->transactions()
            ->with('position.formation')
            ->latest()
            ->paginate(10);

        $data = TransactionResource::collection($transactions);

        return ResponseHelper::success($data, 'Berhasil mengambil riwayat transaksi.');
    }
}
