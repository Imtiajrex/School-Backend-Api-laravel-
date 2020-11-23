<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsExtendedInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_extended_info', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("student_id");
            $table->json("student_extended_info");


            $table->foreign("student_id")->references("id")->on("students_base_info")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students_extended_info');
    }
}
