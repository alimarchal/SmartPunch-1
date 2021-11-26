<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIbrIndirectCommisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ibr_indirect_commisions', function (Blueprint $table) {
            $table->id();
            $table->string('ire_no')->nullable();
            $table->string('referencee_ire_no')->nullable();
            $table->decimal('amount',2)->nullable();
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
        Schema::dropIfExists('ibr_indirect_commisions');
    }
}
