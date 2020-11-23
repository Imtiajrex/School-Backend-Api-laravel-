<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeSalaryStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_salary_structure', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("employee_id");
            $table->string("salary_details");
            $table->float("total_salary");

            $table->foreign("employee_id")->references("id")->on("employee_base_info")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_salary_structure');
    }
}
