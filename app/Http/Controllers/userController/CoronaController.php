<?php

namespace App\Http\Controllers\userController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Corona\CoronaUser;
use App\Models\Corona\CoronarUserTemp;
use App\Models\Corona\CoronaOthersTemp;
use App\Models\Corona\CoronaCheckpoint;
use DataTables;
use Validator;
use Session;
use App\User;
use Carbon\Carbon;
use DB;

class CoronaController extends Controller
{
    public function Dashboard(){

        $totalUser = CoronaUser::count();
        $todayTepmMeasured = CoronarUserTemp::whereDate('created_at', Carbon::today())->get();
        $totalTepmRec = CoronarUserTemp::count();

        $bookingChart = DB::table('corona_users')
            ->select('department',  DB::raw('count(*) as total'))
            ->groupBy('department')
            ->get();


        //dd($todayTepmMeasured);

        return view('user.corona.dashboard', compact('totalUser', 'todayTepmMeasured', 'totalTepmRec', 'bookingChart'));
    }

    //All User
    public function AllUser(){

        $checkPoints = CoronaCheckpoint::orderBy('name')->get();

        if(request()->ajax())
        {
            $data = CoronaUser::latest('id');


            //dd($data);

            return DataTables::of($data)

                    ->addColumn('action', function($data){

                        $button = '';
                        $button .= '<button type="button" id="'.$data->id.'" class="create_record btn btn-primary btn-sm" >Add Temp.</button>';
                        return $button;
                    })



                    ->addColumn('temperature', function($data){

                        $button = '';

                        $user_id = $data->id;
                        $today = date('Y-m-d');
                        $tempData = CoronarUserTemp::where('user_id', $user_id)
                                    ->whereDate('created_at', Carbon::today())
                                    ->orderBy('id','desc')
                                    ->first();

                        //dd($tempData);

                        if($tempData){

                            if($tempData->temp_1 != null){
                                $temp_1 = $tempData->temp_1.' &#8457';
                                //Temperature Check Point
                                $temp_1_location = $tempData->temp_1_location ?? 'No Data';

                                //Temperature Check Time
                                $temp_1_time = $tempData->temp_1_time;
                                if($temp_1_time != null){
                                    $temp_1_time = date('F j, h:i A', strtotime($tempData->temp_1_time));
                                }else{
                                    $temp_1_time = 'No Data';
                                }

                                $temp_by_id_1 = $tempData->temp_1_by;
                                $user_1 = User::where('id',$temp_by_id_1)->pluck('name');
                            }else{
                                $temp_1 = 'No Data';
                                $user_1[0] = 'No Data';
                                $temp_1_time = 'No Data';
                                $temp_1_location = 'No Data';
                            }

                            if($tempData->temp_2 != null){
                                $temp_2 = $tempData->temp_2.' &#8457';

                                 //Temperature Check Point
                                 $temp_2_location = $tempData->temp_2_location ?? 'No Data';

                                 //Temperature Check Time
                                 $temp_2_time = $tempData->temp_2_time;
                                 if($temp_2_time != null){
                                     $temp_2_time = date('F j, h:i A', strtotime($tempData->temp_2_time));
                                 }else{
                                     $temp_2_time = 'No Data';
                                 }

                                $temp_by_id_2 = $tempData->temp_2_by;
                                $user_2 = User::where('id',$temp_by_id_2)->pluck('name');
                            }else{
                                $temp_2 = 'No Data';
                                $user_2[0] = 'No Data';
                                $temp_2_time = 'No Data';
                                $temp_2_location = 'No Data';
                            }

                            if($tempData->temp_3 != null){
                                $temp_3 = $tempData->temp_3.' &#8457';
                                 //Temperature Check Point
                                 $temp_3_location = $tempData->temp_3_location ?? 'No Data';

                                 //Temperature Check Time
                                 $temp_3_time = $tempData->temp_3_time;
                                 if($temp_3_time != null){
                                     $temp_3_time = date('F j, h:i A', strtotime($tempData->temp_3_time));
                                 }else{
                                     $temp_3_time = 'No Data';
                                 }
                                $temp_by_id_3 = $tempData->temp_3_by;
                                $user_3 = User::where('id',$temp_by_id_3)->pluck('name');
                            }else{
                                $temp_3 = 'No Data';
                                $user_3[0] = 'No Data';
                                $temp_3_time = 'No Data';
                                $temp_3_location = 'No Data';
                            }

                            if($tempData->temp_4 != null){
                                $temp_4 = $tempData->temp_4.' &#8457';
                                 //Temperature Check Point
                                 $temp_4_location = $tempData->temp_4_location ?? 'No Data';

                                 //Temperature Check Time
                                 $temp_4_time = $tempData->temp_4_time;
                                 if($temp_4_time != null){
                                     $temp_4_time = date('F j, h:i A', strtotime($tempData->temp_4_time));
                                 }else{
                                     $temp_4_time = 'No Data';
                                 }
                                $temp_by_id_4 = $tempData->temp_4_by;
                                $user_4 = User::where('id',$temp_by_id_4)->pluck('name');
                            }else{
                                $temp_4 = 'No Data';
                                $user_4[0] = 'No Data';
                                $temp_4_time = 'No Data';
                                $temp_4_location = 'No Data';
                            }


                            if($tempData->temp_5 != null){
                                $temp_5 = $tempData->temp_5.' &#8457';
                                 //Temperature Check Point
                                 $temp_5_location = $tempData->temp_5_location ?? 'No Data';

                                 //Temperature Check Time
                                 $temp_5_time = $tempData->temp_5_time;
                                 if($temp_5_time != null){
                                     $temp_5_time = date('F j, h:i A', strtotime($tempData->temp_5_time));
                                 }else{
                                     $temp_5_time = 'No Data';
                                 }
                                $temp_by_id_5 = $tempData->temp_5_by;
                                $user_5 = User::where('id',$temp_by_id_5)->pluck('name');
                            }else{
                                $temp_5 = 'No Data';
                                $user_5[0] = 'No Data';
                                $temp_5_time = 'No Data';
                                $temp_5_location = 'No Data';
                            }



                           $button .= '<table class="table m-0 p-0 small">
                           <thead class="py-0 my-0">
                             <tr class="bg-info text-light">
                               <th class="p-0">Temp-1</th>
                               <th class="p-0">Temp-2</th>
                               <th class="p-0">Temp-3</th>
                               <th class="p-0">Temp-4</th>
                               <th class="p-0">Temp-5</th>
                             </tr>
                           </thead>
                           <tbody>
                             <tr>
                               <td class="p-0"><b>'.$temp_1 . "</b><br><small>".$user_1[0]."<br>". $temp_1_time."<br>". $temp_1_location."</small>".'</td>
                               <td class="p-0"><b>'.$temp_2 . "</b><br><small>".$user_2[0]."<br>". $temp_2_time."<br>". $temp_2_location."</small>".'</td>
                               <td class="p-0"><b>'.$temp_3 . "</b><br><small>".$user_3[0]."<br>". $temp_3_time."<br>". $temp_3_location."</small>".'</td>
                               <td class="p-0"><b>'.$temp_4 . "</b><br><small>".$user_4[0]."<br>". $temp_4_time."<br>". $temp_4_location."</small>".'</td>
                               <td class="p-0"><b>'.$temp_5 . "</b><br><small>".$user_5[0]."<br>". $temp_5_time."<br>". $temp_5_location."</small>".'</td>
                             </tr>

                           </tbody>
                         </table>';


                        }else{
                            $button .= 'No data';
                        }
                        return $button;
                    })



                    ->rawColumns(['action', 'temperature'])
                    ->make(true);
        }

        return view('user.corona.all-user', \compact('checkPoints'));
    }


