<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'super_swipes', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->string('sportlights')->nullable();
                $table->string('price')->nullable();
                $table->string('status')->nullable();
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('super_swipes');
    }
};
