<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPriceTypes extends Model
{
    public function price()
    {
        return $this->hasOne(ProductPrices::class);
    }
}
