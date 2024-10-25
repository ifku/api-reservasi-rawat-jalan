<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            ClinicSeeder::class,
            PatientStatusSeeder::class,
            DoctorSeeder::class,
            PatientSeeder::class,
            ReservationSeeder::class,
            ScheduleSeeder::class,
            ScheduleTemplateSeeder::class
        ]);
    }
}
