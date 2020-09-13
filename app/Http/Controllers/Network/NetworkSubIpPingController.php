<?php

namespace App\Http\Controllers\Network;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Network\NetworkSubIpPing;
use  App\Models\Network\NetworkSubIp;

use Carbon\Carbon;
use DB;

// use App\Http\Controllers\Network\PingController;

class NetworkSubIpPingController extends Controller
{

        //Send Ping Request
        public function pingIp($ip, $pingNumber) {
            exec ("ping -n $pingNumber $ip", $ping_output, $value);
            return $ping_output;
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



        //Single IP Ping Reports
        public function SingleIpPingReport(Request $request){

                $ip = $request->get('pingIp');

                $data = NetworkSubIpPing::where('ip', $ip)
                        ->orderBy('id','desc')
                        ->take(100)
                        ->get();

                return $data;

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




      //Group Sub IP Ping
    public function GroupSubIpPing(Request $request, $group_name){

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



}
