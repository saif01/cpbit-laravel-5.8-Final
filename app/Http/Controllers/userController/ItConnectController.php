<?php

namespace App\Http\Controllers\userController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Carbon\Carbon;
use Cache;
use Session;

use App\Exports\SmsMessage;
use Maatwebsite\Excel\Facades\Excel;

use App\Http\Controllers\ExportController\ApiDataController;

class ItConnectController extends Controller
{

    public function index()
    {
        return view('user.it-connect.index');
    }

    //Report Generation
    public function ReportGeneration(){

        $user_id = session()->get('user.id');

        $smsUserdata = DB::table('sms_users')->where('user_id', $user_id)->first();

        //dd($smsUserdata);

        if( !empty($smsUserdata) ){

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

            return view('user.it-connect.report-generation')->with('opprationData', $opprationData) ;
        }else{

            $notification = array(
                'title' => 'Sorry',
                'messege' => 'You Have No Access',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }



    }


    //Sms Reports
    public function SmsReport(Request $request){

        $date = $request->date;
        $date = date_create($date);
        $date = date_format($date, 'd/m/Y');

        $opCode = $request->opCode;
        $type = $request->type;

        $opName = DB::table('sms_operations')->where('code', '=', $opCode)->select('name') ->first();
        $operationName = $opName->name;

        $Object = new ApiDataController();

        $userId = session()->get('user.id');
        $cachName = $userId.$opCode.$date;



        //dd($cachName);

        if($type == 'saleOrder'){

                $allData = $Object->AllSmsSaleOrderData($date, $opCode);
                $fieldName = 'CV_CODE';
                $groupData = $Object->GroupByFielsName($allData, $fieldName);

                //Store Group Data In Cache
                Cache::put('saleOrder'.$cachName, $groupData, 86400);

            // dd( $groupData );

            return view('user.it-connect.sele-order-report')
                ->with('groupData', $groupData)
                ->with('date', $date)
                ->with('operationName', $operationName)
                ->with('opCode', $opCode);
        }
        elseif($type == 'salePament'){

            $allData = $Object->AllSmsSalePaymentData($date, $opCode);
            $fieldName = 'CV_CODE';
            $groupData = $Object->GroupByFielsName($allData, $fieldName);

             //Store Group Data In Cache
             Cache::put('salePament'.$cachName, $groupData, 86400);

            return view('user.it-connect.sale-payment-report')
            ->with('groupData', $groupData)
            ->with('date', $date)
            ->with('operationName', $operationName)
            ->with('opCode', $opCode);

        }

        //return view('user.sms.reports');
    }



}
