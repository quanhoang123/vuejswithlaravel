<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('id_type')->unsigned();
            $table->string('description');
            $table->integer('unit_price');
            $table->integer('promotion_price');
            $table->string('image');
            $table->string('unit');
            $table->string('new');
            $table->timestamps();
        });
        Schema::table('products',function($table){
            $table->foreign('id_type')->references('id')->on('type_products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}
