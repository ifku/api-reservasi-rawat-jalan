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
        Schema::create('tb_patient', function (Blueprint $table) {
            $table->uuid('id_patient')->primary()->unique()->index();
            $table->string('patient_fullname')->nullable();
            $table->string('patient_nik')->unique();
            $table->timestamp('patient_date_of_birth')->nullable();
            $table->string('patient_phone')->nullable();
            $table->uuid('user_id');
            $table->uuid('patient_status_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id_user')->on('tb_users');
            $table->foreign('patient_status_id')->references('id_patient_status')->on('tb_patient_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_patient');
    }
};
