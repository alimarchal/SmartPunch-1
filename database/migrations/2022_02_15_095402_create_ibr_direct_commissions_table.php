<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIbrDirectCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ibr_direct_commissions', function (Blueprint $table) {
            $table->id();
            $table->string('ibr_no');
            $table->foreignId('transaction_id')->constrained();
            $table->decimal('amount',12);
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
        Schema::dropIfExists('ibr_direct_commissions');
    }
}
