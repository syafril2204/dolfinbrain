<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResultResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'answer_text' => $this->answer_text,
            'is_correct' => $this->is_correct, // Tampilkan kunci jawaban
        ];
    }
}
