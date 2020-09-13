<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Carbon\Carbon;
use App\NetworkIp;
use App\NetworkMainIpPing;
use App\NewtorkGroup;
use App\NetworkSubIp;
use App\NetworkSubIpPing;

use Cache;

class NetworkController extends Controller
{

    public $allIp;
    public $allIpCount;


    public function __construct(){

      $allIp= DB::table('network_ips')
                ->where('status', '=', '1')
                ->select('ip','name')
                ->get();
      // $allIpCount= DB::table('network_ips')
      //           ->where('status', '=', '1')
      //           ->count();
      $this->allIp = $allIp;
      //$this->allIpCount = $allIpCount;

    }

    public function Index(){
        return view('admin.network.index');
    }

    //Send Ping Request
    public function pingIp($ip, $pingNumber) {
        exec ("ping -n $pingNumber $ip", $ping_output, $value);
        return $ping_output;
    }

    //All Main IP Ping Check
    public function MainIpPing(){

      $allIp = $this->allIp;

        //dd($allIp);

        foreach ($allIp as $ipData) {

            //IP Address
            $ip = $ipData->ip;
            $name = $ipData->name;
            //Define Ping Number At A Time
            $pingNumber = 4;

            $ArrData= $this->pingIp($ip, $pingNumber);


             if($pingNumber == 1 && isset( $ArrData[7] ) ){
                $latencyStr = $ArrData[7];
                $latency= explode("=", $latencyStr ) ;
                $latency = ceil($latency[3]) ;
                $status= "Online";
              }
              elseif($pingNumber == 2 && isset( $ArrData[8] ) ){
                $latencyStr = $ArrData[8];
                $latency= explode("=", $latencyStr ) ;
                $latency = ceil($latency[3]) ;
                $status= "Online";
              }
              elseif($pingNumber == 3 && isset( $ArrData[9] ) ){
                $latencyStr = $ArrData[9];
                $latency= explode("=", $latencyStr ) ;
                $latency = ceil($latency[3]) ;
                $status= "Online";
              }
              elseif($pingNumber == 4 && isset( $ArrData[10] ) ){
                $latencyStr = $ArrData[10];
                $latency= explode("=", $latencyStr ) ;
                $latency = ceil($latency[3]) ;
                $status= "Online";
              }
              else
              {
                  //For Offline IP
                  $latency = 0;
                  $status= "Offline";

                  // Offline Value Insert
                  $insert = new NetworkMainIpPing();

                  $insert->ip = $ip;
                  $insert->name = $name;
                  $insert->latency = $latency;
                  $insert->status = $status;
                  $success = $insert->save();

                  $nowTime = Carbon::now()->format('Y-m-d h:i:s A');
                  $message = "Offline Status: %0A Date: $nowTime, %0A IP: $ip,%0A Location: $name";
                  $this->lineMsg($message);

              }




            }
            //End Foreach

            // $time = Carbon::now()->subMinutes(2);
            // $allData = DB::table('network_main_ip_pings')
            // ->where('created_at', '>=', $time)
            // ->orderBy('id', 'desc')
            // ->get();

            // if( !empty( $allData ) ){
            //   $message = "Offline Status:%0A";

            //   foreach( $allData as $data ){

            //     $date = date("F j, Y, g:i a", strtotime($data->created_at));
            //     $message .=  "%0A Date: $date, %0A IP: $ip,%0A Location: $name,%0A";

            //   }

            //   $this->lineMsg($message);
            // }




    }

