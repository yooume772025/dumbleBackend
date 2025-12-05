<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'device_infos', function (Blueprint $table) {
                $table->id();
                $table->string('phone_name')->nullable();
                $table->string('phone_no')->nullable();
                $table->string('phone_address')->nullable();
                $table->ipAddress('ip_address')->nullable();
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('device_infos');
    }
};
