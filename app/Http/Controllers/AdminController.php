<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Admin;
use App\Department;
use Session;
use App\User;
use App\Car;
use App\Room;
use App\AppComplain;
use App\HardComplian;
use App\UserLoginLog;
use App\AdminLoginLog;
use DB;
use Artisan;

use Illuminate\Support\Facades\Mail;
use App\Mail\AdminRegisterMail;

use Illuminate\Contracts\Foundation\Application;

class AdminController extends Controller
{

     public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function Index(){
        $TotalAdmin = Admin::where('status', '1')->count();
        $TotalUser = User::where('status', '1')->count();
        $TotalRoom = Room::where('status', '1')->count();
        $TotalCar = Car::where('status', '1')->count();
        $totalComplainApp  = AppComplain::where('status', '1')->count();
        $PendingApp = AppComplain::where('process', '!=', 'Closed')->count();

        $totalComplainHard = HardComplian::where('status', '1')->count();
        $pandingHard = HardComplian::where('process', '!=', 'Closed')
            ->where('process', '!=', 'Damaged')
            ->count();
        $pandingDelivery = HardComplian::where('process', '=', 'Closed')
            ->where('delivery', '=', 'Deliverable')
            ->count();

        return view('admin.super.index')
            ->with('TotalUser', $TotalUser)
            ->with('TotalAdmin', $TotalAdmin)
            ->with('TotalRoom', $TotalRoom)
            ->with('TotalCar', $TotalCar)
            ->with('totalComplainApp', $totalComplainApp)
            ->with('PendingApp', $PendingApp)
            ->with('totalComplainHard', $totalComplainHard)
            ->with('pandingDelivery', $pandingDelivery)
            ->with('pandingHard', $pandingHard);
    }

    //Add
    public function Add(){
        $deptData = Department::orderBy('dept_name')->get();
        return view('admin.super.admin-add')
            ->with('deptData', $deptData);
    }

    //All
    public function All(){
        $allData = Admin::orderBy('id', 'desc')->get();
        //dd($allData);
        return view('admin.super.admin-all')->with('allData', $allData);
    }

