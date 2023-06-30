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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->enum('product_type', ['single', 'bundle'])->default('single');
            $table->foreignId('category_id')->references('id')->on('categories');
            $table->string('product_sku')->unique();
            $table->string('product_name')->unique();
            $table->string('product_desc')->nullable();
            $table->string('slug', 100)->nullable();
            $table->enum('product_status', ['ready', 'po'])->default('ready');
            $table->string('image_thumb')->nullable();
            $table->enum('product_availability', ['y', 'n'])->default('y');
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
        Schema::dropIfExists('products');
    }
};
