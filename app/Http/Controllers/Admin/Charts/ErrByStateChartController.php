<?php

namespace App\Http\Controllers\Admin\Charts;

use App\Models\RevAddress;
use App\Common\CommonHelper;
use Illuminate\Support\Facades\DB;
use Backpack\CRUD\app\Http\Controllers\ChartController;
//use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use ConsoleTVs\Charts\Classes\Echarts\Chart;

/**
 * Class ErrByStateChartController
 * @package App\Http\Controllers\Admin\Charts
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ErrByStateChartController extends ChartController
{
    public function setup()
    {
        $this->chart = new Chart();

        $states = RevAddress::distinct('d_state_name')
            ->orderBy('d_state_name')
            ->get('d_state_name')
            ->pluck('d_state_name');
        //dd($states);

        $this->chart->labels($states);

        $this->chart->options([


            'xAxis' => [
                'type' => 'value',
                'name' => 'State',
                'showBackground' => true,


            ],

            'yAxis' => [

                'data' => $states,
                'type' => 'category',



            ],
            'grid' => ['containLabel' => true],

            // Disable init animation.
            'animationDuration' => 0,
            'animationDurationUpdate' => 20,
            'animationEasing' => 'linear',
            'animationEasingUpdate' => 'linear',




        ]);




        // RECOMMENDED. Set URL that the ChartJS library should call, to get its data using AJAX.
        $this->chart->load(backpack_url('charts/err-by-state'));
    }

    /**
     * Respond to AJAX calls with all the chart data points.
     *
     * @return json
     */
    public function data()
    {
        $stat = 'unresolved';

        $revs = RevAddress::select('rv.d_state_name', DB::raw('count(ie.status) as total'))
            ->from('rev_addresses as rv')->leftJoin('input_errors as ie', function ($join) {

                $join->on('ie.cust_id', '=', 'rv.cust_id');
                $join->where('ie.status', 'unresolved');
            })
            ->groupBy('rv.d_state_name')->get();


        foreach ($revs  as $key) {


            $datas[] = $key["total"];
        }

        $this->chart->dataset('Number of Errors', 'bar', $datas)
            ->options([
                'showBackground' => true,
                'backgroundStyle' => [
                    'color' => 'grey'
                ],
                'barWidth'=>'100%',
                'label' => [
                    'show' => true,
                    'position'=>'right'
                    
                ],

            ]);
    }
}
