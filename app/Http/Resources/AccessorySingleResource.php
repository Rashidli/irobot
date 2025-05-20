<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccessorySingleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $base_url = url('/');
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
            'sliders' => SliderResource::collection($this->sliders),
            'image' => $base_url . '/storage/' . $this->image,
            'price' => $this->price,
            'discounted_price' => $this->discounted_price ?? $this->price,
            'is_stock' => $this->is_stock,
            'img_alt' => $this->img_alt,
            'img_title' => $this->img_title,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
        ];
    }
}
