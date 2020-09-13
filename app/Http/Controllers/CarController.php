<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Car;
use DB;
use App\User;
use App\CarBooking;
use App\Driver;

class CarController extends Controller
{
    public function Index(){

        $bookingChart = DB::table('car_bookings')
            ->leftjoin('cars', 'cars.id', '=', 'car_bookings.car_id')
            ->select('cars.number',  DB::raw('count(*) as total'))
            ->groupBy('cars.number')
            ->get();

        $userBookingChart = DB::table('car_bookings')
            ->leftjoin('users', 'users.id', '=', 'car_bookings.user_id')
            ->select('users.name',  DB::raw('count(*) as total'))
            ->groupBy('users.name')
            ->get();

        $TotalcarUser = User::where('car', '1')->count();
        $TotalBooking = CarBooking::where('status', '1')->count();
        $TotalDriver = Driver::where('status', '1')->count();
        $TotalCar = Car::where('status', '1')->count();

        // echo "<pre>";
        // print_r($userBookingChart);

        //echo $TotalcarUser;

        return view('admin.car.index')->with('bookingChart', $bookingChart)->with('userBookingChart', $userBookingChart)->with('TotalcarUser', $TotalcarUser)->with('TotalBooking', $TotalBooking)->with('TotalDriver', $TotalDriver)->with('TotalCar', $TotalCar);

    }

    public function All(){
        $allData = Car::orderBy('id', 'desc')->get();
        return view('admin.car.car-all')->with('allData', $allData);
    }

    public function Add()
    {
        return view('admin.car.car-add');
    }

