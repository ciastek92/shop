<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductPriceTypes;
use Ciastek92\RepositoryMaker\Repositories\BaseRepository;

class ProductRepository extends BaseRepository
{

    public function store(array $inputs)
    {
        $product = parent::store($inputs);

        $product->prices()->createMany($inputs['prices']);

        $product->save();
    }

    public function model()
    {
        return Product::class;
    }
}