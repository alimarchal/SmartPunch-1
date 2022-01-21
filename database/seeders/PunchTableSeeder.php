<?php

namespace Database\Seeders;

use App\Models\PunchTable;
use Illuminate\Database\Seeder;

class PunchTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PunchTable::factory()
//            ->count(5)
            ->create();
    }
}
