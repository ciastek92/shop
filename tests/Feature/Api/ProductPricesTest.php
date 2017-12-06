<?php

namespace Tests\Feature\Api;

use App\Models\Product;
use App\Models\ProductPrices;
use App\Models\ProductPriceTypes;

class ProductPricesTest extends ApiTest
{
    protected $productPriceTypes;

    public function setUp()
    {
        parent::setUp();
        $this->productPriceTypes = $this->setUpProductPriceTypes();
    }

    public function test_if_product_prices_are_created_correctly()
    {
        $product = $this->createProduct();

        $payload = ['type_id' => $this->getProductPriceType()->id, 'price' => 200];

        $response = $this->json('POST', '/api/product/' . $product->id . '/price', $payload)
            ->assertStatus(201)
            ->assertJson([
                'type' => $this->getProductPriceType()->name,
                'price' => '200'
            ]);
    }

    public function test_if_products_are_updated_correctly()
    {
        $product = $this->createProduct();
        $productPrice = $this->createProductPriceForProduct($product);
        $payload = ['price' => 300];
        $type = $this->getProductPriceType();

        $response = $this->json('PUT', '/api/product/' . $product->id . '/price/' . $type->id, $payload)
            ->assertStatus(200)
            ->assertJson(
                [
                    'type' => $this->getProductPriceType()->name,
                    'price' => '300'
                ]);

        $this->assertDatabaseHas('product_prices', [
            'type_id' => $this->getProductPriceType()->id,
            'price' => '300',
            'product_id' => $product->id
        ]);
    }

    public function test_if_product_prices_are_deleted_correctly()
    {
        $type = $this->getProductPriceType()->id;
        $product = $this->createProduct();
        $productPrice = $this->createProductPriceForProduct($product);

        $response = $this->json('DELETE', '/api/product/' . $product->id . '/price/' . $type)
            ->assertStatus(204);

        $this->assertDatabaseMissing('product_prices', [
            'product_id' => $product->id,
            'type_id' => $this->getProductPriceType()->id
        ]);
    }

    private function createProductPriceForProduct(Product $product)
    {
        return factory(ProductPrices::class)->create([
            'type_id' => $this->getProductPriceType()->id, 'price' => '200', 'product_id' => $product->id]);
    }


    private function getProductPriceType($element = 0): ProductPriceTypes
    {
        if (!isset($this->productPriceTypes)) {
            throw new \Exception('Wrong element number');
        }
        return $this->productPriceTypes[$element];
    }

    private function createProduct()
    {
        $product = factory(Product::class)->create([
            'name' => 'Tomato',
            'description' => 'Tomato is red and juicy',
        ]);
        return $product;
    }

    private function getDefaultPricesTestArray($length = 1)
    {
        return [
            [
                'type_id' => $this->getProductPriceType()->id,
                'price' => '200'
            ]
        ];
    }
}