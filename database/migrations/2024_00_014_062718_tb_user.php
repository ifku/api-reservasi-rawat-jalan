<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbUser extends Migration
{

    public function up()
    {
        Schema::create('tb_users', function (Blueprint $table) {
            $table->uuid('id_user')->primary()->unique()->index();
            $table->string('user_name')->nullable();
            $table->string('user_fullname')->nullable();
            $table->string('user_nik')->unique();
            $table->string('user_email')->unique();
            $table->string('user_phone')->nullable();
            $table->string('user_address')->nullable();
            $table->enum('user_gender', ['MALE', 'FEMALE'])->nullable();
            $table->timestamp('user_date_of_birth')->nullable();
            $table->boolean('is_complete_profile')->default(false);
            $table->integer('role_id')->default(2);
            $table->text('refresh_token')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tb_user');
    }
}
