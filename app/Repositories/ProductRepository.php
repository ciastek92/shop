<?php

namespace App\Repositories;

use App\Models\Product;
use Ciastek92\RepositoryMaker\Repositories\BaseRepository;

class ProductRepository extends BaseRepository
{

    public function store(array $inputs)
    {
        return parent::store($inputs);
    }

    public function model()
    {
        return Product::class;
    }
}