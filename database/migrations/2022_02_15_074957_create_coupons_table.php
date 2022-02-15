<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->tinyInteger('amount_type');
            $table->integer('amount');
            $table->date('valid_from');
            $table->date('valid_upto');
            $table->tinyInteger('country')->nullable();
            $table->tinyInteger('consume_status');
            $table->tinyInteger('status')->default(1);      /* 0 => in-active, 1 => active */
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
        Schema::dropIfExists('coupons');
    }
}
