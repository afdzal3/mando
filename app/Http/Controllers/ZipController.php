<?php

namespace App\Http\Controllers;

use App\Models\InputAddress;
use App\Models\RevAddress;
use App\Models\InputError;
use App\Models\Zip;
use App\Common\CommonHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr\Cast\Array_;
use SebastianBergmann\Environment\Console;
use Hotmeteor\Regex\Regex;


class ZipController extends Controller
{

    public function popZip(Request $req)
    {
        ini_set('max_execution_time', '3000');
        set_time_limit(300);


        $ius =  InputAddress::all();

        foreach ($ius as $iu) {
            $numpattern = "/^([0-9]+)$/";
            preg_match($numpattern, $iu->zip, $zip_is_number);

            $check = true;
            if (!$zip_is_number) {
                $ie = CommonHelper::insLog($iu->cust_id, 'zip', $iu->zip, '', 'unresolved');

                $check = false;
            }

            $state_is_alpha = Regex::isAlpha($iu->d_state_name, $allowWhitespace = true);
            if (!$state_is_alpha) {
                $ie = CommonHelper::insLog($iu->cust_id, 'zip', $iu->zip, '', 'unresolved');
                $check = false;
            }


            if ($check) {
                $z = Zip::where('zip', $iu->zip)
                    ->where('city', $iu->city)
                    ->where('d_state_name', $iu->d_state_name)
                    ->where('country_code', $iu->country_code)->first();



                if ($z) {
                    $z->mark = $z->mark + 1;
                    $z->save();
                } else {
                    $newZip = new Zip;
                    $newZip->zip = $iu->zip;
                    $newZip->city = $iu->city;
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

    public function updRevZip(Request $req)
    {


        $revs = $this->getErrorRev()['data'];
        foreach ($revs as $rev) {


            $resolve = false;

            $numpattern = "/^([0-9]+)$/";
            preg_match($numpattern, $rev->zip, $zip_is_number);

            $state_is_alpha = Regex::isAlpha($rev->d_state_name, $allowWhitespace = true);

            //error 1
            if (!$state_is_alpha && $resolve == false) {
                $z = Zip::where('zip', $rev->zip)->where('city', $rev->city)
                    ->where('country_code', $rev->country_code)
                    ->orderBy('mark', 'DESC')->first();

                // dd($rev);

                if ($z) {
                    CommonHelper::insLog($rev->cust_id, 'd_state_name', $rev->d_state_name, $z->d_state_name, 'resolved');
                    $rev->d_state_name = $z->d_state_name;
                    $rev->save();
                    $resolve = true;
                }
            }

            //error 2
            if (!$zip_is_number && $resolve == false) {
                $z = Zip::where('city', $rev->city)
                    ->where('d_state_name', $rev->d_state_name)
                    ->where('country_code', $rev->country_code)
                    ->orderBy('mark', 'DESC')->first();

                // dd($rev);

                if ($z) {
                    CommonHelper::insLog($rev->cust_id, 'zip', $rev->zip, $z->zip, 'resolved');
                    $rev->zip = $z->zip;
                    $rev->save();
                    $resolve = true;
                }
            }

            //error 3
            if (!$zip_is_number && $resolve == false) {
                CommonHelper::insLog($rev->cust_id, 'zip', $rev->zip, '', 'unresolved');
                $rev->zip = '';
                $rev->save();
            }
            //error 4
            if (!$state_is_alpha && $resolve == false) {
                CommonHelper::insLog($rev->cust_id, 'd_state_name', $rev->d_state_name, '', 'unresolved');
                $rev->d_state_name = '';
            }
        }


        return redirect(backpack_url('rev-address'));
    }



    public function getErrorRev()
    {

        $revs = RevAddress::from('rev_addresses as rv')->leftJoin('zips', function ($join) {
            $join->on('zips.zip', '=', 'rv.zip');
            $join->on('zips.city', '=', 'rv.city');
            $join->on('zips.d_state_name', '=', 'rv.d_state_name');
            $join->on('zips.country_code', '=', 'rv.country_code');
        })
            ->where('zips.id', '=', NULL)
            ->get(['rv.*', 'zips.zip as z_zip', 'zips.city as z_city', 'zips.d_state_name as z_d_state_name', 'zips.country_code as z_country_code']);

        return ['count' => count($revs), 'data' => $revs];
    }

    public function checkAddress(Request $req)
    {

    


        $addr_supp = $req->addr_supp;
        $street_addr = $req->street_addr ;
        $d_street_addr_3 = $req->d_street_addr_3 ;
        $d_street_addr_4 = $req->d_street_addr_4 ;
        $zip = $req->zip ;
        $city = $req->city ;
        $d_state_name = $req->d_state_name ;
        $country_code = $req->country_code ;


        $numpattern = "/^([0-9]+)$/";
        preg_match($numpattern, $zip, $zip_is_number);
        $state_is_alpha = Regex::isAlpha($d_state_name, $allowWhitespace = true);
        
        $addr_status = 'OK';
        if( $state_is_alpha ){
            $msg[]='State is accepted';
        }else{
            $msg[]='State is not accepted';
            $addr_status = 'NOT OK';
        }

        if( $zip_is_number ){
            $msg[]='Zip is accepted';
        }else{
            $msg[]='Zip is not accepted';
            $addr_status = 'NOT OK';
        }




    

        return response()->json([
            'msg'=>$msg,
            'status'=>$addr_status,

            'original_req' => $req,




       
        ]);
/*
        return $this->respond_json(200, 'Success', [
            'req' => $req
        ]);
        */
    }
}
