<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPrices extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function type()
    {
        return $this->hasOne(ProductPriceTypes::class);
    }
}
