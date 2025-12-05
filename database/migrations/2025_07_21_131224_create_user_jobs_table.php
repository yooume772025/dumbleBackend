<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'user_jobs',
            function (Blueprint $table) {
                $table->id();
                $table->string('user_id')->nullable();
                $table->string('title')->nullable();
                $table->string('company')->nullable();
                $table->integer('status')->default(1);
                $table->timestamp('created_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('user_jobs');
    }
};
