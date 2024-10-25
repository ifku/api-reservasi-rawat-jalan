<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $days = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
        for ($i = 0; $i < 7; $i++) {
            DB::table('tb_schedule')->insert([
                'id_schedule' => Uuid::uuid4(),
                'doctor_id' => '7ab1bb20-661c-4520-a3df-9ba147f4c79c',
                'days' => $days[$i],
                'start_time' => '08:00:00',
                'end_time' => '17:00:00',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
