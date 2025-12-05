<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'hometowns',
            function (Blueprint $table) {
                $table->id();
                $table->string('city_name', 100);
                $table->string('state', 100)->nullable();
                $table->string('country', 100)->default('India');
                $table->decimal('latitude', 10, 8)->nullable();
                $table->decimal('longitude', 11, 8)->nullable();
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('hometowns');
    }
};
