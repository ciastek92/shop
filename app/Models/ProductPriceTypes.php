<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPriceTypes extends Model
{
    public $timestamps = false;

    public function price()
    {
        return $this->hasOne(ProductPrices::class);
    }
}
