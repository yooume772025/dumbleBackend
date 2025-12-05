<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'exercise',
            function (Blueprint $table) {
                $table->id();
                $table->string('exercise')->nullable();
                $table->string('logo')->nullable();
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->nullable();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('exercise');
    }
};
