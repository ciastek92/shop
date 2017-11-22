<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPrices extends Model
{
    protected $guarded =[];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function type()
    {
        return $this->belongsTo(ProductPriceTypes::class);
    }
}
