<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeExtendedInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_extended_info', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("employee_id");
            $table->json("employee_extended_info");

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
        Schema::dropIfExists('employee_extended_info');
    }
}
