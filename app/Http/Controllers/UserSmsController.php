<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use App\SmsOperation;
use APP\User;

use Carbon\Carbon;
use Cache;

use App\Exports\SmsMessage; 
use Maatwebsite\Excel\Facades\Excel; 

use App\Http\Controllers\ApiDataController;

class UserSmsController extends Controller
{
    public function Index(){

        $user_id = session()->get('user.id');

        $smsUserdata = DB::table('sms_users')->where('user_id', $user_id)->first();

        $smsCode = $smsUserdata->access;
        $arrayUserAccessCodeData = explode(",", $smsCode);

        $operationArr = [];

        foreach ($arrayUserAccessCodeData as $id) { //loop all ID
           
            if( !empty($id) ) { 
                $operationArr[] = DB::table('sms_operations')->where('id', $id)->first();
            }
        }

        $opprationData = (object) $operationArr;

        //dd($opprationData);

        return view('user.sms.index')->with('opprationData', $opprationData) ;
    }


    //User Profile
    public function Profile(){
        // $userData = User::find(session()->get('user.id'));
        return view('user.sms.profile');

    }

    //Report
    public function SmsReport(Request $request){

        $date = $request->date;
        $date = date_create($date);
        $date = date_format($date, 'd/m/Y');

        $code = $request->code;
        $type = $request->type;

        $opName = DB::table('sms_operations')->where('code', '=', $code)->select('name') ->first();
        $operationName = $opName->name;

        $Object = new ApiDataController();

        if($type == 'invoice'){

           $allData = $Object->AllSmsINVData($date, $code);

        //     $expireAt = Carbon::now()->addMinutes(59);
        //     Cache::put('exData', $allData, $expireAt); 

            $allData = Cache::get('exData');

            $fieldName = 'CV_CODE';
            $groupData = $Object->GroupByFielsName($allData, $fieldName);

            //dd( $groupData );
            return view('user.sms.inv-reports')
                ->with('groupData', $groupData)
                ->with('date', $date)
                ->with('operationName', $operationName)
                ->with('allData', $allData)
                ->with('code', $code); 
        }
        elseif($type == 'recept'){

            $allData = $Object->AllSmsRECData($date, $code);
            $fieldName = 'CV_CODE';
            $groupData = $Object->GroupByFielsName($allData, $fieldName);

            return view('user.sms.rec-reports')
            ->with('groupData', $groupData)
            ->with('date', $date)
            ->with('operationName', $operationName)
            ->with('code', $code);

        }

        //return view('user.sms.reports');
    }




}
