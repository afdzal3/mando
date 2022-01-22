<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInputErrorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('input_errors', function (Blueprint $table) {
            $table->id();
            $table->integer('cust_id');
            $table->string('error_field',255);
            $table->string('err_value',255)->nullable();
            $table->string('revise_value',255)->nullable();
            $table->string('status',20)->default('unresolved');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('input_errors');
    }
}
