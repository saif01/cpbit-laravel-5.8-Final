<?php

namespace App\Http\Controllers\ExportController;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;


use App\SmsOperation;
use Session;
use Cache;

use App\Exports\SmsMessage;
use Maatwebsite\Excel\Facades\Excel;

use App\Http\Controllers\ExportController\ApiDataController;

class ExportController extends Controller
{

    public function Test(){
        return view('test');
    }

    public function ExportExcelSaleOrder(Request $request){

         $date = $request->get('date');
         $opCode = $request->get('opCode');
         $operationName = $request->get('operationName');

         $userId = session()->get('user.id');
         $cachName = $userId.$opCode.$date;

         $Object = new ApiDataController();

         if( !empty( Cache::get('saleOrder'.$cachName) ) ){

            $groupData = Cache::get('saleOrder'.$cachName);

            //dd($groupData);

        }else{

            $allData = $Object->AllSmsSaleOrderData($date, $opCode);
            $fieldName = 'CV_CODE';
            $groupData = $Object->GroupByFielsName($allData, $fieldName);
        }





         //INV SMS Format Data
         $invSmsFormatData = $Object->InvSmsDataXcelFormat($groupData);

         $Namedate = date_create($date);
         $Namedate = date_format($Namedate, 'd-m-Y');


        //Formate Of Download Reports
        //csv, xlsx, xls,

         $fileName ="Sales Order SMS - ".$operationName . " (".$Namedate.")".".xlsx";

        return Excel::download(new SmsMessage($invSmsFormatData), $fileName);

       // dd($data);
    }










    public function ExportExcelSalePayment(Request $request){

        $date = $request->get('date');
        $opCode = $request->get('opCode');
        $operationName = $request->get('operationName');

        $userId = session()->get('user.id');
        $cachName = $userId.$opCode.$date;

        $Object = new ApiDataController();


        if( !empty( Cache::get('salePament'.$cachName) ) ){

            $groupData = Cache::get('salePament'.$cachName);

            //dd($groupData);

        }else{

            $allData = $Object->AllSmsSaleOrderData($date, $opCode);
            $fieldName = 'CV_CODE';
            $groupData = $Object->GroupByFielsName($allData, $fieldName);
        }


        //INV SMS Format Data
        $invSmsFormatData = $Object->RecSmsDataXcelFormat($groupData);



        $Namedate = date_create($date);
        $Namedate = date_format($Namedate, 'd-m-Y');


        //Formate Of Download Reports
        //csv, xlsx, xls,
        $fileName ="Sales Payment SMS - ".$operationName . " (".$Namedate.")".".xlsx";

       return Excel::download(new SmsMessage($invSmsFormatData),  $fileName);

       //dd($invSmsFormatData);
   }




}
