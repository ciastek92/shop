<?php

namespace Tests\Feature\Api;

use App\Models\ProductPriceTypes;
use App\User;
use Tests\TestCase;

abstract class ApiTest extends TestCase
{
    /**
     * @var User
     */
    protected $user;

    public function setUp()
    {
        parent::setUp();
//        $this->setUser();
    }

    protected function setUser($user = null)
    {
        if ($user) {
            $this->user = $user;
            return;
        }

        $this->user = factory(User::class)->create();
        $token = $this->user->createToken('api');
        $headers = ['Authorization' => "Bearer $token"];
    }

    protected function setUpProductPriceTypes($number = 2)
    {
        $productPriceTypes[] = factory(ProductPriceTypes::class)->create(
            ['name' => 'netto', 'id' => 1]
        );
        $productPriceTypes[] = factory(ProductPriceTypes::class)->create(
            ['name' => 'brutto', 'id' => 2]
        );

        if ($number > 2) {
            $productPriceTypes[] = factory(ProductPriceTypes::class, $number - 2)->create();
        }

        return $productPriceTypes;

    }
}