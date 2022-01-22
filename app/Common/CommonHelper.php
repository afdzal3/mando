<?php

namespace App\common;

use App\Models\InputError;


class CommonHelper
{
  public static function insLog($cust_id, $error_field, $err_value, $revise_value, $status)
  {
    $ier = "";
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

    $ier->cust_id = $cust_id;
    $ier->error_field = $error_field;
    $ier->err_value = $err_value;
    $ier->revise_value = $revise_value;
    $ier->status = $status;


    $ier->save();





    return $ier;
  }
}
