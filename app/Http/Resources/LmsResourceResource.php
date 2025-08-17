<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class LmsResourceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'type' => $this->type, // 'recap_file' atau 'audio_recording'
            'file_type' => $this->file_type,
            'download_url' => route('admin.lms-resources.download', $this->id),
        ];
    }
}
