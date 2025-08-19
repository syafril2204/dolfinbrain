<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\PositionResource;
use App\Models\Formation;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
     * Menampilkan semua posisi.
     */
    public function index(Formation $formation)
    {
        $positions = Position::with('formation')->where('formation_id', $formation->id)->get();
        $data = PositionResource::collection($positions);

        return ResponseHelper::success($data, 'Berhasil mengambil data posisi.');
    }
}
