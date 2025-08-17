<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    /**
     * Menampilkan daftar semua artikel yang sudah dipublikasikan.
     */
    public function index(): JsonResponse
    {
        $articles = Article::with('user')
            ->where('is_published', true)
            ->latest('published_at')
            ->paginate(10);

        $data = ArticleResource::collection($articles);

        return ResponseHelper::success($data, 'Berhasil mengambil daftar artikel.');
    }

    /**
     * Menampilkan detail satu artikel berdasarkan slug.
     */
    public function show(Article $article): JsonResponse
    {
        // Pastikan hanya artikel yang sudah terbit yang bisa diakses
        if (!$article->is_published) {
            return ResponseHelper::error(null, 'Artikel tidak ditemukan.', Response::HTTP_NOT_FOUND);
        }

        $article->load('user');
        $data = new ArticleResource($article);

        return ResponseHelper::success($data, 'Berhasil mengambil detail artikel.');
    }
}
