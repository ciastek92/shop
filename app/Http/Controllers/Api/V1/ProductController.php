<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use App\Http\Resources\Product as ProductResource;

class ProductController extends Controller
{

    /**
     * @var ProductRepository
     */
    private $repository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->repository = $productRepository;
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return ProductResource::collection($this->repository->getPaginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreProductRequest $request
     * @return
     */
    public function store(StoreProductRequest $request)
    {
        $createdProduct = $this->repository->store($request->get('product'));
        if (!$createdProduct instanceof Product) {
            throw new \Exception('Not an correct Product instance');
        }
        ProductResource::withoutWrapping();
        $pr = new ProductResource($createdProduct);
        return $pr;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product $product
     * @return ProductResource
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * @param StoreProductRequest $request
     * @param Product $product
     * @return ProductResource
     * @throws \Exception
     */
    public function update(StoreProductRequest $request, Product $product)
    {
        $updatedProduct = $this->repository->update($product->id, $request->get('product'));
        ProductResource::withoutWrapping();
        return new ProductResource($updatedProduct);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
