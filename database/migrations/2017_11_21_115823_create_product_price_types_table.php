<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductPriceTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_price_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });
        Schema::table('product_prices', function (Blueprint $table) {
            $table->foreign('type_id')->references('id')
                ->on('product_price_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_prices', function (Blueprint $table){
           $table->dropForeign(['type_id']);
        });
        Schema::dropIfExists('product_price_types');
    }
}
