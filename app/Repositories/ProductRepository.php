<?php

namespace App\Repositories;

use DB;
use App\Models\Product;
use Ciastek92\RepositoryMaker\Repositories\BaseRepository;

class ProductRepository extends BaseRepository
{

    /**
     * @param array $inputs
     * @return mixed
     */
    public function store(array $inputs)
    {
        $product = DB::transaction(function () use ($inputs) {

            $product = parent::store($inputs);

            $product->prices()->createMany($inputs['prices']);

            $product->save();

            return $product;
        });

        return $product;
    }

    /**
     * @param array $inputs
     * @return mixed
     */
    public function update($id, array $inputs)
    {
        $product = DB::transaction(function () use ($id, $inputs) {
            parent::update($id, $inputs);

            $product = Product::find($id);
            foreach ($inputs['prices'] as $price) {
                $product->prices()->updateOrCreate(
                    [
                        'product_id' => $id,
                        'type_id' => $price['type_id']
                    ],
                    ['price' => $price['price'] ]
                );
            }

            $product->save();

            return $product;
        });

        return $product;
    }

    public function model()
    {
        return Product::class;
    }
}