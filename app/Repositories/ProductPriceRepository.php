<?php

namespace App\Repositories;

use App\Models\ProductPrices;
use App\Models\ProductPriceTypes;
use DB;
use App\Models\Product;
use Ciastek92\RepositoryMaker\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductPriceRepository extends BaseRepository
{

    /**
     * @param array $inputs
     * @return mixed
     */
    public function store(array $inputs)
    {
        $type = ProductPriceTypes::findOrFail($inputs['type_id']);
        $productPrice = new ProductPrices($inputs);
        return $productPrice;
    }

    public function addNewPriceToProduct(Product $product, array $inputs)
    {
        $productPrice = $this->store($inputs);
        $product->prices()->save($productPrice);
        return $productPrice;
    }

    /**
     * @param Product $product
     * @param int $productPriceTypesId
     * @param array $inputs
     * @return \Illuminate\Database\Eloquent\Model|null|static
     * @throws \Exception
     */
    public function updatePrice(Product $product, int $productPriceTypesId, array $inputs)
    {
        ProductPriceTypes::findOrFail($productPriceTypesId);

        $productPrice = $product->prices()->where('type_id', $productPriceTypesId)->first();
        if (!$productPrice) {
            throw new \Exception('Could\'n find price of this type within that product');
        }
        $productPrice->price = $inputs['price'];
        $productPrice->save();
        return $productPrice;
    }

    /**
     * @param Product $product
     * @param int $productPriceTypesId
     * @return bool
     * @throws \Exception
     */
    public function deletePrice(Product $product, int $productPriceTypesId)
    {
        ProductPriceTypes::findOrFail($productPriceTypesId);
        $productPrice = $product->prices()->where('type_id', $productPriceTypesId)->first();
        if (!$productPrice) {
            throw new \Exception('Could\'n find price of this type within that product');
        }
        return $productPrice->delete();
    }

    public function model()
    {
        return ProductPrices::class;
    }
}