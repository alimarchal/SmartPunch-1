<?php

namespace Database\Factories;

use App\Models\PunchTable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class PunchTableFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PunchTable::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 2,
            'office_id' => 1,
            'business_id' => 1,
            'mac_address' => '00-87-12-02-65-EF',
            'time' => Carbon::today()->subDays(rand(0,255)),
            'in_out_status' => rand(0,1),
        ];
    }
}
