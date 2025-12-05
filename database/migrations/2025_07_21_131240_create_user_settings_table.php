<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'user_settings',
            function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->nullable();
                $table->string('gender', 50)->nullable();
                $table->string('from_age', 50)->nullable();
                $table->string('to_age', 50)->nullable();
                $table->string('language', 50)->nullable();
                $table->string('relation', 50)->nullable();
                $table->string('location')->nullable();
                $table->string('verified_user', 50)->nullable();
                $table->timestamp('created_at')->nullable()->useCurrent();
                $table->timestamp('updated_at')->nullable()->default(null);
                $table->string('mobile')->nullable();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('user_settings');
    }
};
