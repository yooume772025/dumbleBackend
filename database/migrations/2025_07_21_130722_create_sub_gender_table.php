<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'sub_gender',
            function (Blueprint $table) {
                $table->id();
                $table->integer('gender_id')->nullable();
                $table->string('sub_gender_name')->nullable();
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->nullable()->default(null);
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_gender');
    }
};
