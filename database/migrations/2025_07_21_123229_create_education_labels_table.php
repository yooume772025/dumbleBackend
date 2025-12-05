<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'education_labels',
            function (Blueprint $table) {
                $table->id();
                $table->string('label_en', 100);
                $table->string('label_hi', 100);
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('education_labels');
    }
};
