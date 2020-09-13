<?php

namespace App\Http\Controllers\Network;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Network\NetworkMainIpPing;
use App\Models\Network\NetworkMainIp;

use Carbon\Carbon;
use DB;


class NetworkMainIpPingController extends Controller
{
    public $allIp;


    public function __construct(){

        //$nowTimeOnly = "20:30:00";
        $nowTimeOnly = date("H:i:s");

        $allIp= NetworkMainIp::where('status', '=', '1')
            ->whereRaw("'$nowTimeOnly' BETWEEN start AND end")
            ->get();

        $this->allIp = $allIp;
    }



    //Send Ping Request
    public function pingIp($ip, $pingNumber) {
        exec ("ping -n $pingNumber $ip", $ping_output, $value);
        return $ping_output;
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



    //All Main Ip Ping
    public function AllMainIpPingByBrowser()
    {
        $allIp = $this->allIp;

        foreach ($allIp as $ipData) {

            //IP Address
            $ip = $ipData->ip;
            $name = $ipData->name;
            //Define Ping Number At A Time
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

        //$nowTime= $now->time;
        //dd($allIp);

        $notification = array(
            'title' => 'Successfully',
            'messege' => 'Ping Completed',
            'alert-type' => 'info'
        );
        return Redirect()->back()->with($notification);


    }



    //All Main IP Ping Check
    public function MainIpPingBySchedule()
    {

        $allIp = $this->allIp;

        foreach ($allIp as $ipData) {

            //IP Address
            $ip = $ipData->ip;
            $name = $ipData->name;
            //Define Ping Number At A Time
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
