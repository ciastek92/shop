<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productPriceType = factory(\App\Models\ProductPriceTypes::class)
            ->create(['name' => 'netto']);
        $productPriceType2 = factory(\App\Models\ProductPriceTypes::class)
            ->create(['name' => 'brutto']);

        DB::transaction(function () {
            $products = factory(App\Models\Product::class, 3)
                ->create()
                ->each(function ($p) {
                    $p->prices()->save(factory(App\Models\ProductPrices::class)->make());
                });
        });
    }
}
