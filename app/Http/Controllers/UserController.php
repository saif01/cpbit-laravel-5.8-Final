<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Department;
use App\BuLocation;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserRegisterMail;
use DB;


class UserController extends Controller
{

    public function All()
    {
        $allData = User::orderBy('id', 'desc')->get();
       // dd($allData);

        // $count = 0;
        // //Count How Many User Online
        // foreach ($allData as $row) {
        //    if ($row->isOnline()) {
        //     $count ++;
        //    }
        // }
        // echo $count;

        return view('admin.super.user-all')->with('allData', $allData);
    }

    public function Add()
    {
        $buLocation = BuLocation::orderBy('bu_location')->get();
        $deptData = Department::orderBy('dept_name')->get();
        return view('admin.super.user-add')->with('deptData', $deptData)->with('buLocation', $buLocation);
    }

    //Insert
    public function Insert(Request $request)
    {
        $validateData = $request->validate([
            'login' => 'required | min:3 | max:50 | unique:users',
            'image' => 'required | max:500 | mimes:jpg,jpeg,bmp,png', // file only jgp and size Not more than 500 kb

        ]);


        $data = new User();

        $image = $request->file('image');
        if ($image) {
            $image_name = str_random(5);
            $ext = strtolower($image->getClientOriginalExtension());
            $image_full_name = $image_name . '.' . $ext;
            $upload_path = 'public/images/user/';
            $image_url = $upload_path . $image_full_name;
            $successImg = $image->move($upload_path, $image_full_name);
        }

        $login = strtolower($request->login);
        $name = $request->name;
        $email = $request->email;

        if ($successImg) {
            $data->login = $login;
            $data->name = $name;
            $data->contact = request('contact');
            $data->bu_location = request('bu_location');
            $data->department = request('department');
            $data->office_id = request('office_id');
            $data->email = request('email');
            $data->bu_email = request('bu_email');
            $data->status = request('status');
            $data->car = request('car');
            $data->room = request('room');
            $data->it_connect = request('it_connect');
            $data->cms = request('cms');
            $data->corona = request('corona');

            $data->image = $image_url;
            $successData = $data->save();
            //echo $data;
        }

        $mailData = (object) array(
            'id' => $login,
            'name' => $name,
        );

        //Send Mail
        Mail::to($email)->send(new UserRegisterMail($mailData));

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
            return Redirect()->route('user.all')->with($notification);
        } else {
            $notification = array(
                'title' => 'Error',
                'messege' => 'Somthing Going Wrong',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
    }

    //Edit Form Show
    public function EditFormShow($id)
    {
        $data = User::findOrFail($id);
        $buLocation = BuLocation::orderBy('bu_location')->get();
        $deptData = Department::orderBy('dept_name')->get();
        return view('admin.super.user-edit')->with('data', $data)->with('deptData', $deptData)->with('buLocation', $buLocation);
    }

    //Update
    public function Update(Request $request, $id)
    {
        $validateData = $request->validate([
            'image' => 'max:500 | mimes:jpg,jpeg,bmp,png',
            //'email' => 'unique:users,email,'.$id,
        ]);

        $data = User::findOrFail($id);

        $image = $request->file('image');
        if ($image) {
            $image_path = $data->image;
            if ($image_path) {
                @unlink($image_path);
            }
            $image_name = str_random(5);
            $ext = strtolower($image->getClientOriginalExtension());
            $image_full_name = $image_name . '.' . $ext;
            $upload_path = 'public/images/user/';
            $image_url = $upload_path . $image_full_name;
            $successImg = $image->move($upload_path, $image_full_name);
            $data->image = $image_url;
        }

        $data->name = request('name');
        $data->contact = request('contact');
        $data->bu_location = request('bu_location');
        $data->department = request('department');
        $data->office_id = request('office_id');
        $data->email = request('email');
        $data->bu_email = request('bu_email');
        $data->status = request('status');
        $data->car = request('car');
        $data->room = request('room');
        $data->it_connect = request('it_connect');
        $data->cms = request('cms');
        $data->corona = request('corona');
        $successData = $data->save();
        //echo $data;


        if ($successData) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'Data Updated',
                'alert-type' => 'info'
            );
            return Redirect()->route('user.all')->with($notification);
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
    public function Delete($id)
    {

        $data = User::find($id);
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

    //User Details
    public function Details(Request $request){
        $id = $request->get('id');
        $data = User::findOrFail($id);
        return $data;
    }

    //Active User Count
    public function ActiveUserCount(){
         $allData = User::get();
       // dd($allData);
        $count = 0;
        //Count How Many User Online
        foreach ($allData as $row) {
           if ($row->isOnline()) {
            $count ++;
           }
        }
        return $count;
    }

    //User Activity
    public function UserActivity(){
        $allData = User::orderBy('id', 'desc')->get();
        return view('admin.super.user-activity')->with('allData', $allData);
    }

    //Find Last Login
    Public function LastLogin($login){
        return DB::table('user_login_logs')
            ->where('login_id', '=', $login)
            ->orderBy('id', 'desc')
            ->select('created_at')
            ->first();
    }

    //UserActivityLoginlog
    public function UserActivityLoginlog(Request $request){
        $login = $request->get('login');
        return  DB::table('user_login_logs')
            ->where('login_id', '=', $login)
            ->orderBy('id', 'desc')
            ->take(30)
            ->get();

    }

}
