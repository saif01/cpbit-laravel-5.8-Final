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

class UserReportController extends Controller
{


    public function UserTempReports(Request $request){

        $userData = CoronaUser::get();


        if(request()->ajax())
        {

            $data = CoronarUserTemp::latest('id');

            //dd($data);

            return DataTables::of($data)

                    ->addColumn('action', function($data){

                        $button = '';
                        $button .= '<button type="button" id="'.$data->id.'" class="create_record btn btn-primary btn-sm" >Add Temp.</button>';
                        return $button;
                    })

                    ->addColumn('temperature', function($data){

                        $button = '';

                       $temp_final = $data->temp_final;

                       if( round($temp_final) >= 101)
                       {
                        $button .= '<button type="button" id="'.$data->id.'" class="view_record btn btn-danger" >'.$temp_final.' &#8457</button>';
                       }else{
                        $button .= '<button type="button" id="'.$data->id.'" class="view_record btn btn-success" >'.$temp_final.' &#8457</button>';
                       }



                        return $button;
                    })

                    ->addColumn('temp_date', function($data){

                        return date("F j, Y", strtotime($data->created_at));

                    })


                    ->rawColumns(['action', 'temperature', 'temp_date'])
                    ->make(true);
        }

        return view('admin.corona.user-reports', compact('userData'));
    }


    //Search Dara
    public function UserTempSearch(Request $request){

        $userData = CoronaUser::orderBy('id', 'desc')->get();

        $reportType = $request->reportType;
        $user_id = $request->user_id;

        if(!empty($user_id)){
            $reqUserData = CoronaUser::find($user_id);
            $userName = $reqUserData->name;
            $empID = $reqUserData->id_number;
        }else{
            $userName = 'All Employee';
            $empID = 'Data';
        }



        //dd( $reportType, $user_id);

        if( empty($reportType) ){


            $start = $request->start;
            $end = $request->end;

            if(!empty($user_id)){
                $allData = DB::table('coronar_user_temps')
                    ->where('user_id', '=', $user_id)
                    ->whereBetween('created_at', [ $start, $end ])
                    ->orderBy('id', 'desc')
                    ->get();
            }else{
                $allData = DB::table('coronar_user_temps')
                    ->whereBetween('created_at', [ $start, $end ])
                    ->orderBy('id', 'desc')
                    ->get();
            }


            $search = (object) [
            'start' => $start,
            'end' => $end,
            'name' =>$userName,
            'empID'=>$empID
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

            if(!empty($user_id)){
                $allData = DB::table('coronar_user_temps')
                    ->where('user_id', '=', $user_id)
                    ->whereDate('created_at', '>=', $date)
                    ->orderBy('id', 'desc')
                    ->get();
            }else{
                $allData = DB::table('coronar_user_temps')
                    ->whereDate('created_at', '>=', $date)
                    ->orderBy('id', 'desc')
                    ->get();
            }



            $search = (object) [
            'start' => Carbon::today(),
            'end' => $date,
            'name' =>$userName,
            'empID'=>$empID
            ];

        }

        //dd($allData);

        return view('admin.corona.user-reports', compact('allData', 'search', 'userData'));


    }


    //SingleDetails
    public function SingleDetails($id){
        if(request()->ajax())
        {
            $data = CoronarUserTemp::findOrFail($id);
            return response()->json($data);
        }
    }

}
