<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Driver;
use App\CarBooking;
use DB;
use App\Destination;
use Session;
use App\User;
use App\Car;


use App\Http\Controllers\CheckStForCarpool;

class UserCarPoolController extends Controller
{
    public $currentTime;

    public function __construct()
    {
        $this->currentTime = date('Y-m-d H:i:s', time());
    }

    //Count Not Commented
    public function CommentCount(){
        $data = DB::table('car_bookings')
            ->where('status', '=', '1')
            ->where('user_id', '=', session()->get('user.id'))
             ->where('end', '<=', $this->currentTime)
            ->whereNull('comit_st')
            ->count();

            return $data;
    }

    public function CurrentTime(){
        return $currentTime = date('Y-m-d H:i:s', time());
    }

    //Carpool Dashboard
    public function Dashboard(){
        return view('user.car.index');
    }

    //Regular Car List Page
    public function RegularCars(){
        $allData = DB::table('cars')
            ->join('drivers', 'drivers.car_id', '=', 'cars.id')
            ->where('cars.temporary', '=', '0')
            ->where('cars.status', '=', '1')
            ->select('cars.id as carId','cars.name','cars.number','cars.image', 'cars.capacity', 'drivers.id as driverId', 'drivers.name as driverName', 'drivers.contact', 'drivers.image as driverImage')
            ->get();
        return view('user.car.regular-car-list')->with('allData', $allData);
    }

    //Temporary Car List Page
    public function TemporaryCars(){
        $allData = DB::table('cars')
            ->join('drivers', 'drivers.car_id', '=', 'cars.id')
            ->where('cars.temporary', '=', '1')
            ->where('cars.status', '=', '1')
            ->select('cars.id as carId', 'cars.name', 'cars.number', 'cars.image', 'cars.capacity', 'drivers.id as driverId', 'drivers.name as driverName', 'drivers.contact', 'drivers.image as driverImage')
            ->get();
        return view('user.car.temporary-car-list')->with('allData', $allData);
    }

    //Regular Car Booking Page
    public function RegularCarBooking($carId){
        $data = DB::table('cars')
            ->join('drivers', 'drivers.car_id', '=', 'cars.id')
            ->where('cars.id', '=', $carId)
            ->select('cars.id as carId', 'cars.name', 'cars.number', 'cars.image', 'drivers.id as driverId', 'drivers.name as driverName', 'drivers.contact', 'drivers.image as driverImage')
            ->first();

        $dastination = Destination::orderBy('destination')
            ->select('destination')
            ->get();

        $bookingData = DB::table('car_bookings')
            ->join('users', 'users.id', '=', 'car_bookings.user_id')
            ->join('cars', 'cars.id', '=', 'car_bookings.car_id')
            ->join('drivers', 'drivers.id', '=', 'car_bookings.driver_id')
            ->where('car_bookings.status', '=', '1')
            ->where('car_bookings.car_id', '=', $carId)
            ->where('cars.temporary', '=', '0')
            ->select('car_bookings.id', DB::raw("CONCAT(cars.number,' || ',car_bookings.destination,' || ',users.name,' || ',users.department) as title"), 'car_bookings.start','car_bookings.end', 'users.name as userName', 'users.department', 'car_bookings.destination', 'car_bookings.purpose', 'car_bookings.start', 'car_bookings.end', 'drivers.name as driverName', 'cars.number')
            ->get();

        return view('user.car.regular-car-booking')->with('data', $data)->with('dastination', $dastination)->with('bookingData', json_encode($bookingData));
    }

    //Temporary Car Booking Page
    public function TemporaryCarBooking($carId){
        $data = DB::table('cars')
            ->join('drivers', 'drivers.car_id', '=', 'cars.id')
            ->where('cars.id', '=', $carId)
            ->select('cars.id as carId', 'cars.name', 'cars.number', 'cars.image', 'drivers.id as driverId', 'drivers.name as driverName', 'drivers.contact', 'drivers.image as driverImage')
            ->first();

        $dastination = Destination::orderBy('destination')
            ->select('destination')
            ->get();

        $bookingData = DB::table('car_bookings')
            ->join('users', 'users.id', '=', 'car_bookings.user_id')
            ->join('cars', 'cars.id', '=', 'car_bookings.car_id')
            ->join('drivers', 'drivers.id', '=', 'car_bookings.driver_id')
            ->where('car_bookings.status', '=', '1')
            ->where('cars.temporary', '=', '1')
            ->where('car_bookings.car_id', '=', $carId)
            ->select('car_bookings.id', DB::raw("CONCAT(cars.number,' || ',car_bookings.destination,' || ',users.name,' || ',users.department) as title"), 'car_bookings.start', 'car_bookings.end', 'users.name as userName', 'users.department', 'car_bookings.destination', 'car_bookings.purpose', 'car_bookings.start', 'car_bookings.end', 'drivers.name as driverName', 'cars.number')
            ->get();

        return view('user.car.temporary-car-booking')->with('data', $data)->with('dastination', $dastination)->with('bookingData', json_encode($bookingData));
    }

