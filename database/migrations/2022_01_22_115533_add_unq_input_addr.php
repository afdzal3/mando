<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnqInputAddr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
   


        try {
            Schema::table('input_addresses', function (Blueprint $table) {
                //

                $table->dropUnique(['cust_id']);
            });
        } catch (Exception $e) {
        }

        Schema::table('input_addresses', function (Blueprint $table) {
            $table->unique(['cust_id'], 'unq_inputt1');
        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('input_addresses', function (Blueprint $table) {
            //
        });
    }
}
