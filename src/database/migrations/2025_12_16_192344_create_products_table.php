<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();   //id(PRIMARY KEY,NOT NULL)
            $table->string('name', 255);  //商品名（varchar(255)かつNOT NULL）
            $table->integer('price');   //商品料金　intかつNOT NULL
            $table->string('image', 255);   //商品画像varchar(255)かつNOT NULL
            $table->text('description');    //textかつNOT NULL
            $table->timestamps();   //create_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
