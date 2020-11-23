<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassDepartmentsHasSubjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_departments_has_subjects', function (Blueprint $table) {
            $table->unsignedBigInteger("class_id");
            $table->unsignedBigInteger("department_id");
            $table->unsignedBigInteger("session_id");
            $table->unsignedBigInteger("subject_id");


            $table->foreign("class_id")->references("id")->on("class");
            $table->foreign("department_id")->references("id")->on("department");
            $table->foreign("session_id")->references("id")->on("session");
            $table->foreign("subject_id")->references("id")->on("subjects");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_departments_has_subjects');
    }
}
