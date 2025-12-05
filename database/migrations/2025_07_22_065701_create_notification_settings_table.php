<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'notification_settings',
            function (Blueprint $table) {
                $table->id();
                $table->string('user_id')->nullable();
                $table->string('new_message')->nullable();
                $table->string('new_matches')->nullable();
                $table->string('events')->nullable();
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_settings');
    }
};
