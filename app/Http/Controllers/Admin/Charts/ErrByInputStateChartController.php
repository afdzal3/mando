<?php

namespace App\Http\Controllers\Admin\Charts;

use App\Models\InputAddress;
use App\Common\CommonHelper;
use Illuminate\Support\Facades\DB;
use Backpack\CRUD\app\Http\Controllers\ChartController;
//use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use ConsoleTVs\Charts\Classes\Echarts\Chart;


class ErrByInputStateChartController extends ChartController
{
    public function setup()
    {
        $this->chart = new Chart();

        $states = InputAddress::distinct('d_state_name')
        ->orderBy('d_state_name')
        ->get('d_state_name')
        ->pluck('d_state_name');
        //dd($states);

        $this->chart->labels($states);

        $this->chart->options([


            'xAxis' => [
                'type' => 'value',
               
                'showBackground' => true,
       
               


            ],

            'yAxis' => [

                'data' => $states,
                'type' => 'category',



            ],
            'grid' => ['containLabel' => true,
            'left'=> '3%',],



        ]);




        // RECOMMENDED. Set URL that the ChartJS library should call, to get its data using AJAX.
        $this->chart->load(backpack_url('charts/err-by-inputstate'));
    }

    /**
     * Respond to AJAX calls with all the chart data points.
     *
     * @return json
     */
    public function data()
    {
        $stat = 'unresolved';

        $revs = InputAddress::select('rv.d_state_name', DB::raw('count(ie.status) as total'))
            ->from('input_addresses as rv')->leftJoin('input_errors as ie', function ($join) {

                $join->on('ie.cust_id', '=', 'rv.cust_id');
             
            })
            ->groupBy('rv.d_state_name')->get();

      
        foreach($revs  as $key) {
          

            $datas[] = $key["total"];
        }

        $this->chart->dataset('Number of Errors', 'bar', $datas)->color('#E56717')
        
            ->options([
                'showBackground' => true,
                'backgroundStyle' => [
                    'color' => 'blue'
                ],
                'barWidth'=>'100%',
                'barCategoryGap'=> '10%',
                'label' => [
                    'show'=> true,
                    'position'=>'inside'
                ],

                ]);

    }
}
