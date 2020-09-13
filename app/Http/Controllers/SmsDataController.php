<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\SmsOperation;
use DB;
use App\Exports\SmsMessage; 
use Maatwebsite\Excel\Facades\Excel; 

use App\Http\Controllers\ApiDataController;

// use Excel;

class SmsDataController extends Controller
{
    
    public function All()
    {
        $allData = SmsOperation::orderBy('id', 'desc')->get();
        //print_r($allData);
        return view('admin.super.sms.operation-code')->with('allData', $allData);
    }

    //Insert Data
    public function Insert(Request $request)
    {

        $data = new SmsOperation();

        // Another Way to insert records
        $successData = $data->create($request->all());

        // $data->dept_name = request('dept_name');
        // $successData = $data->save();

        if ($successData) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'Data Inserted',
                'alert-type' => 'success'
            );
            return Redirect()->route('sms.operation.all')->with($notification);
        } else {
            $notification = array(
                'title' => 'Error',
                'messege' => 'Somthing Going Wrong',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
    }


    //Delete data
    public function Delete($id)
    {
        $data = SmsOperation::find($id);
        //Delete from Database
        $success = $data->delete();

        if ($success) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'Data Deleted',
                'alert-type' => 'success'
            );
            return Redirect()->back()->with($notification);
        } else {
            $notification = array(
                'title' => 'Error',
                'messege' => 'Somthing Going Wrong',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
    }



    public function Update(Request $request)
    {
        $id = request('id');
        $data = SmsOperation::find($id);

        // Another Way to update records
        $successData = $data->update($request->all());

        if ($successData) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'Data updated',
                'alert-type' => 'info'
            );
            return Redirect()->route('sms.operation.all')->with($notification);
        } else {
            $notification = array(
                'title' => 'Error',
                'messege' => 'Somthing Going Wrong',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
    }
    
    



    
    //SMS Report Section
    public function ReportGenerate(){
        $opData = SmsOperation::orderBy('name')->get();
        return view('admin.sms.report-generation')->with('opData', $opData);
    }
    

    //SMS Report Generate 
    public function SmsAdminReports(Request $request){

        $date = $request->date;
        $date = date_create($date);
        $date = date_format($date, 'd/m/Y');

        $code = $request->code;
        $type = $request->type;

        $opName = DB::table('sms_operations')->where('code', '=', $code)->select('name') ->first();
        $operationName = $opName->name;

        //$date = '02-02-2020';

        //dd($operationName);

        $Object = new ApiDataController();

        if($type == 'invoice'){

            $allData = $Object->AllSmsINVData($date, $code);
            $fieldName = 'CV_CODE';
            $groupData = $Object->GroupByFielsName($allData, $fieldName);

            //dd( $groupData );
            return view('admin.sms.inv-report')
                ->with('groupData', $groupData)
                ->with('date', $date)
                ->with('operationName', $operationName)
                ->with('code', $code);

        }
        elseif($type == 'recept'){
            $allData = $Object->AllSmsRECData($date, $code);
            $fieldName = 'CV_CODE';
            $groupData = $Object->GroupByFielsName($allData, $fieldName);

            return view('admin.sms.rec-report')
            ->with('groupData', $groupData)
            ->with('date', $date)
            ->with('operationName', $operationName)
            ->with('code', $code);

            //dd( $groupData );
        }
        
    }
    













    
    public function Index($date, $opCode  ){

        //$date = '01/01/2020';
        //$date = '02/02/2020';
        // $date = '02-02-2020';
        // $opCode = '11';

        $allData = $this->AllSmsINVData($date, $opCode);

        $group = array();
        //Group By Value store in array
        foreach ( $allData as $value ) {
            $group [ $value->CV_CODE ] [] = $value;
        }


        $finalArray = [];

        foreach($group as $value){

            $sum_tot_Price = 0;
            foreach( $value as $row2 ){
 
             $sum_tot_Price += $row2->AMOUNT;
 
            $headerSms = "Thank you for CPB Product Order" .$sum_tot_Price. "Tk. on" .$value[0]->INVOICE_DATE;
 
            }
 
            foreach( $value as $row ){
            $contectSms= "CV.".$row->CV_CODE . "Inv.". $row->INVOICE_NO ." = ".  $row->AMOUNT ."Tk.,";
            }
 
            $footeSms =  "Thank you one more time.";


            $finalArray[] = array(

                'number' => $value[0]->SMS_NO,
                'message' => $headerSms.$contectSms. $footeSms,

            );
 
 
         }

         //dd($finalArray);

         return $finalArray;



        //dd($group);
        // return view('test')->with('group', $group);

         //return view('admin.super.sms.sms-report')->with('group', $group);

        }






        
    function excel()
    {
     $allData = $this->Index();

     $data_array[] = array('Number', 'Message');

     foreach($allData as $data)
     {
      $data_array[] = array(
       'Number'  => $data['number'],
       'Message'   => $data['message']
      
      );
     }

     Excel::store('SMS Data', function($excel) use ($data_array){
      $excel->setTitle('Customer Data');
      $excel->sheet('Customer Data', function($sheet) use ($data_array){
       $sheet->fromArray($data_array, null, 'A1', false, false);
      });
     })->download('xlsx');
    }





    public function export(Request $request){

        // $date = '02-02-2020';
        // $code = '11';

        $date = $request->get('date');
        $code = $request->get('code');

        //$data = $this->Index($date, $code);
        $Object = new ApiDataController();

        $allData = $Object->AllSmsINVData($date, $code);

        $fieldName = 'CV_CODE';
        $groupData = $Object->GroupByFielsName($allData, $fieldName);

        //INV SMS Format Data
        $invSmsFormatData = $Object->InvSmsDataXcelFormat($groupData); 


      return Excel::download(new SmsMessage($invSmsFormatData), 'users.csv'); 
    } 









        public function TestApi($date, $opCode){

            $client = new \GuzzleHttp\Client();
    
            $response = $client->request('POST', 'http://202.51.191.2/saif/smsInfo.php',[
                'form_params' => [
                    'Date' => $date,
                    'OpCode' => $opCode,
                ]
            ]);
    
            $response->getStatusCode(); // 200
            $response->getHeaderLine('application/json; charset=utf8'); 

            return json_decode($response->getBody()->getContents()); 
        }





     //Recept
        public function AllSmsRECData($date, $opCode){

            $client = new \GuzzleHttp\Client();
    
            $response = $client->request('POST', 'http://202.51.191.2/api/Oracle/sms_rec.php',[
                'form_params' => [
                    'Date' => $date,
                    'OpCode' => $opCode,
                ]
            ]);
    
            $response->getStatusCode(); // 200
            $response->getHeaderLine('application/json; charset=utf8'); // 'application/json; charset=utf8'
            
            return json_decode( $response->getBody()->getContents() ); // '{"id": 1420053, "name": "guzzle", ...}'
        }




    //Invoice 
    public function AllSmsINVData($date, $opCode){

        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', 'http://202.51.191.2/api/Oracle/sms_inv.php',[
            'form_params' => [
                'Date' => $date,
                'OpCode' => $opCode,
            ]
        ]);

        $response->getStatusCode(); // 200
        $response->getHeaderLine('application/json; charset=utf8'); // 'application/json; charset=utf8'
        
        return json_decode($response->getBody()->getContents()); 
    }



}
