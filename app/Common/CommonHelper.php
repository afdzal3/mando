<?php

namespace App\common;

use App\Models\InputError;
use App\Models\RevAddress;


class CommonHelper
{
  public static function insLog($cust_id, $error_field, $err_value, $revise_value, $status)
  {
    $ier = "";
    /** 
    if ($status == 'resolved') {
      $cexist = InputError::where('cust_id', $cust_id)
        ->where('error_field', $error_field)
        ->where('status', $status)->first();
      if ($cexist) {
        $ier = InputError::find($cexist->id);
      } else {
        $ier = new InputError;
      }
    } else {
      $ier = new InputError;
    }



    **/

    $cexist = InputError::where('cust_id', $cust_id)
    ->where('error_field', $error_field)
    ->first();
    if ($cexist) {
      $ier = InputError::find($cexist->id);
    } else {
      $ier = new InputError;
    }
    
    $ier->cust_id = $cust_id;
    $ier->error_field = $error_field;
    $ier->err_value = $err_value;
    $ier->revise_value = $revise_value;
    $ier->status = $status;
    $ier->save();
    return $ier;
  }


  public function getUnmappedRev()
  {

      $revs = RevAddress::from('rev_addresses as rv')
      ->select(['rv.*', 'zips.zip as z_zip', 'zips.city as z_city', 'zips.d_state_name as z_d_state_name', 'zips.country_code as z_country_code'])
      ->leftJoin('zips', function ($join) {
          $join->on('zips.zip', '=', 'rv.zip');
          $join->on('zips.city', '=', 'rv.city');
          $join->on('zips.d_state_name', '=', 'rv.d_state_name');
          $join->on('zips.country_code', '=', 'rv.country_code');
      })
          ->where('zips.id', '=', NULL);
          //->get(['rv.*', 'zips.zip as z_zip', 'zips.city as z_city', 'zips.d_state_name as z_d_state_name', 'zips.country_code as z_country_code']);
          return $revs;
    }

   
}