    public function pingMsg(){

      echo "Now: ". Carbon::now();
      echo "<hr>";
      echo $time = Carbon::now()->subMinutes(2);
      echo "<hr>";

      $allIpCount = $this->allIpCount;
      $limitValue = 5;

      //Direct Mysql Raw Query Execute
      $allData = DB::select("SELECT * FROM ( SELECT * FROM `network_main_ip_pings` ORDER BY id DESC LIMIT $limitValue )  Var1  WHERE `status` = 'Offline'");


     // dd($allData);

     $message = "";

     $message .= "Network Offline Notification: %0A";



      foreach( $allData as $ipdata ){
        $ip = $ipdata->ip;
        $name  = $ipdata->name;
        $offTime = $ipdata->created_at;
        $offTime = date("j-M-Y, g:i A", strtotime($offTime));

        $expireAt = Carbon::now()->addMinutes(5);


              echo "<hr>";
              echo $ip;
              echo "<br>";
              echo $value = Cache::get($ip);

            if( Cache::get($ip) )
            {
              $amount = 1;
              $value =  Cache::increment($ip, $amount);

              if( Cache::get($ip) >= 2 &&  Cache::get($ip) < 10 )
              {

                $value = Cache::get($ip);
                $message .= "%0A IP: $ip Name: $name,%0A Offline Time:($offTime), Value:$value  %0A";
                $lineMsgSend = true;

              }


            }
            else
            {
              $value = 1;
              Cache::put($ip, $value, $expireAt);
              $lineMsgSend = false;
            }


      }

      if($lineMsgSend){
        $this->lineMsg($message);
      }




    }


    //Main IP Offline Report
    public function ReportMainIp(){

      $beFore7date = Carbon::today()->subDays(7);

        $allData = DB::table('network_main_ip_pings')
          ->where('status', '=', 'Offline')
          ->whereDate('created_at', '>=', $beFore7date)
          ->orderBy('id', 'desc')
          ->get();

          $allIp = $this->allIp;

          //dd($allData);

        return view('admin.network.main-ip-report')
          ->with('allData', $allData)
          ->with('allIp', $allIp);


    }


