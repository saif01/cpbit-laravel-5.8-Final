<?php

namespace App\Http\Controllers;
use DB;
use App\Car;

use Illuminate\Http\Request;

class CarReportsController extends Controller
{

    //All Carpool Calendar Report
    public function ReportsCalendar(){
        $bookingData = DB::table('car_bookings')
            ->join('users', 'users.id', '=', 'car_bookings.user_id')
            ->join('cars', 'cars.id', '=', 'car_bookings.car_id')
            ->join('drivers', 'drivers.id', '=', 'car_bookings.driver_id')
            ->where('car_bookings.status', '=', '1')
            ->orderBy('car_bookings.id', 'desc')
            ->select('car_bookings.id', DB::raw("CONCAT(cars.number,' || ',car_bookings.destination,' || ',users.name,' || ',users.department) as title"), 'car_bookings.start', 'car_bookings.end', 'users.name as userName', 'users.department', 'car_bookings.destination', 'car_bookings.purpose', 'car_bookings.start', 'car_bookings.end', 'drivers.name as driverName', 'cars.number')
            ->take(500)
            ->get();

        $carData = DB::table('cars')
            ->join('drivers', 'drivers.car_id', '=', 'cars.id')
            ->select('cars.id','cars.name', 'cars.number', 'drivers.name as driverName')
            ->get();

        return view('admin.car.report-calendar')->with('bookingData', json_encode($bookingData))->with('carData', $carData);
    }

    //Single Car Carpool Calendar Report
    public function ReportsCalendarForSearch(Request $request){
        $Id = $request->searchCarId;

        $bookingData = DB::table('car_bookings')
            ->join('users', 'users.id', '=', 'car_bookings.user_id')
            ->join('cars', 'cars.id', '=', 'car_bookings.car_id')
            ->join('drivers', 'drivers.id', '=', 'car_bookings.driver_id')
            ->where('cars.id', '=', $Id)
            ->where('car_bookings.status', '=', '1')
            ->select('car_bookings.id', DB::raw("CONCAT(cars.number,' || ',car_bookings.destination,' || ',users.name,' || ',users.department) as title"), 'car_bookings.start', 'car_bookings.end', 'users.name as userName', 'users.department', 'car_bookings.destination', 'car_bookings.purpose', 'car_bookings.start', 'car_bookings.end', 'drivers.name as driverName', 'cars.number')
            ->get();

        $carData = DB::table('cars')
            ->join('drivers', 'drivers.car_id', '=', 'cars.id')
            ->select('cars.id', 'cars.name', 'cars.number', 'drivers.name as driverName')
            ->get();

        $searchData = DB::table('cars')
            ->where('id', '=',  $Id)
            ->select('name', 'number')
            ->first();

        // echo "<pre>";
        // print_r($searchData);

         return view('admin.car.report-calendar')->with('bookingData', json_encode($bookingData))->with('carData', $carData)->with('searchData', $searchData);
    }

    //All Carpool  Report
    public function ReportsAll(){
        $allData = DB::table('car_bookings')
            ->join('cars', 'cars.id', '=', 'car_bookings.car_id')
            ->join('drivers','drivers.id', '=', 'car_bookings.driver_id')
            ->join('users', 'users.id', '=', 'car_bookings.user_id')
            ->orderBy('car_bookings.id', 'desc')
            ->select('car_bookings.*', 'cars.name', 'cars.number', 'users.name as userName', 'drivers.name as driverName')
            ->take(500)
            ->get();

        $carData = DB::table('cars')
            ->join('drivers', 'cars.id', '=', 'drivers.car_id')
            ->where('cars.status', '=', '1')
            ->select('cars.id', 'cars.name', 'cars.number', 'drivers.name as driverName')
            ->get();

            // echo "<pre>";
            // print_r($allData);

            return view('admin.car.reports-all')->with('allData', $allData)->with('carData', $carData);

    }

    // //All Carpool Report for Super Admin
    // public function ReportsAllForSuper(){
    //     $allData = DB::table('car_bookings')
    //         ->join('cars', 'cars.id', '=', 'car_bookings.car_id')
    //         ->join('drivers', 'drivers.id', '=', 'car_bookings.driver_id')
    //         ->join('users', 'users.id', '=', 'car_bookings.user_id')
    //         ->orderBy('car_bookings.id', 'desc')
    //         ->select('car_bookings.*', 'cars.name', 'cars.number', 'users.name as userName', 'drivers.name as driverName')
    //         ->get();

    //     $carData = DB::table('cars')
    //         ->join('drivers', 'cars.id', '=', 'drivers.car_id')
    //         ->where('cars.status', '=', '1')
    //         ->select('cars.id', 'cars.name', 'cars.number', 'drivers.name as driverName')
    //         ->get();

    //     // echo "<pre>";
    //     // print_r($allData);

    //     return view('admin.super.reports.carpool')->with('allData', $allData)->with('carData', $carData);
    // }

    // //Single Car Carpool Report
    // public function ReportBySearchForSuper(Request $request)
    // {

    //     $start = $request->start . " 00:00:00";
    //     $end = $request->end . " 23:59:59";
    //     $car_id = $request->car_id;
    //     //make Object
    //     $searchData = (object) array('start' => $start, 'end' => $end);


