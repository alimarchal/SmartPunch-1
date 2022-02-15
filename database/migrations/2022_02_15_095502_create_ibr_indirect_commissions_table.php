<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIbrIndirectCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ibr_indirect_commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ibr_no')->constrained('ibrs');
            $table->foreignId('referencee_ire_no')->constrained('ibrs');
            $table->decimal('amount',14);
            $table->tinyInteger('status')->default(0);      /* 0 => unpaid-unverified, 1 => unpaid-verified, 2 => paid */
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
        Schema::dropIfExists('ibr_indirect_commissions');
    }
}
