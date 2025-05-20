<?php

namespace App\Http\Resources;

use App\Models\Percentage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductSingleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $base_url = url('/');

        $totalComments = $this->comments->where('is_accept', true)->count();

        $ratingsCount = $this->comments
            ->where('is_accept', true)
            ->groupBy('star')
            ->map(fn($comments) => $comments->count())
            ->all();

        $ratingPercentages = [];

        for ($i = 5; $i >= 1; $i--) {
            $count = $ratingsCount[$i] ?? 0;
            $percentage = $totalComments > 0 ? round(($count / $totalComments) * 100) : 0;
            $ratingPercentages[$i] = "{$percentage}% ({$count})";
        }

        $percentages = Percentage::all();
        $calculated_prices = [];

        foreach ($percentages as $percentage) {
            $calculated_prices[] = [
                'percentage' => $percentage->percent,
                'month' => $percentage->month,
                'calc_price' => app('App\Services\CalculateLoan')->monthlyPayment(
                    $this->price,
                    $percentage->month,
                    $percentage->percentage
                )
            ];
        }

        return [
            'id' => $this->id,
            'code' => $this->code,
            'title' => $this->title,
            'description' => $this->description,
            'slug' => [
                'az' => optional($this->translate('az'))->slug,
                'en' => optional($this->translate('en'))->slug,
                'ru' => optional($this->translate('ru'))->slug,
            ],
            'image' => $base_url . '/storage/' . $this->image,
            'price' => $this->price,
            'discounted_price' => $this->discounted_price ?? $this->price,
            'is_stock' => $this->is_stock,
            'room_area' => $this->room_area,
            'is_new' => $this->is_new,
            'img_alt' => $this->img_alt,
            'img_title' => $this->img_title,
            'rating_summary' => $ratingPercentages,
            'avg_star' => ($avg = round($this->comments()->where('is_accept', true)->avg('star'), 1)) ?: 5,
            'calculated_prices' => $calculated_prices,
            'sliders' => SliderResource::collection($this->sliders),
            'product_faqs' => ProductFaqResource::collection($this->product_faqs),
            'product_details' => ProductDetailResource::collection($this->product_details),
            'product_features' => ProductFeaturesResource::collection($this->product_features),
            'product_colors' => ProductColorResource::collection($this->product_colors),
            'comments' => CommentResource::collection($this->comments->where('is_accept', true)),
            'accessories' => AccessoryResource::collection($this->accessories)
        ];

    }
}
