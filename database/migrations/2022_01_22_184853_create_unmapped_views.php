<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnmappedViews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::statement("
            CREATE VIEW unmapped_views AS
            (
                select `rv`.*, `zips`.`zip` as `z_zip`, `zips`.`city` as `z_city`, 
                `zips`.`d_state_name` as `z_d_state_name`, 
                `zips`.`country_code` as `z_country_code` 
                from `rev_addresses` as `rv` 
                left join `zips` on `zips`.`zip` = `rv`.`zip` 
                and `zips`.`city` = `rv`.`city` 
                and `zips`.`d_state_name` = `rv`.`d_state_name` 
                and `zips`.`country_code` = `rv`.`country_code` 
                where `zips`.`id` is null
            )
          ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unmapped_views');
    }
}
