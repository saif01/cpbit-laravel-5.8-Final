<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Room;
use App\RoomBooking;
use Session;
use DB;
use App\User;
use Carbon\Carbon;

class UserRoomController extends Controller
{

    //index
    public function Index(){
        return view('user.room.index');
    }


    //Meeting Room List
    public function MeetingRoomList(){
        $allData = Room::where('status', '1')->get();
        // dd($allData);
        return view('user.room.meeting-room-list')->with('allData', $allData);
    }

    //Meeting Room Booking Page
    public function MeetingRoomBooking($id){
        $data = Room::find($id);
        $bookingData = DB::table('room_bookings')
            ->join('users', 'users.id', '=', 'room_bookings.user_id')
            ->join('rooms', 'rooms.id', '=', 'room_bookings.room_id')
            ->where('room_bookings.room_id', '=', $id)
            ->where('room_bookings.status', '=', '1')
            ->where('rooms.type', '=', 'Meeting')
            ->select('room_bookings.id', DB::raw("CONCAT(rooms.name,' || ',room_bookings.purpose,' || ',users.name,' || ',users.department) as title"), 'room_bookings.start', 'room_bookings.end', 'users.name as userName', 'users.department', 'room_bookings.purpose', 'rooms.name')
            ->get();

        // dd($bookingData);

        return view('user.room.meeting-room-booking')->with('data', $data)->with('bookingData', json_encode($bookingData));
    }

    //Check Meeting Room Booking HAve or Not
    public function CheckMeetingRoomBooking($id, $start, $end){

        $bookingData = DB::table('room_bookings')
            ->where('room_id', '=', $id)
            ->where('status', '=', '1')
            ->whereRaw("( `start` BETWEEN '$start' AND '$end' OR `end` BETWEEN '$start' AND '$end' OR '$start' BETWEEN `start` AND `end` OR '$end' BETWEEN `start` AND `end` )")
            ->count();
        return $bookingData;
    }



    //Check Meeting Room Booking HAve or Not Modify
    public function ModifyCheckMeetingRoomBooking($id, $roomId, $start, $end)
    {

        $bookingData = DB::table('room_bookings')
            ->where('id', '!=', $id)
            ->where('room_id', '=', $roomId)
            ->where('status', '=', '1')
            ->whereRaw("( `start` BETWEEN '$start' AND '$end' OR `end` BETWEEN '$start' AND '$end' OR '$start' BETWEEN `start` AND `end` OR '$end' BETWEEN `start` AND `end` )")
            ->count();
        return $bookingData;
    }

