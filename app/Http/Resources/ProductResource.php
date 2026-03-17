<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [

            'id'=>$this->id,
            'title'=>$this->title,
            'price'=>$this->price,
            'price_with_tax'=>$this->price * 1.10,
            'description'=>$this->description,
            'category'=>$this->category,
            'image'=>$this->image,
            'rating_rate'=>$this->rating_rate,
            'rating_count'=>$this->rating_count,
        ];
    }
}