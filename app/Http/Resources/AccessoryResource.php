<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class AccessoryResource extends JsonResource
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
            'title' => $this->title,
            'slug' => [
                'az' => optional($this->translate('az'))->slug,
                'en' => optional($this->translate('en'))->slug,
                'ru' => optional($this->translate('ru'))->slug,
            ],
            'image' => $base_url . '/storage/' . $this->image,
            'price' => $this->price,
            'discounted_price' => $this->discounted_price ?? $this->price,
            'img_alt' => $this->img_alt,
            'img_title' => $this->img_title,
            'description' => Str::limit($this->description,'50')
        ];
    }
}
