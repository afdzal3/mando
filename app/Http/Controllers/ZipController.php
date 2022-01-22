<?php

namespace App\Http\Controllers;

use App\Models\InputAddress;
use App\Models\Zip;
use Illuminate\Http\Request;

class ZipController extends Controller
{

    public function popZip(Request $req)
    {

        $ius =  InputAddress::all();

        foreach ($ius as $iu) {

            if ($iu->d_state_name != '#') {
                $z = Zip::where('zip', $iu->zip)
                    ->where('d_state_name', $iu->d_state_name)
                    ->where('country_code', $iu->country_code)->first();



                if ($z) {

                    $z->mark = $z->mark + 1;
                    $z->save();
                } else {
                    $newZip = new Zip;
                    $newZip->zip = $iu->zip;
                    $newZip->d_state_name = $iu->d_state_name;
                    $newZip->country_code = $iu->country_code;
                    $newZip->mark = 1;
                    $newZip->save();
                }
            }
        }




        return redirect(backpack_url('input-address'));
    }

    public function truncateZip(Request $req)
    {
        Zip::truncate();
        return redirect(backpack_url('zip'));
    }
}
