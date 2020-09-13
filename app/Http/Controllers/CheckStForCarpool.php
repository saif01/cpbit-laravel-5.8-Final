<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Driver;
use App\Car;
use DB;
use App\CarMaintenance;
use App\CarRequisition;
use App\DiverLeave;
use App\CarBooking;

class CheckStForCarpool extends Controller
{
    public $currentTime;

    //Current Time Auto run Function
    public function __construct()
    {
        $this->currentTime = date('Y-m-d H:i:s', time());
    }

    //Check Driver Leave
    public function CheckDriverLeave($carId, $driverId){
        $diverLeavetData = DiverLeave::where('car_id', '=', $carId)
            ->where('driver_id', '=', $driverId)
            ->where('status', '=', '1')
            ->where('end', '>', $this->currentTime)
            ->orderBy('id', 'desc')
            ->select('id', 'start', 'end')
            ->first();
        return $diverLeavetData;
    }

     //Check Car Maintance
    public function CheckCarMaintance($carId, $driverId)
    {
        $CarMaintanceData = CarMaintenance::where('car_id', '=', $carId)
            ->where('driver_id', '=', $driverId)
            ->where('status', '=', '1')
            ->where('end', '>', $this->currentTime)
            ->orderBy('id', 'desc')
            ->select('id', 'start', 'end')
            ->first();
        return $CarMaintanceData;
    }

      //Check Car Police Requisition
    public function CheckCarRequisition($carId, $driverId)
    {
        $CarReqData = CarRequisition::where('car_id', '=', $carId)
            ->where('driver_id', '=', $driverId)
            ->where('status', '=', '1')
            ->where('end', '>', $this->currentTime)
            ->orderBy('id', 'desc')
            ->select('id', 'start', 'end')
            ->first();
        return $CarReqData;
    }

    //Check Car Use Deadline
    public function CheckCarUseDeadline($carId){

        $CarDeadline = Car::where('id', '=', $carId)
            ->where('last_use', '!=', '' )
            ->first();

        if($CarDeadline){
            $currentDate= date('Y-m-d');
            $LastUseDate= $CarDeadline->last_use;
            //Current date grater
            if($currentDate > $LastUseDate ){
                return 1;
            }
        }

    }

    //Checking Another booking have or not
    public function CheckBookingHaveOrNot($carId, $start, $end){

        $bookingData = DB::table('car_bookings')
            ->where('car_id', '=', $carId)
            ->where('car_bookings.status', '=', '1')
            ->whereRaw("( `start` BETWEEN '$start' AND '$end' OR `end` BETWEEN '$start' AND '$end' OR '$start' BETWEEN `start` AND `end` OR '$end' BETWEEN `start` AND `end` )")
            ->count();
        return $bookingData;
    }

     //Check Driver Leave Or Not By Booking Time
     public function CkeckDriverLeaveByBookingTime($driverId, $start, $end){
        $data = DB::table('diver_leaves')
            ->where('driver_id', '=', $driverId)
            ->where('diver_leaves.status', '=', '1')
            ->whereRaw("( `start` BETWEEN '$start' AND '$end' OR `end` BETWEEN '$start' AND '$end' OR '$start' BETWEEN `start` AND `end` OR '$end' BETWEEN `start` AND `end` )")
            ->count();
        return $data;
    } 

      //Checking Car Maintance By Booking Time
    public function CheckCarMaintanceByBookingTime($carId, $start, $end)
    {
        $CarMaintanceData = CarMaintenance::where('car_id', '=', $carId)
            ->where('status', '=', '1')
            ->whereRaw("( `start` BETWEEN '$start' AND '$end' OR `end` BETWEEN '$start' AND '$end' OR '$start' BETWEEN `start` AND `end` OR '$end' BETWEEN `start` AND `end` )")
            ->count();
        return $CarMaintanceData;
    }

      //Checking Requisition By Booking Time
    public function CheckCarRequisitionByBookingTime($carId, $start, $end)
    {
        $CarReqData = CarRequisition::where('car_id', '=', $carId)
            ->where('status', '=', '1')
            ->whereRaw("( `start` BETWEEN '$start' AND '$end' OR `end` BETWEEN '$start' AND '$end' OR '$start' BETWEEN `start` AND `end` OR '$end' BETWEEN `start` AND `end` )")
            ->count();
        return $CarReqData;
    }



    //Checking Another booking have or not Modify
    public function ModifyCheckBookingHaveOrNot($id ,$carId, $start, $end)
    {

        $bookingData = DB::table('car_bookings')
            ->where('car_id', '=', $carId)
            ->where('car_bookings.status', '=', '1')
            ->where('car_bookings.id', '!=', $id)
            ->whereRaw("( `start` BETWEEN '$start' AND '$end' OR `end` BETWEEN '$start' AND '$end' OR '$start' BETWEEN `start` AND `end` OR '$end' BETWEEN `start` AND `end` )")
            ->count();
        return $bookingData;
    }






    //Checking Current Time booking
    public function CheckCurrentTimeBookingHaveOrNot($carId)
    {
        $bookingData = DB::table('car_bookings')
            ->where('car_id', '=', $carId)
            ->where('car_bookings.status', '=', '1')
            ->whereRaw("( '$this->currentTime' BETWEEN `start` AND `end` )")
            ->count();
        return $bookingData;
    }

    //Checking Current Time Driver Leave
    public function CheckCurrentTimeDriverLeave($carId)
    {
        $diverLeavetData = DiverLeave::where('car_id', '=', $carId)
            ->where('status', '=', '1')
            ->whereRaw("( '$this->currentTime' BETWEEN `start` AND `end` )")
            ->count();
        return $diverLeavetData;
    }

    //Checking Current Time Driver Leave
    public function CheckCurrentTimeCarMaintance($carId)
    {
        $CarMaintanceData = CarMaintenance::where('car_id', '=', $carId)
            ->where('status', '=', '1')
            ->whereRaw("( '$this->currentTime' BETWEEN `start` AND `end` )")
            ->count();
        return $CarMaintanceData;
    }

    //Checking Current Time Car Requisition
    public function CheckCurrentTimeCarRequisition($carId)
    {
        $CarReqData = CarRequisition::where('car_id', '=', $carId)
            ->where('status', '=', '1')
            ->whereRaw("( '$this->currentTime' BETWEEN `start` AND `end` )")
            ->count();
        return $CarReqData;
    }

    public function test(){
      // return $this->CheckBookingHaveOrNot('1', '2019-12-12 09:00:00', '2019-12-18 08:00:00');
        return $this->CheckCurrentTimeCarRequisition('1');
        //return $this->currentTime;
    }



}
