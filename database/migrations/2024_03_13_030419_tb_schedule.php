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
        Schema::create('tb_schedule', function (Blueprint $table) {
            $table->uuid('id_schedule')->primary()->unique()->index();
            $table->uuid('doctor_id');
            $table->enum('days', ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']);
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();

            $table->foreign('doctor_id')->references('id_doctor')->on('tb_doctor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_schedule');
    }
};
