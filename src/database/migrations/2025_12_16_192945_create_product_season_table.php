<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSeasonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_season', function (Blueprint $table) {
            $table->id();   //id(PRIMARY KEY,NOT NULL)
            $table->foreignId('product_id')->constrained()->onDelete('cascade');    //product_id(bigint unsigned,NOT NULL,外部キー)
            $table->foreignId('season_id')->constrained()->onDelete('cascade');  //season_id(bigint unsigned,NOT NULL,外部キー)
            $table->timestamps();   //created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_season');
    }
}
