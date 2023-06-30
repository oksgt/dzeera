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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string("voucher_name", 100);
            $table->string("voucher_desc")->nullable();
            $table->string("code", 10)->unique();
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('is_percent', ['y', 'n'])->default('y');
            $table->integer('value');
            $table->enum('is_active', ['y', 'n'])->default('y');
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
        Schema::dropIfExists('vouchers');
    }
};
