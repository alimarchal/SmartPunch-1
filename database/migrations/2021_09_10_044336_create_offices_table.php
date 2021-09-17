<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('office_name')->nullable();
            $table->string('office_address')->nullable();
            $table->string('office_city')->nullable();
            $table->string('office_coordinates')->nullable();
            $table->string('office_tel')->nullable();
            $table->string('office_email')->nullable();
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
        Schema::dropIfExists('offices');
    }
}
