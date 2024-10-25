<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_reservation')->insert([
            'id_reservation' => 'RES-L13Z9VGY',
            'reservation_status' => 'Pending',
            'reservation_insurance_type' => 'Personal',
            'reservation_date' => '2021-10-10',
            'patient_id' => '0dbdbfc0-c881-44e5-b460-7ee48566bf3a',
            'doctor_id' => '7ab1bb20-661c-4520-a3df-9ba147f4c79c',
            'user_id' => 'e15daef5-0dbf-4325-8ad7-b61fde69b8c4',
            'created_at' => '2021-10-10 00:00:00',
            'updated_at' => '2021-10-10 00:00:00'
        ]);
    }
}
