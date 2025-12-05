<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'block_user',
            function (Blueprint $table) {
                $table->id();
                $table->string('user_id', 20)->nullable();
                $table->string('pre_user_id', 20)->nullable();
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('block_user');
    }
};
