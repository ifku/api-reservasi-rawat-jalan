<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class ScheduleTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $days = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
        for ($i = 0; $i < 7; $i++) {
            DB::table('tb_schedule_template')->insert([
                'id_schedule_template' => Uuid::uuid4(),
                'doctor_id' => '7ab1bb20-661c-4520-a3df-9ba147f4c79c',
                'days_template' => $days[$i],
                'start_time_template' => '08:00:00',
                'end_time_template' => '17:00:00',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