    //User Booked car Page
    public function UserBookedCar(){
            $allData = DB::table('car_bookings')
            ->join('cars', 'cars.id', '=', 'car_bookings.car_id' )
            ->join('drivers', 'drivers.car_id', '=', 'cars.id')
            ->where('car_bookings.status', '=', '1')
            ->where('car_bookings.user_id', '=', session()->get('user.id'))
            ->where('car_bookings.end', '>=', $this->currentTime)
            ->orderBy('car_bookings.start', 'asc')
            ->select('car_bookings.*', 'cars.id as carId','cars.name', 'cars.number', 'cars.image', 'drivers.name as driverName')
            ->get();
            return view('user.car.user-booked-car')->with('allData', $allData);
    }

    //User Car Comment Store
    public function UserCarCommentAction(Request $request){

        //  $validateData = $request->validate([
        //     'start_mileage' => 'numeric | digits_between:1,10',
        //      'end_mileage' => 'numeric | digits_between:1,10',
        //      'cost' => 'numeric | digits_between:1,10',
        //     'driver_rating' => 'numeric | digits_between:1,10'

        // ]);

        $booking_id = $request->booking_id;
        $data = CarBooking::findOrFail($booking_id);


        $start_mileage =  $request->start_mileage;
        $end_mileage = $request->end_mileage;
        $gas = $request->gas;
        $octane =  $request->octane;
        $toll = $request->toll;

        if(!empty($start_mileage) && !empty($end_mileage)){
            $data->km = $end_mileage - $start_mileage ;
        }


        $data->start_mileage = $start_mileage;
        $data->end_mileage = $end_mileage;
        $data->gas = $gas;
        $data->octane = $octane;
        $data->toll = $toll;
        $data->cost = $gas + $octane + $toll;
        $data->driver_rating = $request->driver_rating;

        //Checking End mileage Greater Than Start mileage
        if(!empty($start_mileage) && !empty($end_mileage)){
            if($start_mileage > $end_mileage){
                $notification = array(
                    'big-title' => 'End Mileage Cannot Graterthan Start Mileage',
                    'big-alert-type' => 'error'
                );
                return Redirect()->back()->with($notification);
            }
        }

        if(isset($request->update)){
            $successData = $data->save();
        }elseif(isset($request->closeComit)){
            $data->comit_st = '1';
            $successData = $data->save();
        }
        else
        {
            $notification = array(
                'big-title' => 'Error !! Somthing Going Wrong',
                'big-alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }


        if ($successData) {
            $notification = array(
                'big-title' => 'Successfully, Comment Updated',
                'big-alert-type' => 'success'
            );
            return Redirect()->back()->with($notification);
        } else {
            $notification = array(
                'big-title' => 'Error !! Somthing Going Wrong',
                'big-alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
    }



    //Not Commented Car Page
    public function UserNotCommentedCar(){
        $allData = DB::table('car_bookings')
            ->join('cars', 'cars.id', '=', 'car_bookings.car_id')
            ->where('car_bookings.status', '1')
            ->where('car_bookings.user_id', session()->get('user.id'))
            ->whereNull('car_bookings.comit_st')
            ->where('car_bookings.start', '<=', $this->currentTime)
            ->orderBy('car_bookings.start', 'asc')
            ->select('car_bookings.*', 'cars.id as carId', 'cars.name', 'cars.number', 'cars.image')
            ->get();
        return view('user.car.not-commented-car')->with('allData', $allData);
    }


    //Canceled Car List
    public function UserCanceledBookingCar(){
        $allData = DB::table('car_bookings')
            ->join('cars', 'cars.id', '=', 'car_bookings.car_id')
            ->where('car_bookings.status', '=', '0')
            ->where('car_bookings.user_id', '=', session()->get('user.id'))
            ->orderBy('car_bookings.id', 'desc')
            ->select('car_bookings.*', 'cars.id as carId', 'cars.name', 'cars.number', 'cars.image')
            ->get(10);
        return view('user.car.booking-canceled-car')->with('allData', $allData);
    }

    //User Profile Page
    public function UserProfile(){
        $allData = User::findOrFail(session()->get('user.id'));
        return view('user.car.user-profile')->with('allData', $allData);
    }

    //Driver Profile Page
    public function DriverProfile($id){
        $allData = Driver::findOrFail($id);
        return view('user.car.driver-profile')->with('allData', $allData);
    }

    //Car Booking History Page
    public function UserBookingHistory(){
        $allData = DB::table('car_bookings')
            ->join('cars', 'cars.id', '=', 'car_bookings.car_id')
            ->join('drivers', 'drivers.id', '=', 'car_bookings.driver_id')
            ->where('car_bookings.user_id','=', session()->get('user.id'))
            ->select('car_bookings.*', 'cars.name', 'cars.number', 'drivers.name as driverName')
            ->orderBy('car_bookings.id', 'desc')
            ->get();
        return view('user.car.booking-history')->with('allData', $allData);
    }

    //Car Details
    public function CarDetails($id){
        $allData = Car::findOrFail($id);
        return view('user.car.car-details')->with('allData', $allData);
    }

    //Single Booking Data
    public function BookedCarData(Request $request){
        $id = $request->get('id');
        $data = CarBooking::findOrFail($id);
        return $data;
    }

    //Modify Booked Data For Modal
    public function ModifyBookedData(Request $request){
         $id = $request->get('id');
         $data = DB::table('car_bookings')
            ->join('drivers', 'drivers.id', '=', 'car_bookings.driver_id')
            ->join('cars', 'cars.id', '=', 'car_bookings.car_id')
            ->where('car_bookings.id', '=', $id)
            ->select('car_bookings.*', 'drivers.name', 'cars.number')
            ->first();

        return response()->json($data);

    }


}
