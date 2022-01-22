<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnqRevAddr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            Schema::table('rev_addresses', function (Blueprint $table) {
                //

                $table->dropUnique(['cust_id']);
            });
        } catch (Exception $e) {
        }

        Schema::table('rev_addresses', function (Blueprint $table) {
            $table->unique(['cust_id'], 'unq_rev1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rev_addresses', function (Blueprint $table) {
            //
        });
    }
}
