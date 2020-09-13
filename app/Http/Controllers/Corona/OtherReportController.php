<?php

namespace App\Http\Controllers\Corona;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Corona\CoronaUser;
use App\Models\Corona\CoronarUserTemp;
use App\Models\Corona\CoronaOthersTemp;
use DataTables;
use Validator;
use Session;
use App\User;
use Carbon\Carbon;
use DB;

class OtherReportController extends Controller
{
    //Others
    public function OthersTempReports(){


        if(request()->ajax())
        {

            $data = CoronaOthersTemp::with('user')->latest('id');

            //dd($data);

            return DataTables::of($data)


                    ->addColumn('temperature', function($data){

                        $button = '';

                       $temp = $data->temp;

                       if( round($temp) >= 101)
                       {
                        $button .= '<span class="h5 bg-danger p-1 text-light rounded">'.$temp.' &#8457</span>';
                       }else{
                        $button .= '<span class="h5 bg-success p-1 text-light rounded">'.$temp.' &#8457</span>';
                       }

                        return $button;
                    })

                    ->addColumn('actionBy', function($data){
                        // $userName = User::where('id',$data->temp_by)->pluck('name');
                        return $data->user->name;
                    })

                    ->addColumn('temp_date', function($data){

                        return date("F j, Y h:i A", strtotime($data->created_at));
                    })


                    ->rawColumns(['action', 'temperature', 'temp_date', 'actionBy'])
                    ->make(true);
        }

        return view('admin.corona.other-reports');
    }


    //OthersSearch
    public function OthersTempSearch(Request $request){

        $reportType = $request->reportType;

        if( empty($reportType) ){

            $start = $request->start;
            $end = $request->end;

            $allData = CoronaOthersTemp::with('user')->whereBetween('created_at', [$start, $end])->get();

            $search = (object) [
                'start' => $start,
                'end' => $end,
                ];


        }else{
            if($reportType == 'last3D'){
            $date = Carbon::today()->subDays(3);
            }elseif($reportType == 'last5D'){
            $date = Carbon::today()->subDays(5);
            }elseif($reportType == 'last7D'){
            $date = Carbon::today()->subDays(7);
            }elseif($reportType == 'last10D'){
            $date = Carbon::today()->subDays(10);
            }elseif($reportType == 'last15D'){
            $date = Carbon::today()->subDays(15);
            }elseif($reportType == 'last30D'){
            $date = Carbon::today()->subDays(30);
            }


            $allData = CoronaOthersTemp::with('user')->whereDate('created_at', '>=', $date)->get();

            $search = (object) [
                'start' => Carbon::now(),
                'end' => $date,
                ];
        }


        return view('admin.corona.other-reports', compact('allData', 'search'));


    }



}
