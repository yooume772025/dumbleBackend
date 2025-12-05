<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'matching_user',
            function (Blueprint $table) {
                $table->id();
                $table->string('user_id', 50)->nullable();
                $table->string('pre_user_id', 50)->nullable();
                $table->string('status', 50)->default('0');
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->nullable();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('matching_user');
    }
};
