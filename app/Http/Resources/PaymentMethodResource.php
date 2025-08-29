<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentMethodResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'code' => $this['code'],
            'name' => $this['name'],
            'group' => $this['group'],
            'fee' => [
                'flat' => $this['fee_merchant']['flat'],
                'percent' => $this['fee_merchant']['percent'],
            ],
            'icon_url' => $this['icon_url'],
        ];
    }
}
