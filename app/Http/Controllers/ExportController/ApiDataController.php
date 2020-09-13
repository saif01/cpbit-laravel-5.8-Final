<?php

namespace App\Http\Controllers\ExportController;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ApiDataController extends Controller
{
     //Seles Order  ( Invoice )
     public function AllSmsSaleOrderData($date, $opCode){

        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', 'http://202.51.191.2/api/iService/SMS_Sales_Order.php',[
            'form_params' => [
                'Date' => $date,
                'OpCode' => $opCode,
            ]
        ]);

        $response->getStatusCode(); // 200
        $response->getHeaderLine('application/json; charset=utf8'); // 'application/json; charset=utf8'

        return json_decode($response->getBody()->getContents());
    }

    //Money Receipt
     public function AllSmsSalePaymentData($date, $opCode){

        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', 'http://202.51.191.2/api/iService/SMS_Sales_Payment.php',[
            'form_params' => [
                'Date' => $date,
                'OpCode' => $opCode,
            ]
        ]);

        $response->getStatusCode(); // 200
        $response->getHeaderLine('application/json; charset=utf8'); // 'application/json; charset=utf8'

        return json_decode($response->getBody()->getContents());
    }



    //Data Group By Fields
    public function GroupByFielsName($allData, $fieldName){
        $group = array();
        //Group By Value store in array
        foreach ( $allData as $value ) {
            $group [ $value->$fieldName ] [] = $value;
        }

        return $group;
    }

    //Invoice SMS Data Format
    public function InvSmsDataXcelFormat($groupData){
        $finalArray = [];

        foreach($groupData as $value){

            $sum_tot_Price = 0;
            foreach( $value as $row2 ){

             $sum_tot_Price += $row2->AMOUNT;

            $headerSms = "Thank you for CPB Product Order " .$sum_tot_Price. " Tk. on " .$value[0]->INVOICE_DATE  . PHP_EOL ;

            }

            foreach( $value as $row ){
            $contectSms= " CV.".$row->CV_CODE . " Inv.". $row->INVOICE_NO ." = ".  $row->AMOUNT ." Tk., " . PHP_EOL ;
            }

            $footeSms =  " Thank you one more time.";

            //$numberAsString = "'".$value[0]->SMS_NO;

            //$numberAsString = "01707080401";

            $finalArray[] = array(

                'number' => $value[0]->SMS_NO,
                'message' => $headerSms.$contectSms.$footeSms,

            );


         }


         return $finalArray;
    }

    //Money Receipt Data Format
    public function RecSmsDataXcelFormat($groupData){
        $finalArray = [];

        foreach($groupData as $value){

            $sum_tot_Price = 0;
            foreach( $value as $row2 ){

             $sum_tot_Price += $row2->AMOUNT;

            $headerSms = "Thank you for CPB Product Payment " .$sum_tot_Price. " Tk. on " .$value[0]->NOTE_DATE . PHP_EOL;

            }

            foreach( $value as $row ){
            $contectSms= " CV.".$row->CV_CODE . " Inv.". $row->RECEIPT_NO ." = ".  $row->AMOUNT ." Tk. @".$row->BANK_NAME . PHP_EOL;
            }

            $footeSms =  " Thank you one more time.";


            $finalArray[] = array(

                'number' => $value[0]->SMS_NO,
                'message' => $headerSms.$contectSms. $footeSms,

            );


         }


         return $finalArray;
    }



}
