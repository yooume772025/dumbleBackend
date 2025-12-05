<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'sub_service',
            function (Blueprint $table) {
                $table->increments('id');
                $table->integer('service_id')->nullable();
                $table->string('sub_service_name');
                $table->string('logo')->nullable();
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->nullable();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_service');
    }
};
