<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreditResource extends JsonResource
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
            'price' => $this->price,
            'month' => $this->month,
            'percent' => $this->percent,
            'product' => new ProductResource($this->product),
            'monthly_payment' => $this->monthly_payment,
            'credit_items' => CreditItemResource::collection($this->credit_items),
            'date' => $this->created_at->format('d/m/Y')
        ];
    }

}
