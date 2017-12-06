<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ProductPrices extends Resource
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
                'type' => $this->type->name ?? 'uknown_name',
                'price' => $this->price,
        ];
    }
}
