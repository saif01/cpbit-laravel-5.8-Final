<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

 
use App\SmsOperation;

use App\Exports\SmsMessage; 
use Maatwebsite\Excel\Facades\Excel; 

use App\Http\Controllers\ApiDataController;

class ExportController extends Controller
{

    public function Test(){
        return view('test');
    }

    public function ExportExcelInv(Request $request){

         $date = $request->get('date');
         $code = $request->get('code');
         $operationName = $request->get('operationName');

         $Object = new ApiDataController();
         $allData = $Object->AllSmsINVData($date, $code);

         $fieldName = 'CV_CODE';
         $groupData = $Object->GroupByFielsName($allData, $fieldName);

         //INV SMS Format Data
         $invSmsFormatData = $Object->InvSmsDataXcelFormat($groupData); 

         $Namedate = date_create($date);
         $Namedate = date_format($Namedate, 'd-m-Y');
         $fileName ="Sales Order SMS - ".$operationName . " (".$Namedate.")".".csv";

        return Excel::download(new SmsMessage($invSmsFormatData), $fileName); 

       // dd($data);
    }

    public function ExportExcelRec(Request $request){

        $date = $request->get('date');
        $code = $request->get('code');
        $operationName = $request->get('operationName');

        $Object = new ApiDataController();
        $allData = $Object->AllSmsRECData($date, $code);

        $fieldName = 'CV_CODE';
        $groupData = $Object->GroupByFielsName($allData, $fieldName);

        //INV SMS Format Data
        $invSmsFormatData = $Object->RecSmsDataXcelFormat($groupData); 

        $Namedate = date_create($date);
        $Namedate = date_format($Namedate, 'd-m-Y');
        $fileName ="Sales Payment SMS - ".$operationName . " (".$Namedate.")".".csv";

       return Excel::download(new SmsMessage($invSmsFormatData),  $fileName); 

       //dd($invSmsFormatData);
   }




}
