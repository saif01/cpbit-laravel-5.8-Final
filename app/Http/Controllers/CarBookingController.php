<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\CarBooking;
use Session;
use DB;
use App\Http\Controllers\CheckStForCarpool;
use App\Http\Controllers\userController\UserCarPoolController;

use Carbon\Carbon;

class CarBookingController extends Controller
{
    //Regular car Booking Action
    public function RegularCarBookingAction(Request $request, $carId, $number, $driverId, $driverName, $contact)
    {

        $start = request('start') . ' ' . request('startHour');
        $end = request('end') . ' ' . request('endHour');
        $purpose = request('purpose');
        $destination = request('destination');

        $data = new CarBooking();
        $data->car_id = $carId;
        $data->user_id = session()->get('user.id');
        $data->driver_id = $driverId;
        $data->start = $start;
        $data->end = $end;
        $data->destination = $destination;
        $data->purpose = $purpose;
        $data->status = 1;

        //For Line Msg Sending Variable
        $userName = session()->get('user.name');
        $department = session()->get('user.department');
        $department = str_replace('&', 'and', $department);
        $startLine = date("j-M-Y, g:i A", strtotime($start));
        $endLine = date("j-M-Y, g:i A", strtotime($end));
        $purposeLine = str_replace('&', 'and', $purpose);
        $destinationLine = str_replace('&', 'and', $destination);

        //Send Line Message
        $message = "Booked Status,%0A Booked By: $userName,%0A Department: $department,%0A Destination: $destinationLine,%0A Purpose: $purposeLine,%0A Driver: $driverName ($contact),%0A Car: $number,%0A Start: $startLine,%0A End: $endLine.";


        //Checking Section
        $check = new CheckStForCarpool();
        //Count Not Commented
        $Object = new UserCarPoolController();
        $notComment = $Object->CommentCount();

        //Check End & Start Time Equal or not
        if($start ==  $end) {
            $notification = array(
                'big-title' => 'You Cannot Use Same Time !!',
                'big-alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
        //Check Start Time Not Grater Than End time
        elseif($start >  $end) {
            $notification = array(
                'big-title' => 'Start Time Greater Than End Time !!',
                'big-alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
        //Check Count Not Commented
        elseif ($notComment >=  2) {
            $notification = array(
                'big-title' => 'Booked Car Not Commented !!',
                'big-alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }

        //Check Car Use Deadline
        elseif ( $check->CheckCarUseDeadline($carId) ) {
            $notification = array(
                'big-title' => 'Cross Used Deadline !!',
                'big-alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
        //Check Driver Leave
        elseif ($check->CkeckDriverLeaveByBookingTime($driverId, $start, $end)) {
            $notification = array(
                'big-title' => 'Driver at leave !!',
                'big-alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
        // //Check Car Maintance
        // elseif ($check->CheckCarMaintance($carId, $driverId)) {
        //     $notification = array(
        //         'big-title' => 'Car at Maintance !!',
        //         'big-alert-type' => 'error'
        //     );
        //     return Redirect()->back()->with($notification);
        // }
        // //Check Police Requisition
        // elseif ($check->CheckCarRequisition($carId, $driverId)) {
        //     $notification = array(
        //         'big-title' => 'Car at Police Requisition !!',
        //         'big-alert-type' => 'error'
        //     );
        //     return Redirect()->back()->with($notification);
        // }

         //Check Car Maintance
        elseif ($check->CheckCarMaintanceByBookingTime($carId, $start, $end)) {
            $notification = array(
                'big-title' => 'Car at Maintance !!',
                'big-alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
        //Check Police Requisition
        elseif ($check->CheckCarRequisitionByBookingTime($carId, $start, $end)) {
            $notification = array(
                'big-title' => 'Car at Police Requisition !!',
                'big-alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }

        //Check Another booking have or not
        elseif ($check->CheckBookingHaveOrNot($carId, $start, $end)) {
            $notification = array(
                'big-title' => 'Booked By Another !!',
                'big-alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
        //If not Any Error
        else{
            //Save Data
            $successData = $data->save();
            //Send Line Message
            $this->lineMsg($message);
        }


        if ($successData) {
            $notification = array(
                'big-title' => 'Successfully, Booking Completed',
                'big-alert-type' => 'success'
            );
            return Redirect()->route('regular.car.list')->with($notification);
        } else {
            $notification = array(
                'big-title' => 'Error !! Somthing Going Wrong',
                'big-alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
    }


    //Temporary car Booking Action
    public function TemporaryCarBookingAction(Request $request, $carId, $number, $driverId, $driverName, $contact)
    {

        $start = request('start') . ' ' . request('startHour');
        $end = request('start') . ' ' . request('endHour');
        $purpose = request('purpose');
        $destination = request('destination');

        $data = new CarBooking();
        $data->car_id = $carId;
        $data->user_id = session()->get('user.id');
        $data->driver_id = $driverId;
        $data->start = $start;
        $data->end = $end;
        $data->destination = $destination;
        $data->purpose = $purpose;
        $data->status = 1;

        //For Line Msg Sending Variable
        $userName = session()->get('user.name');
        $department = session()->get('user.department');
        $department = str_replace('&', 'and', $department);
        $startLine = date("j-M-Y, g:i A", strtotime($start));
        $endLine = date("j-M-Y, g:i A", strtotime($end));
        $purposeLine = str_replace('&', 'and', $purpose);
        $destinationLine = str_replace('&', 'and', $destination);

        //Send Line Message
        $message = "Booked Status,%0A Booked By: $userName,%0A Department: $department,%0A Destination: $destinationLine,%0A Purpose: $purposeLine,%0A Driver: $driverName ($contact),%0A Car: $number,%0A Start: $startLine,%0A End: $endLine.";


        //Checking Section
        $check = new CheckStForCarpool();
        //Count Not Commented
        $Object = new UserCarPoolController();
        $notComment = $Object->CommentCount();

        //Check End & Start Time Equal or not
        if ($start ==  $end) {
            $notification = array(
                'big-title' => 'You Cannot Use Same Time !!',
                'big-alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
        //Check Start Time Not Grater Than End time
        elseif ($start >  $end) {
            $notification = array(
                'big-title' => 'Start Time Greater Than End Time !!',
                'big-alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
        //Check Count Not Commented
        elseif ($notComment >=  2) {
            $notification = array(
                'big-title' => 'Booked Car Not Commented !!',
                'big-alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
        //Check Car Use Deadline
        elseif ($check->CheckCarUseDeadline($carId)) {
            $notification = array(
                'big-title' => 'Cross Used Deadline !!',
                'big-alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
        //Check Driver Leave
        elseif ($check->CkeckDriverLeaveByBookingTime($driverId, $start, $end)) {
            $notification = array(
                'big-title' => 'Driver at leave !!',
                'big-alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
        //Check Car Maintance
        elseif ($check->CheckCarMaintanceByBookingTime($carId, $start, $end)) {
            $notification = array(
                'big-title' => 'Car at Maintance !!',
                'big-alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
        //Check Police Requisition
        elseif ($check->CheckCarRequisitionByBookingTime($carId, $start, $end)) {
            $notification = array(
                'big-title' => 'Car at Police Requisition !!',
                'big-alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }

        //Check Another booking have or not
        elseif ($check->CheckBookingHaveOrNot($carId, $start, $end)) {
            $notification = array(
                'big-title' => 'Booked By Another !!',
                'big-alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
        //If not Any Error
        else {
            //Save Data
            $successData = $data->save();
            //Send Line Message
            $this->lineMsg($message);
        }


        if ($successData) {
            $notification = array(
                'big-title' => 'Successfully, Booking Completed',
                'big-alert-type' => 'success'
            );
            return Redirect()->route('temporary.car.list')->with($notification);
        } else {
            $notification = array(
                'big-title' => 'Error !! Somthing Going Wrong',
                'big-alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
    }


    //Cancel booked car
    public function UserCancelCar($id)
    {
        $data = CarBooking::findOrFail($id);

        $start = $data->start;
        $end = $data->end;
        $purpose = $data->purpose;
        $destination = $data->destination;

        $carDriver = DB::table('car_bookings')
            ->join('cars', 'cars.id', '=', 'car_bookings.car_id')
            ->join('drivers', 'drivers.id', '=', 'car_bookings.driver_id')
            ->where('car_bookings.id', '=', $id)
            ->select('drivers.name', 'drivers.contact', 'cars.number')
            ->first();

        $driverName = $carDriver->name;
        $number = $carDriver->number;
        $contact = $carDriver->contact;


        //For Line Msg Sending Variable
        $userName = session()->get('user.name');
        $department = session()->get('user.department');
        $department = str_replace('&', 'and', $department);
        $startLine = date("j-M-Y, g:i A", strtotime($start));
        $endLine = date("j-M-Y, g:i A", strtotime($end));
        $purposeLine = str_replace('&', 'and', $purpose);
        $destinationLine = str_replace('&', 'and', $destination);

        //Send Line Message
        $message = "Canceled Status, %0A Canceled By: $userName,%0A Department: $department,%0A Destination: $destinationLine,%0A Purpose: $purposeLine,%0A Driver: $driverName ($contact),%0A Car: $number,%0A Start: $startLine,%0A End: $endLine.";
        //Send Line Message
        $this->lineMsg($message);

        $data->status = 0;
        $successData = $data->save();

        if ($successData) {
            $notification = array(
                'big-title' => 'Successfully, Booking Canceled',
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


    //Booking Modify
    public function UserCarBookingModifyAction(Request $request){
        $id = $request->id;
        $start =  $request->start;
        $end =  $request->end . ' ' . $request->endHour;
        $data = CarBooking::findOrFail($id);
        //Checking Section
        $check = new CheckStForCarpool();


        $carId = $data->car_id;
        $driverId = $data->driver_id;
        // $start = $data->start;
        // $end = $data->end;
        $purpose = $data->purpose;
        $destination = $data->destination;

        $carDriver = DB::table('car_bookings')
            ->join('cars', 'cars.id', '=', 'car_bookings.car_id')
            ->join('drivers', 'drivers.id', '=', 'car_bookings.driver_id')
            ->where('car_bookings.id', '=', $id)
            ->select('drivers.name', 'drivers.contact', 'cars.number')
            ->first();

        $driverName = $carDriver->name;
        $number = $carDriver->number;
        $contact = $carDriver->contact;


        //For Line Msg Sending Variable
        $userName = session()->get('user.name');
        $department = session()->get('user.department');
        $department = str_replace('&', 'and', $department);
        $startLine = date("j-M-Y, g:i A", strtotime($start));
        $endLine = date("j-M-Y, g:i A", strtotime($end));
        $purposeLine = str_replace('&', 'and', $purpose);
        $destinationLine = str_replace('&', 'and', $destination);

        //Send Line Message
        $message = "Modify Status, %0A Modify By: $userName,%0A Department: $department,%0A Destination: $destinationLine,%0A Purpose: $purposeLine,%0A Driver: $driverName ($contact),%0A Car: $number,%0A Start: $startLine,%0A End: $endLine.";



        if( $start >= $end ){
            $notification = array(
                'big-title' => 'Start Time Greater Than End Time !!',
                'big-alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
        //Check Car Use Deadline
        elseif ($check->CheckCarUseDeadline($carId)) {
            $notification = array(
                'big-title' => 'Cross Used Deadline !!',
                'big-alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
        //Check Driver Leave
        elseif ( $check->CkeckDriverLeaveByBookingTime($driverId, $start, $end) ) {
            $notification = array(
                'big-title' => 'Driver at leave !!',
                'big-alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
        // //Check Car Maintance
        // elseif ($check->CheckCarMaintance($carId, $driverId)) {
        //     $notification = array(
        //         'big-title' => 'Car at Maintance !!',
        //         'big-alert-type' => 'error'
        //     );
        //     return Redirect()->back()->with($notification);
        // }
        // //Check Police Requisition
        // elseif ($check->CheckCarRequisition($carId, $driverId)) {
        //     $notification = array(
        //         'big-title' => 'Car at Police Requisition !!',
        //         'big-alert-type' => 'error'
        //     );
        //     return Redirect()->back()->with($notification);
        // }

         //Check Car Maintance
        elseif ($check->CheckCarMaintanceByBookingTime($carId, $start, $end)) {
            $notification = array(
                'big-title' => 'Car at Maintance !!',
                'big-alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
        //Check Police Requisition
        elseif ($check->CheckCarRequisitionByBookingTime($carId, $start, $end)) {
            $notification = array(
                'big-title' => 'Car at Police Requisition !!',
                'big-alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }

        //Check Another booking have or not
        elseif ($check->ModifyCheckBookingHaveOrNot($id, $carId, $start, $end)) {
            $notification = array(
                'big-title' => 'Booked By Another !!',
                'big-alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
        else
        {
            $data->end =  $end;
            $successData = $data->save();
            //Send Line Message
            $this->lineMsg($message);

            if ($successData) {
                $notification = array(
                    'big-title' => 'Successfully, End Time Updated',
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
    }

    //Daily Car Booked Line Message
    function DailyBookedLineMsg(){

        //$today = '2020-01-11';
        $today = Carbon::today();

        $allData = DB::table('car_bookings')
                ->whereDate('car_bookings.start', '=', $today)
                ->where('car_bookings.status', '=', '1')
                ->join('users', 'users.id', 'car_bookings.user_id')
                ->join('cars', 'cars.id', 'car_bookings.car_id')
                ->join('drivers', 'drivers.id', 'car_bookings.driver_id')
                ->select('car_bookings.start', 'car_bookings.end', 'car_bookings.destination', 'car_bookings.purpose', 'users.name','users.department', 'cars.number', 'drivers.name as driverName', 'drivers.contact')
                ->get();

       // dd($allData);

        $count = 1;

        foreach( $allData as $data ){

            $today= date("j-M-Y", strtotime( Carbon::today() ) );

            $startLine= date("j-M-Y, g:i A", strtotime($data->start));
            $endLine= date("j-M-Y, g:i A", strtotime($data->end));

            $destination = $data->destination;
            $destinationLine = str_replace('&', 'and', $destination);

            $purpose = $data->purpose;
            $userName = $data->name;

            $purposeLine = str_replace('&', 'and', $purpose);
            $department = $data->department;

            $department=str_replace('&', 'and', $department);
            $number = $data->number;
            $driverName = $data->driverName;
            $contact = $data->contact;

            //Send Line Message
            $message = "Booked #: $count, %0A Today Date ($today), %0A Booked By: $userName,%0A Department: $department,%0A Destination: $destinationLine,%0A Purpose: $purposeLine,%0A Driver: $driverName ($contact),%0A Car: $number,%0A Start: $startLine,%0A End: $endLine.";

            //Send Line Message
            $this->lineMsg($message);

            $count++;

        }





    }

    //Line Message send
    function lineMsg($message)
    {
        $chOne = curl_init();
        curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
        // SSL USE
        curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
        //POST
        curl_setopt($chOne, CURLOPT_POST, 1);
        // Message
        curl_setopt($chOne, CURLOPT_POSTFIELDS, $message);
        //��ҵ�ͧ�������ػ ������ 2 parameter imageThumbnail ���imageFullsize
        curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=$message");
        // follow redirects
        curl_setopt($chOne, CURLOPT_FOLLOWLOCATION, 1);

        // //Test Group
        // $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.config('values.line_test_key'),);  // ��ѧ����� Bearer ��� line authen code �

        //Carpool Group
        $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.config('values.line_carpool_key'),);  // ��ѧ����� Bearer ��� line authen code �

        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
        //RETURN
        curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($chOne);

        //Check error
        if (curl_error($chOne)) {
            echo 'error:' . curl_error($chOne);
        } else {
            $result_ = json_decode($result, true);

            //************Status Print *************//

            //echo "status : ".$result_['status']; echo "message : ". $result_['message'];
            //echo "SMS send Successfully";
        }
        //Close connect
        curl_close($chOne);
    }


}
