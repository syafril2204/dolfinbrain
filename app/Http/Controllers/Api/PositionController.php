<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\PositionResource;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
     * Menampilkan semua posisi.
     */
    public function index()
    {
        // Gunakan eager loading 'with()' untuk efisiensi query
        $positions = Position::with('formation')->get();
        $data = PositionResource::collection($positions);

        return ResponseHelper::success($data, 'Berhasil mengambil data posisi.');
    }
}
