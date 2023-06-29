<?php

use \App\Models\User;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'user_id');
            $table->string('trans_number')->nullable();
            $table->integer('qty')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->foreignId('voucher_id')->references('id')->on('vouchers')->nullable()->constrained();
            $table->decimal('cut_off_value', 10, 2)->nullable();
            $table->foreignId('expedition_id')->references('id')->on('expeditions')->nullable()->constrained();
            $table->string('expedition_service_type')->nullable();
            $table->decimal('shipping_cost', 10, 2)->nullable();
            $table->string('shipping_code')->nullable();
            $table->decimal('final_price', 10, 2)->nullable();
            $table->string('shipping_address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('notes')->nullable();
            $table->integer('trans_status')->nullable();
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
        Schema::dropIfExists('transactions');
    }
};