    //Meeting Room Booking Action
    public function MeetingRoomBookingAction(Request $request, $id, $roomName){

        $start = $request->start.' '.$request->startHour;
        $end = $request->start.' '.$request->endHour;
        $purpose = $request->purpose;

        $ts1    =   strtotime($start);
        $ts2    =   strtotime($end);
        $seconds    = abs($ts2 - $ts1); # difference will always be positive
        //$days = round($seconds/(60*60*24));
        $hours = ($seconds / (60 * 60));


        $userName = session()->get('user.name');
        $department = session()->get('user.department');

        $bookingDate = date("j-M-Y", strtotime($start));
        $startTime = date("g:i A", strtotime($start));
        $endTime = date("g:i A", strtotime($end));

        $department = str_replace('&', 'and', $department);
        $purposeLine = str_replace('&', 'and', $purpose);


        //*************For Sending Line Group Message*******************//
        $message = "Booked Status,%0A Booked By: $userName,%0A Department: $department,%0A Purpose: $purposeLine,%0A Room: $roomName,%0A Date: $bookingDate,%0A Interval: $startTime. - $endTime.,%0A Booking Hours: $hours. ";


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
        //Check Another booking have or not
        elseif( $this->CheckMeetingRoomBooking($id, $start, $end) ){
            $notification = array(
                'big-title' => 'Booked By Another !!',
                'big-alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }else{

            $data = new RoomBooking();
            $data->room_id =  $id;
            $data->user_id =  session()->get('user.id');
            $data->start =  $start;
            $data->end = $end;
            $data->hours = $hours;
            $data->purpose = $purpose;
            $data->status = 1;


            //Send Line Message
            $this->lineMsg($message);
            $successData = $data->save();

       }

        if ($successData) {
            $notification = array(
                'big-title' => 'Successfully, Booking Completed',
                'big-alert-type' => 'success'
            );
            return Redirect()->route('user.meeting.room.list')->with($notification);
        } else {
            $notification = array(
                'big-title' => 'Error !! Somthing Going Wrong',
                'big-alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
    }

    //User Profile Page
    public function UserProfile(){
        $allData = User::findOrFail(session()->get('user.id'));
        return view('user.room.user-profile')->with('allData', $allData);
    }

    //Car Booking History Page
    public function UserBookingHistory(){
        $allData = DB::table('room_bookings')
            ->join('rooms', 'rooms.id', '=', 'room_bookings.room_id')
            ->where('room_bookings.user_id', '=', session()->get('user.id'))
            ->select('room_bookings.*', 'rooms.name', 'rooms.image')
            ->orderBy('room_bookings.id', 'desc')
            ->get();

        //     echo "<pre>";
        // print_r($allData);

        return view('user.room.booking-history')->with('allData', $allData);
    }

    //User Booked Room Page
    public function UserBookedRoom(){
        $currentTime = date('Y-m-d H:i:s', time());
        $allData = DB::table('room_bookings')
            ->join('rooms', 'rooms.id', '=', 'room_bookings.room_id')
            ->where('room_bookings.status', '=', '1')
            ->where('room_bookings.user_id', '=', session()->get('user.id'))
            ->where('room_bookings.end', '>=', $currentTime)
            ->orderBy('room_bookings.start', 'asc')
            ->select('room_bookings.*', 'rooms.id as roomId', 'rooms.name', 'rooms.capacity', 'rooms.image')
            ->get();

            // echo "<pre>";
            // print_r($allData);

        return view('user.room.user-booked-room')->with('allData', $allData);
    }

    //Cancel booked Room
    public function UserCancelRoom($id){
        $data = RoomBooking::findOrFail($id);

        $roomId = $data->room_id;
        $data2 = Room::where('id', $roomId)->select('name')->first();
        $roomName = $data2->name;

        $start = $data->start;
        $end = $data->end;
        $purpose = $data->purpose;

        $ts1    =   strtotime($start);
        $ts2    =   strtotime($end);
        $seconds    = abs($ts2 - $ts1); # difference will always be positive
        //$days = round($seconds/(60*60*24));
        $hours = ($seconds / (60 * 60));


        $userName = session()->get('user.name');
        $department = session()->get('user.department');

        $bookingDate = date("j-M-Y", strtotime($start));
        $startTime = date("g:i A", strtotime($start));
        $endTime = date("g:i A", strtotime($end));

        $department = str_replace('&', 'and', $department);
        $purposeLine = str_replace('&', 'and', $purpose);


        //*************For Sending Line Group Message*******************//
        $message = "Cancel Status,%0A Canceled By: $userName,%0A Department: $department,%0A Purpose: $purposeLine,%0A Room: $roomName,%0A Date: $bookingDate,%0A Interval: $startTime. - $endTime.,%0A Booking Hours: $hours. ";



        $data->status = 0;
        $successData = $data->save();
        //Send Line Message
        $this->lineMsg($message);


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
    public function UserRoomBookingModifyAction(Request $request){
        $id = $request->id;
        $start =  $request->start;
        $end =  $request->end . ' ' . $request->endHour;
        $data = RoomBooking::findOrFail($id);

        $roomId = $data->room_id;

        $ts1    =   strtotime($start);
        $ts2    =   strtotime($end);
        $seconds    = abs($ts2 - $ts1); # difference will always be positive
        //$days = round($seconds/(60*60*24));
        $hours = ($seconds / (60 * 60));

        $data2 = Room::where('id', $roomId)->select('name')->first();
        $roomName = $data2->name;

        $purpose = $data->purpose;

        $ts1    =   strtotime($start);
        $ts2    =   strtotime($end);
        $seconds    = abs($ts2 - $ts1); # difference will always be positive
        //$days = round($seconds/(60*60*24));
        $hours = ($seconds / (60 * 60));


        $userName = session()->get('user.name');
        $department = session()->get('user.department');

        $bookingDate = date("j-M-Y", strtotime($start));
        $startTime = date("g:i A", strtotime($start));
        $endTime = date("g:i A", strtotime($end));

        $department = str_replace('&', 'and', $department);
        $purposeLine = str_replace('&', 'and', $purpose);


        //*************For Sending Line Group Message*******************//
        $message = "Modify Status, %0A Modify By: $userName,%0A Department: $department,%0A Purpose: $purposeLine,%0A Room: $roomName,%0A Date: $bookingDate,%0A Interval: $startTime. - $endTime.,%0A Booking Hours: $hours. ";


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
        //Check Another booking have or not
        elseif ($this->ModifyCheckMeetingRoomBooking($id, $roomId, $start, $end)) {
            $notification = array(
                'big-title' => 'Booked By Another !!',
                'big-alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        } else{

            $data->hours =  $hours;
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

    //Canceled Room List
    public function UserCanceledBookingRoom(){
        $allData = DB::table('room_bookings')
            ->join('rooms', 'rooms.id', '=', 'room_bookings.room_id')
            ->where('room_bookings.status', '=', '0')
            ->where('room_bookings.user_id', '=', session()->get('user.id'))
            ->orderBy('room_bookings.start', 'asc')
            ->select('room_bookings.*', 'rooms.id as roomId', 'rooms.name', 'rooms.capacity', 'rooms.image')
            ->get(10);
        return view('user.room.user-canceled-room')->with('allData', $allData);
    }

    //Room Details
    public function RoomDetails($id){
        $allData = Room::findOrFail($id);
        return view('user.room.room-details')->with('allData', $allData);
    }


    //Today Booked Message Send
    function DailyBookedLineMsg(){

        //$today = '2020-11-18';
        $today = Carbon::today();

        $allData = DB::table('room_bookings')
                ->whereDate('room_bookings.start', '=', $today)
                ->where('room_bookings.status', '=', '1')
                ->join('users', 'users.id', 'room_bookings.user_id')
                ->join('rooms', 'rooms.id', 'room_bookings.room_id')
                ->select('room_bookings.start', 'room_bookings.end', 'room_bookings.purpose', 'room_bookings.hours', 'users.name','users.department', 'rooms.name as roomName')
                ->get();

       // dd($allData);

        $count = 1;

        foreach( $allData as $data ){

            $today = date("j-M-Y", strtotime( Carbon::today() ) );

            $bookingDate = date("j-M-Y", strtotime($data->start));
            
            $startTime = date("g:i A", strtotime($data->start));
            $endTime = date("g:i A", strtotime($data->end));

            $userName = $data->name;

            $purposeLine = str_replace('&', 'and', $data->purpose);

            $department = $data->department;
            $department=str_replace('&', 'and', $department);
            $roomName = $data->roomName;
            $hours = $data->hours;

            
            //*************For Sending Line Group Message*******************//
            $message = "Booked #: $count, %0A Today Date ($today), %0A Booked By: $userName,%0A Department: $department,%0A Purpose: $purposeLine,%0A Room: $roomName,%0A Date: $bookingDate,%0A Interval: $startTime. - $endTime.,%0A Booking Hours: $hours hours. ";
        
           
            //Send Line Message
            $this->lineMsg($message);

            $count++;
            
        }





    }

     //Line Message send
    public function lineMsg($message)
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

        //  //Test Group
        // $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer yN6ECBnK1DWzsxVRm2ndQykUe6EIgWEf1VDKZvtZoW9',);  // ��ѧ����� Bearer ��� line authen code �
        
        //Room Booking Group
        $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer XhLvsOd9Blj88X4jE8SoecvCxiAlh4jlsaYMBv2IUol',);  // ��ѧ����� Bearer ��� line authen code �

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
