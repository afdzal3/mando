<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCityToZips extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('zips', function (Blueprint $table) {
            //
            $table->string('city',255)->after('zip');
            $table->dropUnique(['zip', 'd_state_name', 'country_code']);
            $table->unique(['zip','city', 'd_state_name', 'country_code'],'unq_zip_1');
            
            $table->index(['zip','city', 'd_state_name', 'country_code'],'idx_zip_1');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('zips', function (Blueprint $table) {
            //
        });
    }
}
