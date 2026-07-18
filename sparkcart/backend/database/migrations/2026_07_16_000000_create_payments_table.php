<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('merchant_request_id')->nullable();
            $table->string('checkout_request_id')->nullable();
            $table->string('status')->nullable();
            $table->integer('result_code')->nullable();
            $table->string('result_desc')->nullable();
            $table->string('phone_number')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('account_reference')->nullable();
            $table->string('transaction_desc')->nullable();
            $table->json('callback_payload')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
