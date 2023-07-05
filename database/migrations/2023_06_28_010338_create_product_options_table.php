<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->references('id')->on('products');
            $table->string('color');
            $table->string('size');
            $table->integer('stock')->nullable();
            $table->decimal('base_price', 10, 2);
            $table->integer('disc');
            $table->decimal('price', 10, 2);
            $table->string('weight');
            $table->enum('option_availability', ['y', 'n'])->default('y');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_options');
    }
};
