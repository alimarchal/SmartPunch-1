<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('users');
            $table->decimal('monthly',12);
            $table->decimal('quarterly',12);
            $table->decimal('half_year',12);
            $table->decimal('yearly',12);
            $table->tinyInteger('popular')->default(0);     /* Used to show which package is popular */
            $table->tinyInteger('status')->default(1);     /* 1 => active, 0 => in-active */
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
        Schema::dropIfExists('packages');
    }
}
