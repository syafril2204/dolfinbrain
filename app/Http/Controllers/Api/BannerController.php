<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\BannerResource;
use App\Models\Banner;
use Illuminate\Http\JsonResponse;

class BannerController extends Controller
{
    /**
     * Menampilkan daftar semua banner.
     */
    public function index(): JsonResponse
    {
        $banners = Banner::orderBy('id')->get();
        $data = BannerResource::collection($banners);

        return ResponseHelper::success($data, 'Berhasil mengambil data banner.');
    }
}