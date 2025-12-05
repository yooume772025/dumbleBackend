<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_login', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('app_key')->nullable();
            $table->string('app_secret')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_login');
    }
};