    //insert
    public function StoreTemp(Request $request)
    {
        $rules = array(

            'temp'    =>  'required|numeric|between:86.00,110.99',
            'remarks'    =>  'nullable|max:1000',

        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        else{

            $user_tbl_id = $request->user_tbl_id;
            $temp = $request->temp;
            $remarks = $request->remarks;
            $checkpoint = $request->checkpoint;
            $actionId = session()->get('user.id');
            $actionName = session()->get('user.name');
            $bu_location = session()->get('user.bu_location');
            $nowTime = Carbon::now();

            $userData = CoronaUser::find($user_tbl_id);
            $id_number= $userData->id_number;
            $name= $userData->name;
            $department= $userData->department;


            $OldtempData = CoronarUserTemp::where('user_id', $user_tbl_id)
                                            ->whereDate('date', date("Y-m-d"))
                                            ->orderBy('id', 'desc')
                                            ->first();

            if($OldtempData){

                $old_id= $OldtempData->id;

                $data = CoronarUserTemp::find($old_id);
                $data->remarks = $remarks;
                $data->bu_location = $bu_location;


                if($OldtempData->temp_1 == null){

                    $data->temp_1           = $temp;
                    $data->temp_final       = $temp;

                    $data->temp_1_location  = $checkpoint;
                    $data->temp_1_time      = $nowTime;
                    $data->temp_1_by        = $actionId;
                    $data->temp_1_by_name   = $actionName;


                }elseif($OldtempData->temp_2 == null){

                    $old_temp_1             = $OldtempData->temp_1;
                    $avg_temp               = sprintf("%.2f", ($old_temp_1 + $temp)/2);

                    $data->temp_2           = $temp;
                    $data->temp_final       = $avg_temp;
                    $data->temp_2_location  = $checkpoint;
                    $data->temp_2_time      = $nowTime;
                    $data->temp_2_by        = $actionId;
                    $data->temp_2_by_name   = $actionName;

                }elseif($OldtempData->temp_3 == null){

                    $old_temp_1             = $OldtempData->temp_1;
                    $old_temp_2             = $OldtempData->temp_2;
                    $avg_temp               = sprintf("%.2f", ($old_temp_1 + $old_temp_2 + $temp)/3);
                    $data->temp_final       = $avg_temp;
                     $data->temp_3_location = $checkpoint;
                    $data->temp_3_time      = $nowTime;

                    $data->temp_3           = $temp;
                    $data->temp_3_by        = $actionId;
                    $data->temp_3_by_name   = $actionName;

                }elseif($OldtempData->temp_4 == null){

                    $old_temp_1             = $OldtempData->temp_1;
                    $old_temp_2             = $OldtempData->temp_2;
                    $old_temp_3             = $OldtempData->temp_3;
                    $avg_temp               = sprintf("%.2f", ($old_temp_1 + $old_temp_2 + $old_temp_3 + $temp)/4);
                    $data->temp_final       = $avg_temp;
                    $data->temp_4_location  = $checkpoint;
                    $data->temp_4_time      = $nowTime;

                    $data->temp_4           = $temp;
                    $data->temp_4_by        = $actionId;
                    $data->temp_4_by_name   = $actionName;

                }elseif($OldtempData->temp_5 == null){

                    $old_temp_1             = $OldtempData->temp_1;
                    $old_temp_2             = $OldtempData->temp_2;
                    $old_temp_3             = $OldtempData->temp_3;
                    $old_temp_4             = $OldtempData->temp_4;
                    $avg_temp               = sprintf("%.2f", ($old_temp_1 + $old_temp_2 + $old_temp_3 + $old_temp_4 + $temp)/5);
                    $data->temp_final       = $avg_temp;
                    $data->temp_5_location  = $checkpoint;
                    $data->temp_5_time      = $nowTime;


                    $data->temp_5           = $temp;
                    $data->temp_5_by        = $actionId;
                    $data->temp_5_by_name   = $actionName;

                }else{
                    $old_temp_1             = $OldtempData->temp_1;
                    $old_temp_2             = $OldtempData->temp_2;
                    $old_temp_3             = $OldtempData->temp_3;
                    $old_temp_4             = $OldtempData->temp_4;
                    $data->temp_5           = $temp;
                    $avg_temp               = sprintf("%.2f", ($old_temp_1 + $old_temp_2 + $old_temp_3 + $old_temp_4 + $temp)/5);
                    $data->remarks          = $remarks;
                    $data->temp_final       = $avg_temp;
                    $data->bu_location      = $bu_location;

                    $data->temp_5_by        = $actionId;
                    $data->temp_5_location  = $checkpoint;
                    $data->temp_5_time      = $nowTime;
                    $data->temp_5_by_name   = $actionName;
                }

                $success= $data->save();



            }else{

                $data = new CoronarUserTemp();

                $data->user_id          = $user_tbl_id;
                $data->id_number        = $id_number;
                $data->name             = $name;
                $data->department       = $department;
                $data->date             = date("Y-m-d");
                $data->temp_1           = $temp;
                $data->temp_final       = $temp;
                $data->remarks          = $remarks;
                $data->temp_1_by        = $actionId;
                $data->temp_1_location  = $checkpoint;
                $data->temp_1_time      = $nowTime;
                $data->temp_1_by_name   = $actionName;
                $data->bu_location      = $bu_location;
                $success = $data->save();

            }





            if($success){
                return response()->json(['success' => 'Tempareture is successfully added']);
            }else{
                return response()->json(['success' => 'Something going wrong !!']);
            }
        }



    }


    //AllRecords
    public function AllRecords(Request $request){

        $userData = CoronaUser::get();


        if(request()->ajax())
        {

            $data = CoronarUserTemp::whereDate('created_at', Carbon::today())->get();

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
                        $button .= '<span class="h5 bg-danger p-1 text-light rounded">'.$temp_final.' &#8457</span>';
                       }else{
                        $button .= '<span class="h5 bg-success p-1 text-light rounded">'.$temp_final.' &#8457</span>';
                       }



                        return $button;
                    })

