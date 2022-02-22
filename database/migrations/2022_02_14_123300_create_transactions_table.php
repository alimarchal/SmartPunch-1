<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained()->onDelete('cascade');
            $table->foreignId('package_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('package_type')->nullable();  /* null => trail package, 1 => monthly, 2 => quarterly, 3 => half year, 4 => yearly  */
            $table->string('card_number')->nullable();
            $table->tinyInteger('cvv')->nullable();
            $table->date('card_valid_from')->nullable();
            $table->date('card_valid_to')->nullable();
            $table->integer('amount');
            $table->string('bank_name')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
