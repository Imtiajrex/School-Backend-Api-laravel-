<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeBaseInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_base_info', function (Blueprint $table) {
            $table->id();
            $table->string("employee_name");
            $table->string("employee_type");
            $table->string("employee_post");
            $table->string("employee_gender");
            $table->string("employee_religion");
            $table->string("employee_nationality");
            $table->string("employee_primary_phone", 25);
            $table->string("employee_secondary_phone", 25);
            $table->string("employee_email");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_base_info');
    }
}
