<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'image_url' => $this->image ? Storage::url($this->image) : null,

            'excerpt' => Str::limit(strip_tags($this->content), 150),

            'content' => $this->when($request->routeIs('api.articles.show'), $this->content),

            'published_at' => $this->published_at->translatedFormat('d F Y'),
            'author' => [
                'name' => $this->user->name,
            ],
        ];
    }
}
