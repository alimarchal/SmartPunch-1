<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_id')->nullable();
            $table->unsignedBigInteger('office_id')->nullable();
            $table->string('employee_business_id')->nullable();
            $table->string('schedule_id')->nullable();
            $table->integer('parent_id')->default(0);
            $table->string('designation');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('user_role');
            $table->string('otp')->nullable();
            $table->string('phone')->nullable();
            $table->string('mac_address')->nullable();
            $table->string('device_name')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->integer('rtl')->default(1);
            $table->integer('type')->default(1);
            $table->integer('status')->default(1);                          /* 0 for Not-active/suspended, 1 for active  */
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
