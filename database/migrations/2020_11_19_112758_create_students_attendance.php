<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsAttendance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_attendance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("student_id");
            $table->string("in_time");
            $table->string("out_time");
            $table->string("attendance_status");
            $table->date("date");

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
        Schema::dropIfExists('students_attendance');
    }
}
