<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'caption_master',
            function (Blueprint $table) {
                $table->id();
                $table->integer('user_id')->nullable();
                $table->string('caption_name');
                $table->time('created_at')->useCurrent();
                $table->timestamp('updated_at')->nullable();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('caption_master');
    }
};
