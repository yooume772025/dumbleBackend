<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'zodiac_signs',
            function (Blueprint $table) {
                $table->id();
                $table->string('name', 20);
                $table->string('date_range', 50);
                $table->string('element', 10);
                $table->string('symbol', 30);
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('zodiac_signs');
    }
};
