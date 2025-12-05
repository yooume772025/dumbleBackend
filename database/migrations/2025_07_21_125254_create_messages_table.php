<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'messages',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('sender_id');
                $table->unsignedBigInteger('receiver_id');
                $table->text('message');
                $table->tinyInteger('is_read')->default(0);
                $table->string('file_path')->nullable();
                $table->string('file_type')->nullable();
                $table->string('status')->default(0)->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
