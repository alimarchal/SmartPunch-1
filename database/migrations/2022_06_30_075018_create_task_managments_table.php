<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_managments', function (Blueprint $table) {
            $table->id();
            $table->string('task_name')->nullable();
            $table->string('task_progress')->nullable();
            $table->foreignId('business_id')->constrained()->onDelete('cascade');
            $table->foreignId('office_id')->constrained()->onDelete('cascade');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('actual_task_completion_date')->nullable();
            $table->integer('assign_to')->nullable();
            $table->integer('assign_from')->nullable();
            $table->text('from_the_assigner')->nullable();
            $table->text('from_the_assignee')->nullable();
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
        Schema::dropIfExists('task_managments');
    }
};