    //     if ($car_id == 'AllCar') {
    //         $allData = DB::table('car_bookings')
    //             ->join('cars', 'cars.id', '=', 'car_bookings.car_id')
    //             ->join('drivers', 'drivers.id', '=', 'car_bookings.driver_id')
    //             ->join('users', 'users.id', '=', 'car_bookings.user_id')
    //             ->where('car_bookings.start', '>=', $start)
    //             ->where('car_bookings.end', '<=', $end)
    //             ->orderBy('car_bookings.id', 'desc')
    //             ->select('car_bookings.*', 'cars.name', 'cars.number', 'users.name as userName', 'drivers.name as driverName')
    //             ->get();
    //     } else {
    //         $allData = DB::table('car_bookings')
    //             ->join('cars', 'cars.id', '=', 'car_bookings.car_id')
    //             ->join('drivers', 'drivers.id', '=', 'car_bookings.driver_id')
    //             ->join('users', 'users.id', '=', 'car_bookings.user_id')
    //             ->where('car_bookings.car_id', '=', $car_id)
    //             ->where('car_bookings.start', '>=', $start)
    //             ->where('car_bookings.end', '<=', $end)
    //             ->orderBy('car_bookings.id', 'desc')
    //             ->select('car_bookings.*', 'cars.name', 'cars.number', 'users.name as userName', 'drivers.name as driverName')
    //             ->get();
    //     }



    //     $carData = DB::table('cars')
    //         ->join('drivers', 'cars.id', '=', 'drivers.car_id')
    //         ->where('cars.status', '=', '1')
    //         ->select('cars.id', 'cars.name', 'cars.number', 'drivers.name as driverName')
    //         ->get();

    //     // echo "<pre>";
    //     // print_r($allData);

    //     return view('admin.super.reports.carpool')->with('allData', $allData)->with('carData', $carData)->with('searchData', $searchData);
    // }

    //Single Car Carpool Report
    public function ReportBySearch(Request $request){

        $start = $request->start . " 00:00:00";
        $end = $request->end . " 23:59:59";
        $car_id = $request ->car_id;
        //make Object
        $searchData = (object) array('start' => $start , 'end' => $end );


        if($car_id == 'AllCar'){
            $allData = DB::table('car_bookings')
                ->join('cars', 'cars.id', '=', 'car_bookings.car_id')
                ->join('drivers', 'drivers.id', '=', 'car_bookings.driver_id')
                ->join('users', 'users.id', '=', 'car_bookings.user_id')
                ->where('car_bookings.start', '>=', $start)
                ->where('car_bookings.end', '<=', $end)
                ->orderBy('car_bookings.id', 'desc')
                ->select('car_bookings.*', 'cars.name', 'cars.number', 'users.name as userName', 'drivers.name as driverName')
                ->get();
        }else{
            $allData = DB::table('car_bookings')
                ->join('cars', 'cars.id', '=', 'car_bookings.car_id')
                ->join('drivers', 'drivers.id', '=', 'car_bookings.driver_id')
                ->join('users', 'users.id', '=', 'car_bookings.user_id')
                ->where('car_bookings.car_id', '=', $car_id)
                ->where('car_bookings.start', '>=', $start)
                ->where('car_bookings.end', '<=', $end)
                ->orderBy('car_bookings.id', 'desc')
                ->select('car_bookings.*', 'cars.name', 'cars.number', 'users.name as userName', 'drivers.name as driverName')
                ->get();
        }



        $carData = DB::table('cars')
            ->join('drivers', 'cars.id', '=', 'drivers.car_id')
            ->where('cars.status', '=', '1')
            ->select('cars.id', 'cars.name', 'cars.number', 'drivers.name as driverName')
            ->get();

        // echo "<pre>";
        // print_r($allData);

        return view('admin.car.reports-all')->with('allData', $allData)->with('carData', $carData)->with('searchData', $searchData);
    }

    //Car Maintenance Report
    public function MaintenanceReport(){
        $allData = DB::table('car_maintenances')
            ->join('cars', 'cars.id', '=', 'car_maintenances.car_id')
            ->join('drivers', 'drivers.id', '=', 'car_maintenances.driver_id')
            ->select('car_maintenances.*', 'cars.name', 'cars.number', 'drivers.name as driverName')
            ->orderBy('car_maintenances.id', 'desc')
            ->get();

        // echo "<pre>";
        // print_r($allData);
        return view('admin.car.reports-maintenance')->with('allData', $allData);
    }

    //Car  Driver LeaveReport Report
    public function DriverLeaveReport(){
        $allData = DB::table('diver_leaves')
            ->join('cars', 'cars.id', '=', 'diver_leaves.car_id')
            ->join('drivers', 'drivers.id', '=', 'diver_leaves.driver_id')
            ->select('diver_leaves.*', 'cars.name', 'cars.number', 'drivers.name as driverName')
            ->orderBy('diver_leaves.id', 'desc')
            ->get();

        // echo "<pre>";
        // print_r($allData);
        return view('admin.car.reports-leave')->with('allData', $allData);
    }

    //Car Police Requisition Report
    public function CarRequisitionReport(){
        $allData = DB::table('car_requisitions')
            ->join('cars', 'cars.id', '=', 'car_requisitions.car_id')
            ->join('drivers', 'drivers.id', '=', 'car_requisitions.driver_id')
            ->select('car_requisitions.*', 'cars.name', 'cars.number', 'drivers.name as driverName')
            ->orderBy('car_requisitions.id', 'desc')
            ->get();
            // echo "<pre>";
            // print_r($allData);
        return view('admin.car.reports-requisition')->with('allData', $allData);
    }

    public function testFunction($data=null){

        //return "Check".$data;
        return view('test')->with('data', $data);
    }

}
