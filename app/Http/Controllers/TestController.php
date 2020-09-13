<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use App\User;
use App\NetworkIp;

use App\Models\Network\NetworkMainIp;

use DB;

use App\Exports\SmsMessage;
use Maatwebsite\Excel\Facades\Excel;

use App\Http\Controllers\ApiDataController;

 use Illuminate\Support\Str;

class TestController extends Controller
{




        public function Test(){


            return "This Admin";

            //  $data = DB::table('sms_user')->get();

            //  $data2 = DB::table('sms_operations')->get();

            //  $allUser = User::orderBy('id', 'asc')->take(10)->get();

            //     //dd($allUser);

            //     return view('test')
            //         ->with('allUser', $allUser)
            //         ->with('data2', $data2)
            //         ->with('data', $data);

        }

        public function sd(){
            //session()->has('user', 'default value');

            //$data= session()->forget('user2');

            if(session()->has('user')){

                session()->forget('user');
                return "Session Data Clean";
            }else{
                return "No data have";
            }

            // if(session()->forget('user2')){
            //     echo "Sess delete";
            // }else{
            //     echo "Not ok";
            // }

        }

        public function Mail(Request $request){
           //$email = $request->email;
           $email = request('email');

           dd ($email);
        }

        public function test2(Request $request){
            // $name = $request->get('exName');

             $data = $request->data;

             //return $data;
             //$data = json_decode($data);

             dd($data);

              //INV SMS Format Data
                //       $Object = new ApiDataController();
                //  $invSmsFormatData = $Object->InvSmsDataXcelFormat($data);

                //  return Excel::download(new SmsMessage($invSmsFormatData), 'ttttttttttt.csv');

                    //return response()->json($data, 200);


        }

        public function SmsSend(){

            //$url = "http://localhost/api/test.php";

            //  Basic URL: https://cmp.grameenphone.com/gpcmpbulk/messageplatform/controller.home
            // Input parameters:
            // username =abc {Valid User Name}[mandatory];
            // password =xxxx { Valid password}[mandatory];
            // apicode =5 or 6 {5= for SMS submit with delivery request} {6= for SMS submit without delivery} [mandatory];
            // msisdn =017XXXXXXXX, 017XXXXXXXX, 017XXXXXXXX …017XXXXXXXX {Mobile Number Prefix with ZERO and comma separate and maximum limit is 100 }[mandatory];
            // countrycode =880{For Local Sms}[mandatory];
            // cli =zzzyyyxxx{Valid CLI}[mandatory];
            // messagetype=1 {1 for text ;2 for flash ;3 for unicode(bangla)}
            // message =text {Text Scripts}[Mandatory];
            // messageid=0 [mandatory];

            //  Request Mothod: doGet, doPost ;





            //  $url = "https://cmp.grameenphone.com/gpcmpapi/messageplatform/controller.home?username=$username&password=$password&apicode=1&msisdn=$number&countrycode=880&cli=cm papi&messagetype=1&message=$message&messageid=0";

            //https://cmp.grameenphone.com/gpcmpbulk/messageplatform/controller.home?username=cpbit-admin&password=cpbdIT@0&apicode=5&msisdn=01707080401&countrycode=880&cli=CPB&messagetype=1&message=This is test SMS&messageid=0

            $username = "cpbit-admin";
            $password = "cpbdIT@0";
            $apicode = 5;
            $msisdn = "01707080401";
            $countrycode =880;
            $cli = "CPB";
            $messagetype=1;
            $message = "This is test SMS";
            $messageid=0;


            $client = new \GuzzleHttp\Client();

            $response = $client->request('POST', 'https://gpcmp.grameenphone.com/gpcmpbulk/messageplatform/controller.home',[
                'form_params' => [
                    'username' => $username,
                    'password' => $password,
                    'apicode' => $apicode,
                    'msisdn' => $msisdn,
                    'countrycode' => $countrycode,
                    'cli' => $cli,
                    'messagetype' => $messagetype,
                    'message' => $message,
                    'messageid' => $messageid,
                ]
            ]);

            $response->getStatusCode(); // 200
            $response->getHeaderLine('application/json; charset=utf8'); // 'application/json; charset=utf8'

           // return json_decode($response->getBody()->getContents());

                dd($response);

            }


        public function TesstIP(){

            $now = "20:30:00";

            $allIp= NetworkMainIp::where('status', '=', '1')
                //->whereBetween( $now ,['start','end'])
                ->whereRaw("'21:31:00' BETWEEN start AND end")
                ->get();

                // $allIp = DB::table('network_ips')
                // ->whereColumn([
                //     ['satart', '=', 'main_price'],
                //     ['updated_at', '>', 'created_at']
                // ])->get();





            dd($allIp);

        }

}
