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
            'package_name' => 'Paket ' . ucfirst($this->package_type),
            'position_name' => $this->whenLoaded('position', function () {
                return $this->position->formation->name . ' - ' . $this->position->name;
            }),
            'amount' => (int) $this->amount,
            'status' => $this->status,
            'payment_method' => $this->payment_method,
            'transaction_date' => $this->created_at->translatedFormat('j F Y'),
            // 'payment_url' => $this->status === 'pending' ? route('student.packages.instruction', $this->reference) : null,
        ];
    }
}
