<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsBaseInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_base_info', function (Blueprint $table) {
            $table->id();
            $table->string("student_name");
            $table->string("student_image");
            $table->string("gender");
            $table->string("age");
            $table->string("primary_phone");
            $table->string("secondary_phone");
            $table->string("student_email");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students_base_info');
    }
}
