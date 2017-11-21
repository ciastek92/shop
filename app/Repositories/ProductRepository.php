<?php

namespace App;

use Ciastek92\RepositoryMaker\Repositories\BaseRepository;

class ProductRepository extends BaseRepository
{

    public function store(array $inputs)
    {
        return parent::store($inputs);
    }
}