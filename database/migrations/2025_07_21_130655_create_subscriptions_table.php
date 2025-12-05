<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'subscriptions',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('product_id')->nullable();
                $table->string('name');
                $table->decimal('price', 8, 2);
                $table->string('duration');
                $table->string('product_type')->nullable();
                $table->string('description')->nullable();
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
