<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'report_user',
            function (Blueprint $table) {
                $table->id();
                $table->string('user_id')->nullable();
                $table->string('pre_user_id')->nullable();
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->nullable();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('report_user');
    }
};
