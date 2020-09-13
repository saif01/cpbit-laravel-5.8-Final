<?php

namespace App\Http\Controllers\login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Admin;
use App\AdminLoginLog;
use Session;
use App\VisitorInfo\UserInfo;

class LoginAdminController extends Controller
{
    public function ShowLoginForm()
    {
        //view Login form
        return view('admin.login.login');
    }

    public function Dashboard()
    {

        return view('admin.dashboard.dashboard');
    }

    // Admin login By AD Server
    public function loginActionAD(Request $request)
    {
        $login  = $request->input('login');
        $password = $request->input('password');

        //for user details class object
        $userDetails = new UserInfo();

        //store Login log
        $loginLog = new AdminLoginLog();
        $loginLog->login_id = $login;
        $loginLog->ip = $userDetails->get_ip();
        $loginLog->os = $userDetails->get_os();
        $loginLog->device = $userDetails->get_device();
        $loginLog->browser = $userDetails->get_browser();
        $loginLog->city = $userDetails->city();
        $loginLog->country = $userDetails->country();

        //Checking from AD Sarver
        $ldaphost = "10.64.1.3";
        $ldapuser = $login . "@cpbd.co.bd";
        // connect to active directory
        $ldapconn = @ldap_connect($ldaphost);

        ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
        $ldapbind = @ldap_bind($ldapconn, $ldapuser, $password);


        // $client = new \GuzzleHttp\Client();

        // $response = $client->request('POST', 'http://202.51.191.2/api/Ldap/adUserCheck.php',[
        //     'form_params' => [
        //         'login' => $login,
        //         'password' => $password,
        //     ]
        // ]);


       // dd($ldapbind);

        //If AD ID Pass Ok
        if ($ldapbind == 1)
        {

            //fetch data by id password
            $data = Admin::where('login', '=', $login)->first();
            if ($data) {
                $status = $data->status;
                if ($status == 1) {

                    //Data Store As Object
                    session()->put('admin', $data);

                    //correct loging status
                    $loginLog->status = 1;
                    $loginLogSt = $loginLog->save();

                    if ($loginLogSt) {
                        //Superadmin Access Check
                        if ($data->super == 1) {
                            return redirect()->route('super.dashboard');
                        } else {
                            return redirect()->route('admin.dashboard');
                        }
                    } else {
                        return back()->with('error', 'Wrong Login Details Not Save');
                    }
                } else {
                    //error login status
                    $loginLog->status = 0;
                    $loginLogSt = $loginLog->save();
                    return back()->with('error', 'Your Id was Deactivated');
                }
            } else {
                //error login status
                $loginLog->status = 0;
                $loginLogSt = $loginLog->save();
                return back()->with('error', 'Wrong Login Details');
            }
        } else {
            //error AD login status
            $loginLog->status = 0;
            $loginLogSt = $loginLog->save();
            return back()->with('error', 'Invalid AD UseID or Password');
        }
    }


    //Locally Admin login
    public function loginAction(Request $request)
    {
        $login  = $request->input('login');
        $password = $request->input('password');

        //for user details class object
        $userDetails = new UserInfo();

        //store Login log
        $loginLog = new AdminLoginLog();
        $loginLog->login_id = $login;
        $loginLog->ip = $userDetails->get_ip();
        $loginLog->os = $userDetails->get_os();
        $loginLog->device = $userDetails->get_device();
        $loginLog->browser = $userDetails->get_browser();
        $loginLog->city = $userDetails->city();
        $loginLog->country = $userDetails->country();

        //fetch data by id password
        $data = Admin::where(['login' => $login, 'password' => $password])->first();

        if ($data) {
            $status = $data->status;
            if ($status == 1) {

                //Data Store As Object
                session()->put('admin', $data);

                //correct loging status
                $loginLog->status = 1;
                $loginLogSt = $loginLog->save();

                if ($loginLogSt) {
                    //Superadmin Access Check
                    if( $data->super == 1 ){
                        return redirect()->route('super.dashboard');
                    }else{
                        return redirect()->route('admin.dashboard');
                    }

                } else {
                    return back()->with('error', 'Wrong Login Details Not Save');
                }
            } else {
                //error login status
                $loginLog->status = 0;
                $loginLogSt = $loginLog->save();
                return back()->with('error', 'Your Id was bolcked');
            }
        } else {
            //error login status
            $loginLog->status = 0;
            $loginLogSt = $loginLog->save();
            return back()->with('error', 'Wrong Login Details');
        }
    }

    //Logout function
    public function Logout()
    {
        //login id
        $loginId = session()->get('admin.login');
        // find last loging log id
        $data = AdminLoginLog::where('login_id', $loginId)
            ->orderBy('id', 'desc')->take(1)
            ->first();
        if ($data) {
            $id = $data->id;
            //make object and update logout time
            $loginLog = new AdminLoginLog();
            $loginLog = AdminLoginLog::find($id);
            //current time
            $loginLog->logout = date('Y-m-d H:i:s');
            $loginlog_success = $loginLog->save();

            if ($loginlog_success) {
                //session()->flush();
                session()->forget('admin');
                return redirect()->route('admin.login.form');
            } else {
                return "Somthing Going Wrong";
            }
        }
        else{
            session()->forget('admin');
            return redirect()->route('admin.login.form');
        }
    }


}
