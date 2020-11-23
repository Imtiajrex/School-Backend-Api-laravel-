<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_category', function (Blueprint $table) {
            $table->id();
            $table->string('category_name');
            $table->string('info_type');
            $table->string('info_options', 750);
            $table->float('default_amount');
            $table->string('recurring_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_category');
    }
}
