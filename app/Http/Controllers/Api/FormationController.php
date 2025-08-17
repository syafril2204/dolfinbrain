<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\FormationResource;
use App\Models\Formation;
use Illuminate\Http\Request;

class FormationController extends Controller
{
    /**
     * Menampilkan semua formasi.
     */
    public function index()
    {
        $formations = Formation::all();
        $data = FormationResource::collection($formations);

        return ResponseHelper::success($data, 'Berhasil mengambil data formasi.');
    }
}
