<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstituteInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institute_info', function (Blueprint $table) {
            $table->id();
            $table->string("institute_name");
            $table->string("institute_motto");
            $table->string("institute_shortform");
            $table->string("institute_phonenumbers", 512);
            $table->string("institute_email");
            $table->string("social_media", 512);
            $table->string("institute_address", 512);
            $table->string("institute_logo");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('institute_info');
    }
}
