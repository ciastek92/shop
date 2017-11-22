<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description'];

    public function prices()
    {
        return $this->hasMany(ProductPrices::class);
    }
}
