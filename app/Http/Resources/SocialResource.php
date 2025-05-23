<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SocialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $url = url('/');
        return [
            'id' => $this->id,
            'title' => $this->title,
            'link' => $this->link,
            'icon'=>$url . '/storage/' .$this->image,
        ];
    }
}