    //Insert
    public function Insert(Request $request){
        $validateData = $request->validate([
            'login' => 'required | min:3 | max:50 | unique:admins,login',
            'image' => 'required | max:500 | mimes:jpg,jpeg,bmp,png',
            'email' => 'required'
        ]);

       $data = new Admin();

        $image = $request->file('image');
        if ($image) {
            $image_name = str_random(5);
            $ext = strtolower($image->getClientOriginalExtension());
            $image_full_name = $image_name . '.' . $ext;
            $upload_path = 'public/images/admin/';
            $image_url = $upload_path . $image_full_name;
            $successImg = $image->move($upload_path, $image_full_name);

        }

        $login = $request->login;
        $name = $request->name;
        $email = $request->email;

        if ($successImg) {
            $data->login = $login;
            // $data->password = request('password');
            $data->name = $name;
            $data->contact = request('contact');
            $data->department = request('department');
            $data->office_id = request('office_id');
            $data->email = $email;
            $data->status = request('status');
            $data->car = request('car');
            $data->room = request('room');
            $data->network = request('network');
            $data->it_connect = request('it_connect');
            $data->hard = request('hard');
            $data->app = request('app');
            $data->inventory = request('inventory');
            $data->corona = request('corona');
            $data->super = request('super');

            $data->image = $image_url;

            //echo $data;
        }

        $mailData = (object) array(
            'id' => $login,
            'name' => $name,
        );

        //Send Mail
        Mail::to($email)->send(new AdminRegisterMail($mailData));

        //Save Data
        $successData = $data->save();

        if (Mail::failures()) {
            $notification = array(
                'title' => 'Error',
                'messege' => 'Email Not Send',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
        elseif($successData) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'Data Inserted',
                'alert-type' => 'success'
            );
            return Redirect()->route('admin.all')->with($notification);
        } else {
            $notification = array(
                'title' => 'Error',
                'messege' => 'Somthing Going Wrong',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
    }

    //Delete Function
    public function delete($id){
        //if user want to delete his own id
        if (session()->get('admin.id') == $id) {
            $notification = array(
                'title' => 'Error',
                'messege' => 'You can not delete your own ID',
                'alert-type' => 'warning'
            );
            return Redirect()->back()->with($notification);
        }

        $data = Admin::find($id);
        //Image Path
        $image_path = $data->image;
        if (file_exists($image_path)) {
            //Delete Existing File
            @unlink($image_path);
        }
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

    //Single data Find
    public function singleData(Request $request){
        if ($request->get('id')) {
            $id = $request->get('id');
            $data = Admin::findOrFail($id);
            //return response()->json(['data' => $data]);
        }
    }

    public function editFormShow($id){
        $data = Admin::findOrFail($id);
        $deptData = Department::orderBy('dept_name')->get();
        // print_r($data);
        return view('admin.super.admin-edit')->with('data', $data)->with('deptData', $deptData);
    }

    //Update
    public function Update(Request $request, $id){
        $validateData = $request->validate([
            'image' => 'max:500', // file only jgp and size Not more than 500 kb

        ]);

        $data = Admin::findOrFail($id);

        $image = $request->file('image');
        if ($image) {
            $image_path = $data->image;
            if($image_path){
                @unlink($image_path);
            }
            $image_name = str_random(5);
            $ext = strtolower($image->getClientOriginalExtension());
            $image_full_name = $image_name . '.' . $ext;
            $upload_path = 'public/images/admin/';
            $image_url = $upload_path . $image_full_name;
            $successImg = $image->move($upload_path, $image_full_name);
            $data->image = $image_url;
        }

            $data->name = request('name');
            $data->contact = request('contact');
            $data->department = request('department');
            $data->office_id = request('office_id');
            $data->email = request('email');
            $data->status = request('status');
            $data->car = request('car');
            $data->room = request('room');
            $data->network = request('network');
            $data->hard = request('hard');
            $data->app = request('app');
            $data->inventory = request('inventory');
            $data->it_connect = request('it_connect');
            $data->super = request('super');
            $data->corona = request('corona');

            $successData = $data->save();
            //echo $data;


        if ($successData) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'Data Updated',
                'alert-type' => 'info'
            );
            return Redirect()->route('admin.all')->with($notification);
        } else {
            $notification = array(
                'title' => 'Error',
                'messege' => 'Somthing Going Wrong',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
    }

    //Admin Details
    public function Details(Request $request)
    {
        $id = $request->get('id');
        $data = Admin::findOrFail($id);
        return $data;
    }

    //User Login Log
    public function UserLoginLog(){
        //$allData = UserLoginLog::orderBy('id', 'desc')->get();
        $allData = DB::table('user_login_logs')
            ->join('users', 'users.login', '=', 'user_login_logs.login_id')
            ->select('user_login_logs.*', 'users.name', 'users.id as user_id')
            ->orderBy('user_login_logs.id', 'desc')
            ->get();

        return view('admin.super.user-login-log')->with('allData', $allData);
    }

    //User Login Log Error
    public function UserLoginError()
    {
        $allData = UserLoginLog::where('status', '=', '0')->orderBy('id', 'desc')  ->get();
        return view('admin.super.user-login-log-error')->with('allData', $allData);
    }

    //Admin Login Log
    public function AdminLoginLog()
    {
        //$allData = UserLoginLog::orderBy('id', 'desc')->get();
        $allData = DB::table('admin_login_logs')
            ->join('admins', 'admins.login', '=', 'admin_login_logs.login_id')
            ->select('admin_login_logs.*', 'admins.name', 'admins.id as admin_id')
            ->orderBy('admin_login_logs.id', 'desc')
            ->get();

        return view('admin.super.admin-login-log')->with('allData', $allData);
    }

    //Admin Login Log Error
    public function AdminLoginError()
    {
        $allData = AdminLoginLog::where('status', '=', '0')->orderBy('id', 'desc')->get();
        return view('admin.super.admin-login-log-error')->with('allData', $allData);
    }


    //Maintenance
    public function Maintenance(){

         if ($this->app->isDownForMaintenance()) {
            $maintenance = true;
         }else{
            $maintenance = false;
         }

        return view('admin.super.maintenance')->with('maintenance', $maintenance);
    }

     //Maintenance Active
     public function MaintenanceActive(){

            Artisan::call('down');

             //dd(Artisan::output());
             // session()->put('maintenance', Artisan::output() );

            if (Artisan::output()) {
                $notification = array(
                    'title' => 'Successfully',
                    'messege' => 'Active Maintenance',
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

     //Maintenance Active
     public function MaintenanceDeactive(){

        Artisan::call('up');

        //dd(Artisan::output());
       // session()->put('maintenance', Artisan::output() );

        if (Artisan::output()) {
                $notification = array(
                    'title' => 'Successfully',
                    'messege' => 'Deactive Maintenance',
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







}
