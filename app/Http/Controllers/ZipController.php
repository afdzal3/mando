<?php

namespace App\Http\Controllers;

use App\Models\InputAddress;
use App\Models\RevAddress;
use App\Models\Zip;
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
                $check = false;
            }

            $state_is_alpha = Regex::isAlpha($iu->d_state_name, $allowWhitespace = true);
            if (!$state_is_alpha) {
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
        
        $revs = RevAddress::from('rev_addresses as rv')->leftJoin('zips', function ($join) {
            $join->on('zips.zip', '=', 'rv.zip');
            $join->on('zips.city', '=', 'rv.city');
            $join->on('zips.d_state_name', '=', 'rv.d_state_name');
            $join->on('zips.country_code', '=', 'rv.country_code');
        })
            ->where('zips.id', '=', NULL)
            ->get(['rv.*','zips.zip as z_zip','zips.city as z_city','zips.d_state_name as z_d_state_name', 'zips.country_code as z_country_code']);

            foreach($revs as $rev){

                $resolve = false;

                $numpattern = "/^([0-9]+)$/";
                preg_match($numpattern, $rev->zip, $zip_is_number);

                $state_is_alpha = Regex::isAlpha($rev->d_state_name, $allowWhitespace = true);
                
                //error 1
                if(!$state_is_alpha && $resolve == false)
                {
                    $z = Zip::where('zip',$rev->zip)->where('city',$rev->city)
                    ->where('country_code',$rev->country_code)
                    ->orderBy('mark', 'DESC')->first();

                   // dd($rev);
                    
                    if($z){

                    $rev->d_state_name = $z->d_state_name;
                    $rev->save();
                    }

                }

  //error 2
                if(!$zip_is_number && $resolve == false)
                {
                    $z = Zip::where('city',$rev->city)
                    ->where('d_state_name',$rev->d_state_name)
                    ->where('country_code',$rev->country_code)
                    ->orderBy('mark', 'DESC')->first();

                   // dd($rev);
                   
                    if($z){

                    $rev->zip = $z->zip;
                    $rev->save();
                    }

                }

            //error 3
                if(!$zip_is_number && $resolve == false)
                {
                  
                    $rev->zip = '';
                 
                }
            //error 4
            if(!$state_is_alpha && $resolve == false)
            {
                $rev->d_state_name = '';
             
             
            }


     

            }

            
            return redirect(backpack_url('rev-address'));
       
        }

      
    }

   
