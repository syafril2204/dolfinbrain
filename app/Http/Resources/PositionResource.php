<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PositionResource extends JsonResource
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
            'name' => $this->name,
            'price_mandiri' => (int) $this->price_mandiri,
            'price_bimbingan' => (int) $this->price_bimbingan,
            'formation' => $this->whenLoaded('formation', function () {
                return [
                    'id' => $this->formation->id,
                    'name' => $this->formation->name,
                ];
            }),
        ];
    }
}
