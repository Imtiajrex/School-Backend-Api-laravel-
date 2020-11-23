<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExam extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam', function (Blueprint $table) {
            $table->id();
            $table->string("exam_name");
            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('department_id');
            $table->json("exam_subjects");


            $table->foreign("class_id")->references("id")->on("class")->onDelete('cascade');
            $table->foreign("department_id")->references("id")->on("department")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam');
    }
}
