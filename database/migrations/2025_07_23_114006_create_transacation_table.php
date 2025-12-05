<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'transacation',
            function (Blueprint $table) {
                $table->id();
                $table->string('user_id')->nullable();
                $table->string('subscription_id')->nullable();
                $table->string('amount')->nullable();
                $table->string('payment_method')->nullable();
                $table->string('status')->default('pending');
                $table->string('transaction_id')->nullable();
                $table->string('currency')->default('IND');
                $table->string('description')->nullable();
                $table->string('duration')->nullable();
                $table->string('is_current')->nullable();
                $table->string('start_date')->nullable();
                $table->string('end_date')->nullable();
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('transacation');
    }
};
