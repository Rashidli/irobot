<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ProductDifferentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $base_url = url('/');

        $defaultColor = $this->product_colors->where('is_default', true)->first();
        $colorTitle = $defaultColor ? $defaultColor->title : null;

        return [
            'id' => $this->id,
            'title' => $this->title,
            'room_area' => $this->room_area,
            'price' => $this->price,
            'category' => $this->category?->title,
            'type' => $this->type?->title,
            'product_serie' => $this->product_serie?->title,
            'color' => $colorTitle,
            'slug' => [
                'az' => optional($this->translate('az'))->slug,
                'en' => optional($this->translate('en'))->slug,
                'ru' => optional($this->translate('ru'))->slug,
            ],
            'image' => $base_url . '/storage/' . $this->image,
            'discounted_price' => $this->discounted_price ?? $this->price,
        ];
    }
}
