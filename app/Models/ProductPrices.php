<?php

namespace App\Models;

use App\Traits\ModelSupportsCompositeKey;
use Illuminate\Database\Eloquent\Model;

class ProductPrices extends Model
{
    use ModelSupportsCompositeKey;

    public $incrementing = false;
    protected $primaryKey = ['product_id','type_id'];

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
