<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_reservation', function (Blueprint $table) {
            $table->string('id_reservation')->primary()->unique()->index();
            $table->enum('reservation_status', ['Pending', 'Done', 'Canceled'])->default('Pending');
            $table->enum('reservation_insurance_type', ['BPJS', 'Insurance', 'Personal'])->default('Personal');
            $table->dateTime('reservation_date');
            $table->uuid('patient_id');
            $table->uuid('doctor_id');
            $table->uuid('user_id');
            $table->timestamps();

            $table->foreign('doctor_id')->references('id_doctor')->on('tb_doctor');
            $table->foreign('patient_id')->references('id_patient')->on('tb_patient');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
