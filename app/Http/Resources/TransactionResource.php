<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'reference' => $this->reference,
            'package_type' => $this->package_type,
            'amount' => $this->amount,
            'status' => $this->status,
            'payment_method' => $this->payment_method,
            'checkout_url' => $this->checkout_url,
            'payment_code' => $this->payment_code,
            'qr_url' => $this->qr_url,
            'expired_at' => $this->expired_at ? $this->expired_at->translatedFormat('d F Y, H:i') : null,
            'created_at' => $this->created_at->translatedFormat('d F Y, H:i'),
            'position' => new PositionResource($this->whenLoaded('position')),
        ];
    }
}
