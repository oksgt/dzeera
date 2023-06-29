<?php

use \App\Models\User;
use \App\Models\Transaction;
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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'user_id');
            $table->foreignId('trans_id')->references('id')->on('transactions');
            $table->foreignId('payment_opt_id')->references('id')->on('payment_options');
            $table->foreignId('bank_id')->references('id')->on('bank_accounts')->nullable()->constrained();
            $table->enum('payment_status', ['confirmed', 'decline', 'unconfirmed'])->default('unconfirmed');
            $table->string('payment_info');
            $table->string('attachment');
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
        Schema::dropIfExists('payments');
    }
};
