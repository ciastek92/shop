<?php

namespace Tests\Feature\Api;

use App\Models\Product;
use App\Models\ProductPrices;
use App\Models\ProductPriceTypes;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductTest extends ApiTest
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    protected $productPriceTypes;

    public function setUp()
    {
        parent::setUp();
        $this->productPriceTypes = $this->setUpProductPriceTypes();
    }

    public function test_if_products_are_created_correctly()
    {
        $payload = $this->createPayloadForProduct($this->createDefaultProductAttributesArray());


        $response = $this->json('POST', '/api/product', $payload)
            ->assertStatus(201)
            ->assertJson([
                'name' => 'Potato',
                'description' => 'Potato that everybody loves',
                'prices' => [
                    [
                        'type' => $this->getProductPriceType()->name,
                        'price' => '200'
                    ]
                ]
            ]);
    }

    public function test_if_products_data_is_validated_correctly()
    {
        //without adding name
        $payloadWithoutName = $this->createPayloadForProduct(
            ['description' => 'some kind of descritpion', 'prices' => $this->getDefaultPricesTestArray()],
            true);

        $response = $this->json('POST', '/api/product', $payloadWithoutName)
            ->assertStatus(422)
            ->assertJson([
                'error' => 'Sorry, something went wrong.',
                'errors' => [
                    'product.name' => ['The product.name field is required.']
                ]
            ]);

        //without adding description
        $payloadWithoutDescription = $this->createPayloadForProduct(
            ['name' => 'productName', 'prices' => $this->getDefaultPricesTestArray()],
            true);
        $response = $this->json('POST', '/api/product', $payloadWithoutDescription)
            ->assertStatus(422)
            ->assertJson([
                'error' => 'Sorry, something went wrong.',
                'errors' => [
                    'product.description' => ['The product.description field is required.']
                ]
            ]);

        //without adding prices
        $payloadWithoutPrices = $this->createPayloadForProduct(['name' => 'productName',
            'description' => 'some description'], true);

        $response = $this->json('POST', '/api/product', $payloadWithoutPrices)
            ->assertStatus(422)
            ->assertJson([
                'error' => 'Sorry, something went wrong.',
                'errors' => [
                    'product.prices' => ['The product.prices field is required.']
                ]
            ]);
    }

    public function test_if_products_are_updated_correctly()
    {
        $product = factory(Product::class)->create([
            'name' => 'Tomato',
            'description' => 'Tomato is red and juicy',
        ]);
        $productPrice = factory(ProductPrices::class)->create([
            'type_id' => $this->getProductPriceType()->id, 'price' => '200', 'product_id' => $product->id]);

        $payload = $this->createPayloadForProduct([
            'name' => 'Big tomato',
            'description' => 'new changed, bigger tomato',
            'prices' => [['type_id' => $this->getProductPriceType()->id, 'price' => 300]]]);


        $response = $this->json('PUT', '/api/product/' . $product->id, $payload)
            ->assertStatus(200)
            ->assertJson([
                'name' => 'Big tomato',
                'description' => 'new changed, bigger tomato',
                'prices' => [
                    [
                        'type' => $this->getProductPriceType()->name,
                        'price' => '300'
                    ]
                ]
            ]);
        $this->assertDatabaseHas('products', [
            'name' => 'Big tomato',
            'description' => 'new changed, bigger tomato',
        ]);
        $this->assertDatabaseHas('product_prices', [
            'type_id' => $this->getProductPriceType()->id,
            'price' => '300',
            'product_id' => $product->id
        ]);
    }

    public function test_if_products_are_deleted_correctly()
    {
        $product = factory(Product::class)->create([
            'name' => 'Apple',
            'description' => 'Apple is red and round',
        ]);
        $productPrice = factory(ProductPrices::class)->create([
            'type_id' => $this->getProductPriceType()->id, 'price' => '2454', 'product_id' => $product->id]);

        $response = $this->json('DELETE', '/api/product/' . $product->id)
            ->assertStatus(204);

        $this->assertDatabaseMissing('products', [
            'name' => 'Apple',
            'description' => 'Apple is red and round',
        ]);
        $this->assertDatabaseMissing('product_prices', [
            'product_id' => $product->id,
            'type_id' => $this->getProductPriceType()->id
        ]);
    }


    private function getProductPriceType($element = 0): ProductPriceTypes
    {
        if (!isset($this->productPriceTypes)) {
            throw new \Exception('Wrong element number');
        }
        return $this->productPriceTypes[$element];
    }

    private function createPayloadForProduct(array $attributes = [], bool $filter = false)
    {
        $payload = [
            'product' => [
                'name' => $attributes['name'] ?? null,
                'description' => $attributes['description'] ?? null,
                'prices' => $attributes['prices'] ?? null
            ]
        ];

        if ($filter) {
            foreach ($payload as $key => $value) {
                // If value is empty, skip it
                if (empty($value)) continue;
                unset($value[$key]);
            }
        }

        return $payload;
    }

    private function createDefaultProductAttributesArray(?string $name = null, ?string $description = null, ?array $prices = null)
    {
        return [
            'name' => $name ?? 'Potato',
            'description' => $description ?? 'Potato that everybody loves',
            'prices' => $prices ?? $this->getDefaultPricesTestArray()
        ];
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