<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'countries',
            function (Blueprint $table) {
                $table->id();
                $table->string('name', 100);
                $table->string('iso_code', 2);
                $table->string('country_code', 5);
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->nullable();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