                    ->addColumn('temp_date', function($data){

                        return date("F j, Y", strtotime($data->created_at));

                    })


                    ->rawColumns(['action', 'temperature', 'temp_date'])
                    ->make(true);
        }

        return view('user.corona.all-records', compact('userData'));
    }


    //Search Dara
    public function SearchData(Request $request){

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

        //return view('user.corona.calader-report', compact('allData', 'search', 'userData'));

        return view('user.corona.all-records', compact('allData', 'search', 'userData'));


    }


    //Others
    public function Others(){


        $checkPoints = CoronaCheckpoint::orderBy('name')->get();

        if(request()->ajax())
        {

            $data = CoronaOthersTemp::with('user')->whereDate('created_at', Carbon::today())->latest('id');

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

        return view('user.corona.others', \compact('checkPoints'));
    }

    //OthersAdd
    public function OthersAdd(Request $request){

        $rules = array(

            'temp'    =>  'required|numeric|between:86.00,110.99',
            'name'    =>  'required|max:50',
            'to'      =>  'required|max:200',
            'from'    =>  'required|max:200',
            'remarks' =>  'nullable|max:1000',

        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        else{

            $temp = $request->temp;
            $name = $request->name;
            $from = $request->from;
            $to = $request->to;
            $remarks = $request->remarks;
            $temp_location = $request->checkpoint;
            $temp_by = \session()->get('user.id');
            $bu_location = \session()->get('user.bu_location');


            $form_data = array(

                'name' =>  $name,
                'from' =>  $from,
                'to' =>  $to,
                'temp'    =>  $temp,
                'remarks'    =>  $remarks,
                'temp_by'    =>  $temp_by,
                'temp_location'    =>  $temp_location,
                'bu_location'    =>  $bu_location,
            );

            // dd($form_data);
            $success= CoronaOthersTemp::create($form_data);

            if($success){
                return response()->json(['success' => 'Record is successfully added', 'icon'=>'success']);
            }else{
                return response()->json(['success' => 'Something going wrong !!', 'icon'=>'error']);
            }
        }

    }

    //OthersSearch
    public function OthersSearch(Request $request){

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


        return view('user.corona.others', compact('allData', 'search'));


    }



}
