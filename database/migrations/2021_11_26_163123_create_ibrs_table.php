<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIbrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ibrs', function (Blueprint $table) {
            $table->id();
            $table->string('ibr_no')->unique();
            $table->string('referred_by')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('verify_token')->nullable();
            $table->tinyInteger('verified')->default(0); /* 0 not verified and 1 for verified */
            $table->integer('otp')->nullable(); /* Used for verification when user registers from mobile APP */
            $table->string('password');
            $table->string('remember_token')->nullable();
            $table->integer('gender'); /* 1 for Male, 2 for Female, 3 Other */
            $table->integer('country_of_business');
            $table->integer('city_of_business');
            $table->integer('country_of_bank');
            $table->string('bank');
            $table->string('iban');
            $table->integer('currency');
            $table->string('mobile_number');
            $table->date('dob');
            $table->integer('rtl')->default(1); /* 1 for rtl and 0 for ltr */
            $table->string('mac_address')->nullable();
            $table->string('device_name')->nullable();
            $table->integer('status')->default(1); /* 1 for active and 0 for non-active  */
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
        Schema::dropIfExists('ibrs');
    }
}
