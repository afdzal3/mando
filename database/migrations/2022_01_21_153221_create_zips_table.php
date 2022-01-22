<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zips', function (Blueprint $table) {
            $table->id();
            $table->string('zip',255);
            $table->string('d_state_name',255);
            $table->string('country_code',255)->nullable();
            $table->integer('mark')->nullable();

            $table->timestamps();

            $table->unique(['zip', 'd_state_name', 'country_code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zips');
    }
}