    //Insert
    public function Insert(Request $request)
    {
        $validateData = $request->validate([
            'number' => 'required | unique:cars',
            'image' => 'required | max:500 |mimes:jpg,jpeg,bmp,png',
            'image2' => 'required | max:500 |mimes:jpg,jpeg,bmp,png',
            'image3' => 'required | max:500 |mimes:jpg,jpeg,bmp,png',

        ]);

        $data = new Car();

        $image = $request->file('image');
        if ($image) {
            $image_name = str_random(5);
            $ext = strtolower($image->getClientOriginalExtension());
            $image_full_name = $image_name . '.' . $ext;
            $upload_path = 'public/images/car/';
            $image_url = $upload_path . $image_full_name;
            $successImg = $image->move($upload_path, $image_full_name);
            $data->image = $image_url;
        }

        $image2 = $request->file('image2');
        if ($image2) {
            $image2_name = str_random(5);
            $ext = strtolower($image2->getClientOriginalExtension());
            $image2_full_name = $image2_name . '.' . $ext;
            $upload_path = 'public/images/car/';
            $image2_url = $upload_path . $image2_full_name;
            $successImg2 = $image2->move($upload_path, $image2_full_name);
            $data->image2 = $image2_url;
        }
        $image3 = $request->file('image3');
        if ($image3) {
            $image3_name = str_random(5);
            $ext = strtolower($image3->getClientOriginalExtension());
            $image3_full_name = $image3_name . '.' . $ext;
            $upload_path = 'public/images/car/';
            $image3_url = $upload_path . $image3_full_name;
            $successImg3 = $image3->move($upload_path, $image3_full_name);
            $data->image3 = $image3_url;
        }
        if ($successImg && $successImg2 && $successImg3) {
            $data->number = request('number');
            $data->name = request('name');
            $data->capacity = request('capacity');
            $data->status = request('status');
            $data->temporary = request('temporary');
            $data->remarks = request('remarks');
            $successData = $data->save();
            //echo $data;
        }

        if ($successData) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'Data Inserted',
                'alert-type' => 'success'
            );
            return Redirect()->route('car.all')->with($notification);
        } else {
            $notification = array(
                'title' => 'Error',
                'messege' => 'Somthing Going Wrong',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
    }

    //Car use Deadline Fix
    public function DeadlineFix(Request $request){
        $id = request('id');
        $data = car::find($id);

        $data->last_use = request('last_use');
        $successData = $data->save();
        //echo $data;

        if ($successData) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'Data updated',
                'alert-type' => 'info'
            );
            return Redirect()->back()->with($notification);
            //return Redirect()->route('contact.all')->with($notification);
        } else {
            $notification = array(
                'title' => 'Error',
                'messege' => 'Somthing Going Wrong',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }

    }

    //Car use deadline clear
    public function DeadlineClear($id){
        $data = car::find($id);

        $data->last_use = null;
        $successData = $data->save();
        //echo $data;

        if ($successData) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'deadline removed',
                'alert-type' => 'info'
            );
            return Redirect()->back()->with($notification);
            //return Redirect()->route('contact.all')->with($notification);
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
    public function EditFormShow($id){
        $data = Car::findOrFail($id);
        return view('admin.car.car-edit')->with('data', $data);
    }

    //Update
    public function Update(Request $request, $id){
        $validateData = $request->validate([
            'image' => 'max:500 |mimes:jpg,jpeg,bmp,png',
            'image2' => 'max:500 |mimes:jpg,jpeg,bmp,png',
            'image3' => 'max:500 |mimes:jpg,jpeg,bmp,png',
        ]);

        $data = Car::findOrFail($id);

        $image = $request->file('image');
        if ($image) {
            $image_path = $data->image;
            if ($image_path) {
                @unlink($image_path);
            }
            $image_name = str_random(5);
            $ext = strtolower($image->getClientOriginalExtension());
            $image_full_name = $image_name . '.' . $ext;
            $upload_path = 'public/images/car/';
            $image_url = $upload_path . $image_full_name;
            $successImg = $image->move($upload_path, $image_full_name);
            $data->image = $image_url;
        }

        $image2 = $request->file('image2');
        if ($image2) {
            $image_path2 = $data->image2;
            if ($image_path2) {
                @unlink($image_path2);
            }
            $image2_name = str_random(5);
            $ext = strtolower($image2->getClientOriginalExtension());
            $image2_full_name = $image2_name . '.' . $ext;
            $upload_path = 'public/images/car/';
            $image2_url = $upload_path . $image2_full_name;
            $successImg2 = $image2->move($upload_path, $image2_full_name);
            $data->image2 = $image2_url;
        }

        $image3 = $request->file('image3');
        if ($image3) {
            $image_path3 = $data->image3;
            if ($image_path3) {
                @unlink($image_path3);
            }
            $image3_name = str_random(5);
            $ext = strtolower($image3->getClientOriginalExtension());
            $image3_full_name = $image3_name . '.' . $ext;
            $upload_path = 'public/images/car/';
            $image3_url = $upload_path . $image3_full_name;
            $successImg3 = $image3->move($upload_path, $image3_full_name);
            $data->image3 = $image3_url;
        }

            $data->name = request('name');
            $data->capacity = request('capacity');
            $data->status = request('status');
            $data->temporary = request('temporary');
            $data->remarks = request('remarks');
            $successData = $data->save();
            //echo $data;

        if ($successData) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'Data Updated',
                'alert-type' => 'success'
            );
            return Redirect()->route('car.all')->with($notification);
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
    public function Delete($id){

        $data = Car::find($id);
        //Image Path
        $image_path = $data->image;
        if (file_exists($image_path)) {
            //Delete Existing File
            @unlink($image_path);
        }
        //Image Path
        $image_path2 = $data->image2;
        if (file_exists($image_path2)) {
            //Delete Existing File
            @unlink($image_path2);
        }
        //Image Path
        $image_path3 = $data->image3;
        if (file_exists($image_path3)) {
            //Delete Existing File
            @unlink($image_path3);
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

    //Car Details
    public function Details(Request $request){
        $id = $request->get('id');
        $data = Car::findOrFail($id);
        return $data;
    }
}
