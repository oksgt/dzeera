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
        Schema::create('gifts', function (Blueprint $table) {
            $table->id();
            $table->string('gift_name')->unique();
            $table->string('gift_description');
            $table->integer('is_for_first_purchase');
            $table->decimal('min_purchase_value', 10, 2);
            $table->foreignId('product_id')->references('id')->on('products');
            $table->foreignId('color_opt_id')->references('id')->on('product_color_options');
            $table->foreignId('size_opt_id')->references('id')->on('product_size_options');
            $table->enum('is_active', ['y', 'n'])->default('y');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gifts');
    }
};
