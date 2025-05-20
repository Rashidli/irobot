<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ProductResource extends JsonResource
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
            'room_area' => $this->room_area,
            'title' => $this->title,
            'is_new' => $this->is_new,
            'slug' => $this->slug,
            'image' => $base_url . '/storage/' . $this->image,
            'price' => $this->price,
            'discounted_price' => $this->discounted_price ?? $this->price,
            'img_alt' => $this->img_alt,
            'img_title' => $this->img_title,
            'description' => Str::limit($this->description,'50')
        ];

    }
}
