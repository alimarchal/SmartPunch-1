<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePunchTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('punch_tables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('office_id');
            $table->string('business_id');
            $table->string('mac_address');
            $table->dateTime('time');
            $table->tinyInteger('in_out_status');               /* 1 for in and 0 for out */
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('offices', function (Blueprint $table) {
            $table->foreignId('office_id')->nullable()->references('id')->on('offices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('punch_tables');
    }
}