    //Main IP Search Report
    public function ReportMainIpSearch(Request $request){

      $reportType = $request->reportType;
      $ip = $request->ip;

      $allIp = $this->allIp;

        if( empty($reportType) ){
            $start = $request->start;
            $end = $request->end;

            $allData = DB::table('network_main_ip_pings')
            ->where('ip', '=', $ip)
            ->whereBetween('created_at', [ $start, $end ])
            ->orderBy('id', 'desc')
            ->take(1000)
            ->get();

            $search = (object) [
            'start' => $start,
            'end' => $end,
            'ip' => $ip
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

            $allData = DB::table('network_main_ip_pings')
            ->where('ip', '=', $ip)
            ->whereDate('created_at', '>=', $date)
            ->orderBy('id', 'desc')
            ->take(1000)
            ->get();

            $search = (object) [
            'start' => Carbon::today(),
            'end' => $date,
            'ip' => $ip
            ];

        }


      return view('admin.network.main-ip-report')
          ->with('allData', $allData)
          ->with('allIp', $allIp)
          ->with('search', $search);

    }

    //Group Name List
    public function GroupNameList(){
      $GroupData = NewtorkGroup::orderBy('name')->select('name')->get();

      return $GroupData;
    }

    //BY Group Name Sub IP List
    public function ByGroupSubIpList($group_name){
      $allData = NetworkSubIp::where('group_name', $group_name)->get();
      return view('admin.network.group-sub-ip')
          ->with('allData', $allData)
          ->with('group_name',$group_name);
    }

    //Group IP Ping
    public function GroupIpPing(Request $request, $group_name){

      $pingNumber = $request->pingType;

        $groupIp = DB::table('network_sub_ips')
        ->where('group_name', '=', $group_name)
        ->where('status','=', '1')
        ->select('ip','name')
        ->get();



       // dd($groupIp);

       //$response=  $this->PingIpByArray($groupIp, 2);

       foreach ($groupIp as $ipData) {

        //IP Address
        $ip = $ipData->ip;

        //Define Ping Number At A Time
        $pingNumber =$pingNumber;

        $ArrData= $this->pingIp($ip, $pingNumber);

         if($pingNumber == 1 && isset( $ArrData[7] ) ){
            $latencyStr = $ArrData[7];
            $latency= explode("=", $latencyStr ) ;
            $latency = ceil($latency[3]) ;
            $status= "Online";
          }
          elseif($pingNumber == 2 && isset( $ArrData[8] ) ){
            $latencyStr = $ArrData[8];
            $latency= explode("=", $latencyStr ) ;
            $latency = ceil($latency[3]) ;
            $status= "Online";
          }
          elseif($pingNumber == 3 && isset( $ArrData[9] ) ){
            $latencyStr = $ArrData[9];
            $latency= explode("=", $latencyStr ) ;
            $latency = ceil($latency[3]) ;
            $status= "Online";
          }
          elseif($pingNumber == 4 && isset( $ArrData[10] ) ){
            $latencyStr = $ArrData[10];
            $latency= explode("=", $latencyStr ) ;
            $latency = ceil($latency[3]) ;
            $status= "Online";
          }
          else{
              $latency = 0;
              $status= "Offline";

          }

          $name = $ipData->name;

          $insert = new NetworkSubIpPing();

          $insert->ip = $ip;
          $insert->name = $name;
          $insert->group_name = $group_name;
          $insert->latency = $latency;
          $insert->status = $status;
          $success = $insert->save();


        }
        //End Foreach


        $nowTime = Carbon::now();

        $groupIpCount = DB::table('network_sub_ips')
        ->where('group_name', '=', $group_name)
        ->where('status','=', '1')
        ->count();

        $allData = NetworkSubIpPing::where('group_name', '=', $group_name)
              ->orderBy('id','desc')
              ->take($groupIpCount)
              ->get();

          //dd($allData);

          $notification = array(
            'title' => 'Successfully',
            'messege' => 'Ping Completed',
            'alert-type' => 'success'
        );

        $nowPingRepo = '';

       return view('admin.network.group-subip-ping-report')
            ->with('allData', $allData)
            ->with('group_name',$group_name)
            ->with('nowPingRepo',$nowPingRepo)
            ->with($notification);

    }

    //Group IP Offline Report view Page
    public function GroupIpPingOfflineReport($group_name){

      $before30Days = Carbon::today()->subDays(30);

      $allData = NetworkSubIpPing::where('group_name', '=', $group_name)
        ->whereDate('created_at', '>=', $before30Days )
        ->where('status', '=', 'offline')
        ->orderBy('id','desc')
        ->take(300)
        ->get();


      return view('admin.network.group-subip-ping-report')
            ->with('allData', $allData)
            ->with('group_name',$group_name);


    }

    //Group IP Report View
    public function GroupIpSearchPingReport(Request $request)
    {
      $group_name = $request->group_name;

      //dd($group_name);

      $reportType = $request->reportType;

        if( empty($reportType) ){
          $start = $request->start;
          $end = $request->end;

          $allData = DB::table('network_sub_ip_pings')
          ->where('group_name', '=', $group_name)
          ->whereBetween('created_at', [ $start, $end ])
          ->orderBy('status')
          ->take(1000)
          ->get();

          $search = (object) [
            'start' => $start,
            'end' => $end,
            'group_name' => $group_name
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

            $allData = DB::table('network_sub_ip_pings')
            ->where('group_name', '=', $group_name)
            ->whereDate('created_at', '>=', $date)
            ->orderBy('status')
            ->take(1000)
            ->get();

            $search = (object) [
              'start' => Carbon::today(),
              'end' => $date,
              'group_name' => $group_name
            ];

        }



          $notification = array(
            'title' => 'Successfully',
            'messege' => 'Ping Results',
            'alert-type' => 'success'
        );

          //dd($allData);

        return view('admin.network.group-subip-ping-report')
              ->with('allData', $allData)
              ->with('search', $search)
              ->with($notification);


    }

    //Single IP Ping Reports
    public function SingleIpPingReport(Request $request){

      $ip = $request->get('pingIp');

      $data = NetworkSubIpPing::where('ip', $ip)
              ->orderBy('id','desc')
              ->take(100)
              ->get();

        return $data;

    }


    //Single Ip Ping
    public function SingleIpPing($ip){


      $pingNumber = 2;

      $ArrData= $this->pingIp($ip, $pingNumber);

       if($pingNumber == 1 && isset( $ArrData[7] ) ){
          $latencyStr = $ArrData[7];
          $latency= explode("=", $latencyStr ) ;
          $latency = ceil($latency[3]) ;
          $status= "Online";
        }
        elseif($pingNumber == 2 && isset( $ArrData[8] ) ){
          $latencyStr = $ArrData[8];
          $latency= explode("=", $latencyStr ) ;
          $latency = ceil($latency[3]) ;
          $status= "Online";
        }
        elseif($pingNumber == 3 && isset( $ArrData[9] ) ){
          $latencyStr = $ArrData[9];
          $latency= explode("=", $latencyStr ) ;
          $latency = ceil($latency[3]) ;
          $status= "Online";
        }
        elseif($pingNumber == 4 && isset( $ArrData[10] ) ){
          $latencyStr = $ArrData[10];
          $latency= explode("=", $latencyStr ) ;
          $latency = ceil($latency[3]) ;
          $status= "Online";
        }
        else{
            $latency = 0;
            $status= "Offline";

        }

      $data = NetworkSubIp::where('ip', $ip)->first();

      $insert = new NetworkSubIpPing();

      $insert->ip = $ip;
      $insert->name = $data->name;
      $insert->group_name = $data->group_name;
      $insert->latency = $latency;
      $insert->status = $status;
      $success = $insert->save();

        if ($success) {
          $notification = array(
              'title' => 'Successfully',
              'messege' => 'Ping Generated',
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




    public function PingIpByArray($arrayData, $pingNumber)
    {

      foreach ($arrayData as $ipData) {

        //IP Address
        $ip = $ipData->ip;
        $name = $ipData->name;
        //Define Ping Number At A Time
        //$pingNumber = 1;

        $ArrData= $this->pingIp($ip, $pingNumber);

        //   echo "<pre>";
        //   print_r ($data);
        //   echo "<hr>";
         if($pingNumber == 1 && isset( $ArrData[7] ) ){
            $latencyStr = $ArrData[7];
            $latency= explode("=", $latencyStr ) ;
            $latency = ceil($latency[3]) ;
            $status= "Online";
          }
          elseif($pingNumber == 2 && isset( $ArrData[8] ) ){
            $latencyStr = $ArrData[8];
            $latency= explode("=", $latencyStr ) ;
            $latency = ceil($latency[3]) ;
            $status= "Online";
          }
          elseif($pingNumber == 3 && isset( $ArrData[9] ) ){
            $latencyStr = $ArrData[9];
            $latency= explode("=", $latencyStr ) ;
            $latency = ceil($latency[3]) ;
            $status= "Online";
          }
          elseif($pingNumber == 4 && isset( $ArrData[10] ) ){
            $latencyStr = $ArrData[10];
            $latency= explode("=", $latencyStr ) ;
            $latency = ceil($latency[3]) ;
            $status= "Online";
          }
          else{
              $latency = 0;
              $status= "Offline";

          }


          $insert = new NetworkMainIpPing();

          $insert->ip = $ip;
          $insert->name = $name;
          $insert->latency = $latency;
          $insert->status = $status;
          $success = $insert->save();


        //   if($success){
        //       echo $ip."Ok"."<br>";
        //   }else{
        //     echo "Not Ok";
        //   }


        }
        //End Foreach


        // if($pingNumber == 2){
        //     $arrayIp = $array;
        //     return $arrayIp;
        // }else{
        //   return "error";
        // }
    }


      //Line Message send
      public function lineMsg($message)
      {
          $chOne = curl_init();
          curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
          // SSL USE
          curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
          curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
          //POST
          curl_setopt($chOne, CURLOPT_POST, 1);
          // Message
          curl_setopt($chOne, CURLOPT_POSTFIELDS, $message);
          //��ҵ�ͧ�������ػ ������ 2 parameter imageThumbnail ���imageFullsize
          curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=$message");
          // follow redirects
          curl_setopt($chOne, CURLOPT_FOLLOWLOCATION, 1);

          // //Test Group
        // $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.config('values.line_test_key'),);  // ��ѧ����� Bearer ��� line authen code �

          //Network Monitor Group
          $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.config('values.line_network_key'),);  // ��ѧ����� Bearer ��� line authen code �

          curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
          //RETURN
          curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
          $result = curl_exec($chOne);

          //Check error
          if (curl_error($chOne)) {
              echo 'error:' . curl_error($chOne);
          } else {
              $result_ = json_decode($result, true);

              //************Status Print *************//

              //echo "status : ".$result_['status']; echo "message : ". $result_['message'];
              //echo "SMS send Successfully";
          }
          //Close connect
          curl_close($chOne);
      }

}
