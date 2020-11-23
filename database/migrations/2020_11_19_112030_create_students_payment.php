<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_payment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("student_id");
            $table->unsignedBigInteger("payment_category_id");
            $table->string("payment_info");
            $table->float("payment_amount");
            $table->float("paid_amount");
            $table->boolean("payment_status");
            $table->date("date");
            $table->time("time");

            $table->foreign("student_id")->references("id")->on("students_base_info")->onDelete('cascade');
            $table->foreign("payment_category_id")->references("id")->on("payment_category")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students_payment');
    }
}
