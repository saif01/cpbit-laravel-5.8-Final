<?php

namespace App\Http\Controllers\ItConnect;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ItConnect\ItConnectOperation;
use DB;
use Session;
use Cache;

use App\Http\Controllers\ExportController\ApiDataController;

class ItConnectController extends Controller
{
    //Dashboard
    public function Index(){
        return view('admin.it-connect.index');
    }

    //SMS Report Section
    public function ReportGenerate(){
        $opData = ItConnectOperation::orderBy('name')->get();
        return view('admin.it-connect.report-generation')->with('opData', $opData);
    }

     //Sms Reports
     public function SmsReport(Request $request){

        $date = $request->date;
        $date = date_create($date);
        $date = date_format($date, 'd/m/Y');

        $opCode = $request->opCode;
        $type = $request->type;

        $opName = ItConnectOperation::where('code', '=', $opCode)->select('name') ->first();

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

             //dd( $groupData );

            return view('admin.it-connect.sele-order-report')
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

            return view('admin.it-connect.sale-payment-report')
            ->with('groupData', $groupData)
            ->with('date', $date)
            ->with('operationName', $operationName)
            ->with('opCode', $opCode);

        }

        //return view('user.sms.reports');
    }






}
