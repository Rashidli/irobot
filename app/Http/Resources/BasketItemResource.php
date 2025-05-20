<?php

namespace App\Http\Resources;

use App\Models\Percentage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BasketItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $percentages = Percentage::all();
        $calculated_prices = [];

        foreach ($percentages as $percentage) {
            $calculated_prices[] = [
                'percentage' => $percentage->percent,
                'month' => $percentage->month,
                'calc_price' => app('App\Services\CalculateLoan')->monthlyPayment(
                    $this->price * $this->quantity,
                    $percentage->month,
                    $percentage->percentage
                )
            ];
        }

        return [
            'id' => $this->id,
            'product' => new ProductResource($this->product),
            'quantity' => $this->quantity,
            'price' => $this->price,
            'calculated_prices' => $calculated_prices,
            'is_credit' => $this->is_credit,
            'percent' => $this->percent,
            'month' => $this->month,
            'monthly_payment' => $this->monthly_payment
        ];
    }
}
