<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'notification',
            function (Blueprint $table) {
                $table->id();
                $table->integer('sender_id')->nullable();
                $table->integer('receiver_id')->nullable();
                $table->text('message')->nullable();
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->nullable();
                $table->integer('status')->default(0);
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('notification');
    }
};
