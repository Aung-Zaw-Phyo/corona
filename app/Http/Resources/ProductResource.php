<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $discount = collect($this->discounts->pluck('percent'))->max();
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,    
            'name' => $this->name,
            'price' => number_format($this->price, 2, '.', ''),
            'quantity' => number_format($this->quantity),
            'image' => $this->image_path(),
            'description' => $this->description,
            'discount' => $discount ? number_format($discount) : 0
        ];
    }
}
