<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 100; $i++) {
            $appointment = new \App\Models\Appointment();
            $appointment->employee_id = $faker->numberBetween(1, 100);
            $appointment->address_id = $faker->numberBetween(1, 100);
            $appointment->date = $faker->dateTimeBetween('now', '+1 year');
            $appointment->save();
        }
    }
}
