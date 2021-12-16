<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_types', function (Blueprint $table) {
            $table->id();
            $table->string('schedule_name');
            $table->string('business_id')->nullable();
            $table->string('office_id')->nullable();
            $table->timestamps();
        });

        DB::table('schedule_types')->insert([
            'schedule_name' => 'regular',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('schedule_types')->insert([
            'schedule_name' => 'morning shift',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('schedule_types')->insert([
            'schedule_name' => 'evening shift',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('schedule_types')->insert([
            'schedule_name' => 'night shift',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('schedule_types')->insert([
            'schedule_name' => 'special shift',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedule_types');
    }
}
