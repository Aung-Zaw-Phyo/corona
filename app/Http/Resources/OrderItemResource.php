<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'order_no' => $this->order_no,
            'user' => new ProfileResource($this->user),
            'product' => new ProductResource($this->product),
            'quantity' => $this->quantity,
            'total_price' => $this->total_price,
            'discount_percent' => $this->discount_percent,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ];
    }
}
