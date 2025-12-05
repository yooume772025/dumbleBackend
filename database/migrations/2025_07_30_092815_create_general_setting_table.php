<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'general_setting', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->string('like_limit')->nullable();
                $table->string('duration')->nullable();
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('general_setting');
    }
};
