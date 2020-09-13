<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Driver;
use App\Car;
use DB;
use App\CarMaintenance;
use App\CarRequisition;
use App\DiverLeave;
use App\Http\Controllers\CheckStForCarpool;

class DriverController extends Controller
{

    public function All(){
        $allData = DB::table('drivers')
                    ->join('cars', 'cars.id', '=','drivers.car_id')
                    ->select('drivers.*', 'cars.id as carId', 'cars.name as carName', 'cars.number', 'cars.image as carImage', 'cars.temporary')
                    ->get();
        //  echo "<pre>";
        //  print_r($allData);
        return view('admin.car.driver-all')->with('allData', $allData);
    }

    public function Add(){
        $carData = DB::table('cars')
            ->leftjoin('drivers', 'cars.id', '=', 'drivers.car_id')
            ->where('cars.status', '=', '1')
            ->whereNull('drivers.car_id')
            ->select('cars.id', 'cars.name', 'cars.number')
            ->get();
        return view('admin.car.driver-add')->with('carData', $carData);
    }

    //Insert
    public function Insert(Request $request){
        $validateData = $request->validate([
            'name' => 'required | unique:drivers',
            'image' => 'required | max:300', // file only jgp and size Not more than 500 kb
        ]);

        $data = new Driver();

        $image = $request->file('image');
        if ($image) {
            $image_name = str_random(5);
            $ext = strtolower($image->getClientOriginalExtension());
            $image_full_name = $image_name . '.' . $ext;
            $upload_path = 'public/images/driver/';
            $image_url = $upload_path . $image_full_name;
            $successImg = $image->move($upload_path, $image_full_name);
            $data->image = $image_url;
        }


        if ($successImg ) {
            $data->name = request('name');
            $data->car_id = request('car_id');
            $data->contact = request('contact');
            $data->nid = request('nid');
            $data->license = request('license');
            $data->status = 1;
            $successData = $data->save();
            //echo $data;
        }

        if ($successData) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'Data Inserted',
                'alert-type' => 'success'
            );
            return Redirect()->route('driver.all')->with($notification);
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
        //SELECT * FROM `cars` LEFT JOIN drivers ON cars.id = drivers.car_id WHERE drivers.car_id IS NULL
        $carData = DB::table('cars')
            ->leftjoin('drivers', 'cars.id', '=', 'drivers.car_id')
            ->where('cars.status', '=', '1')
            ->whereNull('drivers.car_id')
            ->select('cars.id', 'cars.name', 'cars.number')
            ->get();

        // echo "<pre>";
        // print_r($carData);
        //$data = Driver::findOrFail($id);
        $data = DB::table('drivers')
            ->join('cars', 'cars.id', '=', 'drivers.car_id')
            ->where('drivers.id', '=', $id)
            ->select('drivers.*', 'cars.id as carId', 'cars.name as carName', 'cars.number')
            ->first();

        return view('admin.car.driver-edit')->with('data', $data)->with('carData', $carData);
    }

    //Update
    public function Update(Request $request, $id){
        $validateData = $request->validate([
            'image' => 'max:300', // file only jgp and size Not more than 500 kb
        ]);

        $data = Driver::findOrFail($id);

        $image = $request->file('image');
        if ($image) {
            $image_path = $data->image;
            if ($image_path) {
                @unlink($image_path);
            }
            $image_name = str_random(5);
            $ext = strtolower($image->getClientOriginalExtension());
            $image_full_name = $image_name . '.' . $ext;
            $upload_path = 'public/images/driver/';
            $image_url = $upload_path . $image_full_name;
            $successImg = $image->move($upload_path, $image_full_name);
            $data->image = $image_url;
        }

            $data->name = request('name');
            $data->car_id = request('car_id');
            $data->contact = request('contact');
            $data->nid = request('nid');
            $data->license = request('license');
            $data->status = 1;
            $successData = $data->save();
            //echo $data;


        if ($successData) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'Data Updated',
                'alert-type' => 'success'
            );
            return Redirect()->route('driver.all')->with($notification);
        } else {
            $notification = array(
                'title' => 'Error',
                'messege' => 'Somthing Going Wrong',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
    }

    //Action Modal CarMaintenance, CarRequisition, DiverLeave
    public function ModalAction(Request $request){
        $leaveType = request('leaveType');
        $car_id = request('car_id');
        $driver_id = request('driver_id');
        $start = request('start') . ' ' . request('startHour');
        $end = request('end') . ' ' . request('endHour');
        $status = 1;
        $currentTime = date('Y-m-d H:i:s', time()); // h=12 hours H=24 hours

        //Checking Section
        $check = new CheckStForCarpool();

         //Check Another booking have or not
        if ($check->CheckBookingHaveOrNot($car_id, $start, $end)) {
            $notification = array(
                'title' => 'Error',
                'messege' => 'Already Booked By Another !!',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }

        if($leaveType == 'maintenance'){

            //Check data have or not after today
            $countCarMaintData = CarMaintenance::where('car_id', '=', $car_id)
                ->where('driver_id', '=', $driver_id)
                ->where('end', '>', $currentTime)
                ->where('status', '=', '1')
                ->orderBy('id', 'desc')
                ->count();

            if ($countCarMaintData > 0) {
                $notification = array(
                    'title' => 'Error',
                    'messege' => 'You are already do this !!',
                    'alert-type' => 'error'
                );
                return Redirect()->back()->with($notification);
            } else {
                $carMaintData = new CarMaintenance();
                $carMaintData->car_id = $car_id;
                $carMaintData->driver_id = $driver_id;
                $carMaintData->start = $start;
                $carMaintData->end = $end;
                $carMaintData->status = $status;
                $successData = $carMaintData->save();
            }
        }
        elseif($leaveType == 'police'){

            //Check data have or not after today
            $countCarReqData = CarRequisition::where('car_id', '=', $car_id)
                ->where('driver_id', '=', $driver_id)
                ->where('end', '>', $currentTime)
                ->where('status', '=', '1')
                ->orderBy('id', 'desc')
                ->count();

            if ($countCarReqData > 0) {
                $notification = array(
                    'title' => 'Error',
                    'messege' => 'You are already do this !!',
                    'alert-type' => 'error'
                );
                return Redirect()->back()->with($notification);
            } else {
                $carReqData = new CarRequisition();
                $carReqData->car_id = $car_id;
                $carReqData->driver_id = $driver_id;
                $carReqData->start = $start;
                $carReqData->end = $end;
                $carReqData->status = $status;
                $successData = $carReqData->save();
            }
        }
        else{

            //Check data have or not after today
            $countDriverLeaveData = DiverLeave::where('car_id', '=', $car_id)
                ->where('driver_id', '=', $driver_id)
                ->where('end', '>', $currentTime)
                ->where('status', '=', '1')
                ->orderBy('id', 'desc')
                ->count();

            if ($countDriverLeaveData >0 ){
                $notification = array(
                    'title' => 'Error',
                    'messege' => 'You are already do this !!',
                    'alert-type' => 'error'
                );
                return Redirect()->back()->with($notification);
            }else{
                $driverLeaveData = new DiverLeave();
                $driverLeaveData->car_id = $car_id;
                $driverLeaveData->driver_id = $driver_id;
                $driverLeaveData->start = $start;
                $driverLeaveData->end = $end;
                $driverLeaveData->status = $status;
                $successData = $driverLeaveData->save();
            }

        }

        if ($successData) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'Data Inserted',
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

    //Driver Details
    public function Details(Request $request){
        $id = $request->get('id');
        $data = Driver::findOrFail($id);
        return $data;
    }


}
