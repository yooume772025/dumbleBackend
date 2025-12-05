<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'gallery',
            function (Blueprint $table) {
                $table->id();
                $table->integer('user_id')->nullable();
                $table->string('image_path')->nullable();
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->nullable();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('gallery');
    }
};
