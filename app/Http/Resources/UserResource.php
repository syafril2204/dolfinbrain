<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'gender' => $this->gender,
            'date_of_birth' => $this->date_of_birth,
            'domicile' => $this->domicile,
            'phone_number' => $this->phone_number,
            'avatar_url' => $this->avatar ? Storage::disk('public')->url($this->avatar) : null,
            'package_type' => $this->latestPositionUser ? $this->latestPositionUser->package_type : 'Free',
            'email_verified_at' => $this->email_verified_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'position' => $this->whenLoaded('position', function () {
                return [
                    'id' => $this->position->id,
                    'name' => $this->position->name,
                    'formation' => $this->whenLoaded('position.formation', function () {
                        return [
                            'id' => $this->position->formation->id,
                            'name' => $this->position->formation->name,
                        ];
                    })
                ];
            }),
        ];
    }
}
