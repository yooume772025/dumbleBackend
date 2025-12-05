<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'users',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name')->nullable();
                $table->string('facebook_id')->nullable();
                $table->string('google_id')->nullable();
                $table->string('location')->nullable();
                $table->string('first_name')->nullable();
                $table->string('last_name')->nullable();
                $table->string('email')->nullable();
                $table->string('mobile', 50)->nullable();
                $table->string('password')->nullable();
                $table->integer('status')->default(1);
                $table->string('otp')->nullable();
                $table->string('dob')->nullable();
                $table->string('age')->nullable();
                $table->string('about_me')->nullable();
                $table->text('photo_url')->nullable();
                $table->string('show_gender')->nullable();
                $table->string('looking_for')->nullable();
                $table->string('gender_id')->nullable();
                $table->string('sub_gender_id')->nullable();
                $table->string('height_id')->nullable();
                $table->string('relation_id')->nullable();
                $table->string('language')->nullable();
                $table->string('latitude', 500)->nullable();
                $table->string('longitude', 500)->nullable();
                $table->rememberToken();
                $table->timestamps();
                $table->string('education_label')->nullable();
                $table->string('zodaic_sign')->nullable();
                $table->string('work_out')->nullable();
                $table->string('exercise')->nullable();
                $table->string('pronounce')->nullable();
                $table->string('device')->nullable();
                $table->string('ip')->nullable();
                $table->string('education')->nullable();
                $table->string('Institute')->nullable();
                $table->string('year', 20)->nullable();
                $table->string('intersets')->nullable();
                $table->integer('hide_name')->default(0);
                $table->string('home_town')->nullable();
                $table->string('current_city')->nullable();
                $table->string('verified')->nullable();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
