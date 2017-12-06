<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductPriceRequest;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use App\Models\ProductPrices;
use App\Models\ProductPriceTypes;
use App\Repositories\ProductPriceRepository;
use App\Http\Resources\ProductPrices as ProductPricesResource;
use Illuminate\Http\Request;

class ProductPricesController extends Controller
{

    /**
     * @var ProductPriceRepository
     */
    private $repository;

    public function __construct(ProductPriceRepository $productPriceRepository)
    {
        $this->repository = $productPriceRepository;
    }

    /**
     * @param Product $product
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Product $product)
    {
        return ProductPricesResource::collection($product->prices);
    }

    /**
     * @param Product $product
     * @param StoreProductPriceRequest $request
     * @return ProductPricesResource
     */
    public function store(Product $product, StoreProductPriceRequest $request)
    {
        $createdProductPrice = $this->repository->addNewPriceToProduct($product, $request->all());
        ProductPricesResource::withoutWrapping();
        return new ProductPricesResource($createdProductPrice);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product $product
     * @param  \App\Models\ProductPrices $price
     * @return ProductPricesResource
     */
    public function show(Product $product, ProductPrices $price)
    {
        return new ProductPricesResource($price);
    }

    /**
     * @param Product $product
     * @param StoreProductPriceRequest $request
     * @return ProductPricesResource
     * @throws \Exception
     */
    public function update(Product $product, $productPriceTypesId, Request $request)
    {
        $updatedProduct = $this->repository->updatePrice($product, $productPriceTypesId, $request->all());
        ProductPricesResource::withoutWrapping();
        return new ProductPricesResource($updatedProduct);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductPrices $price
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductPrices $price)
    {
        $price->delete();
        return response()->json(['message'=>'deleted successfully'],204);
    }
}
