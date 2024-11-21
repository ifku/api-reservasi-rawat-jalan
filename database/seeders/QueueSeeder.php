<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QueueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_queue')->insert([
            'id_queue' => '43e0715d-f063-4881-ba25-4adb66e0a294',
            'queue_number' => 1,
            'doctor_id' => '7ab1bb20-661c-4520-a3df-9ba147f4c79c',
            'reservation_id' => 'RES-L13Z9VGY',
            'created_at' => '2021-10-10 00:00:00',
            'updated_at' => '2021-10-10 00:00:00'
        ]);
    }
}
