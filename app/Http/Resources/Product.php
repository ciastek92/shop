<?php

namespace App\Http\Resources;

use App\Models\ProductPrices;
use Illuminate\Http\Resources\Json\Resource;

class Product extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'prices' => ProductPricesCollection::collection($this->prices),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
