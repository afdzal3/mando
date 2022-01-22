<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRevAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rev_addresses', function (Blueprint $table) {
            $table->id();

            $table->integer('cust_id')->unique;
            $table->string('addr_supp',255)->nullable();
            $table->string('street_addr',255)->nullable();
            $table->string('d_street_addr_3',255)->nullable();
            $table->string('d_street_addr_4',255)->nullable();
            $table->string('zip',255)->nullable();
            $table->string('city',255)->nullable();
            $table->string('d_state_name',255)->nullable();
            $table->string('country_code',255)->nullable();
            $table->integer('error_count')->nullable();

            
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
        Schema::dropIfExists('rev_addresses');
    }
}
