<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'user_educations',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('user_id')->nullable();
                $table->string('institute')->nullable();
                $table->string('course')->nullable();
                $table->string('year')->nullable();
                $table->integer('status')->default(1);
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->nullable()->default(null);
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('user_educations');
    }
};
