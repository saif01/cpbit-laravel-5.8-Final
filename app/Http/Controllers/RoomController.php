<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;
use App\RoomBooking;
use DB;
use App\User;

class RoomController extends Controller
{
    public function Index(){

        $chartData = DB::table('room_bookings')
            ->leftjoin('users', 'users.id', '=', 'room_bookings.user_id')
            ->select('users.department',  DB::raw('count(*) as total'))
            ->groupBy('users.department')
            ->get();

        $TotalRoomUser = User::where('room', '1')->count();
        $TotalBooking = RoomBooking::where('status', '1')->count();
        $TotalCanceled = RoomBooking::where('status', '0')->count();

        return view('admin.room.index')
            ->with('TotalBooking', $TotalBooking)
            ->with('chartData', $chartData)
            ->with('TotalCanceled', $TotalCanceled)
            ->with('TotalRoomUser', $TotalRoomUser);
    }

    //Room All
    public function All(){
        $allData = Room::orderBy('id', 'desc')->get();
        return view('admin.room.all')->with('allData', $allData);
    }

    //Room Add
    public function Add(){
        return view('admin.room.add');
    }

    //Insert
    public function Insert(Request $request){
        $validateData = $request->validate([
            'image' => 'required | max:500 |mimes:jpg,jpeg,bmp,png',
            'image2' => 'required | max:500 |mimes:jpg,jpeg,bmp,png',
            'image3' => 'required | max:500 |mimes:jpg,jpeg,bmp,png',

        ]);

        $data = new Room();

        $image = $request->file('image');
        if ($image) {
            $image_name = str_random(5);
            $ext = strtolower($image->getClientOriginalExtension());
            $image_full_name = $image_name . '.' . $ext;
            $upload_path = 'public/images/room/';
            $image_url = $upload_path . $image_full_name;
            $successImg = $image->move($upload_path, $image_full_name);
            $data->image = $image_url;
        }

        $image2 = $request->file('image2');
        if ($image2) {
            $image2_name = str_random(5);
            $ext = strtolower($image2->getClientOriginalExtension());
            $image2_full_name = $image2_name . '.' . $ext;
            $upload_path = 'public/images/room/';
            $image2_url = $upload_path . $image2_full_name;
            $successImg2 = $image2->move($upload_path, $image2_full_name);
            $data->image2 = $image2_url;
        }
        $image3 = $request->file('image3');
        if ($image3) {
            $image3_name = str_random(5);
            $ext = strtolower($image3->getClientOriginalExtension());
            $image3_full_name = $image3_name . '.' . $ext;
            $upload_path = 'public/images/room/';
            $image3_url = $upload_path . $image3_full_name;
            $successImg3 = $image3->move($upload_path, $image3_full_name);
            $data->image3 = $image3_url;
        }
        if ($successImg && $successImg2 && $successImg3) {
            $data->name = request('name');
            $data->capacity = request('capacity');
            $data->type = request('type');
            $data->status = request('status');
            $data->projector = request('projector');
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
            return Redirect()->route('room.all')->with($notification);
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
        $data = Room::findOrFail($id);
        return view('admin.room.edit')->with('data', $data);
    }

    //Update
    public function Update(Request $request, $id){
        $validateData = $request->validate([
            'image' => 'max:500 |mimes:jpg,jpeg,bmp,png',
            'image2' => 'max:500 |mimes:jpg,jpeg,bmp,png',
            'image3' => 'max:500 |mimes:jpg,jpeg,bmp,png',
        ]);

        $data = Room::findOrFail($id);

        $image = $request->file('image');
        if ($image) {
            $image_path = $data->image;
            if ($image_path) {
                @unlink($image_path);
            }
            $image_name = str_random(5);
            $ext = strtolower($image->getClientOriginalExtension());
            $image_full_name = $image_name . '.' . $ext;
            $upload_path = 'public/images/room/';
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
            $upload_path = 'public/images/room/';
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
            $upload_path = 'public/images/room/';
            $image3_url = $upload_path . $image3_full_name;
            $successImg3 = $image3->move($upload_path, $image3_full_name);
            $data->image3 = $image3_url;
        }

        $data->capacity = request('capacity');
        $data->type = request('type');
        $data->status = request('status');
        $data->projector = request('projector');
        $data->remarks = request('remarks');
        $successData = $data->save();
        //echo $data;

        if ($successData) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'Data Updated',
                'alert-type' => 'success'
            );
            return Redirect()->route('room.all')->with($notification);
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

        $data = Room::find($id);
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

    //Booking Reports
    public function ReportsAll(){
        $roomData = Room::where('status', '1')->orderBy('name')->get();
        $allData = DB::table('room_bookings')
            ->join('users', 'users.id', '=', 'room_bookings.user_id')
            ->join('rooms', 'rooms.id', '=', 'room_bookings.room_id')
            ->select('room_bookings.*', 'rooms.name','users.name as userName', 'users.department')
            ->orderBy('room_bookings.id', 'desc')
            ->get();
        return view('admin.room.reports-all')->with('roomData', $roomData)->with('allData', $allData);
    }

    //Room Details
    public function Details(Request $request)
    {
        $id = $request->get('id');
        $data = Room::findOrFail($id);
        return $data;
    }

    //Single Car Carpool Report
    public function ReportBySearch(Request $request)
    {

        $start = $request->start . " 00:00:00";
        $end = $request->end . " 23:59:59";
        $room_id = $request->room_id;
        //make Object
        $searchData = (object) array('start' => $start, 'end' => $end);


        if ($room_id == 'Allroom') {
            $allData = DB::table('room_bookings')
                ->join('users', 'users.id', '=', 'room_bookings.user_id')
                ->join('rooms', 'rooms.id', '=', 'room_bookings.room_id')
                ->where('room_bookings.start', '>=', $start)
                ->where('room_bookings.end', '<=', $end)
                ->select('room_bookings.*', 'rooms.name', 'users.name as userName', 'users.department')
                ->orderBy('room_bookings.id', 'desc')
                ->get();
        } else {
            $allData = DB::table('room_bookings')
                ->join('users', 'users.id', '=', 'room_bookings.user_id')
                ->join('rooms', 'rooms.id', '=', 'room_bookings.room_id')
                ->where('room_bookings.room_id', '=', $room_id)
                ->where('room_bookings.start', '>=', $start)
                ->where('room_bookings.end', '<=', $end)
                ->select('room_bookings.*', 'rooms.name', 'users.name as userName', 'users.department')
                ->orderBy('room_bookings.id', 'desc')
                ->get();

        }

        $roomData = Room::where('status', '1')->orderBy('name')->get();
        // dd($allData);
        return view('admin.room.reports-all')
            ->with('roomData', $roomData)
            ->with('searchData', $searchData)
            ->with('allData', $allData);
    }

    //All Carpool Calendar Report
    public function ReportsCalendar()
    {
        $bookingData = DB::table('room_bookings')
            ->join('users', 'users.id', '=', 'room_bookings.user_id')
            ->join('rooms', 'rooms.id', '=', 'room_bookings.room_id')
            ->where('room_bookings.status', '=', '1')
            ->select('room_bookings.id', DB::raw("CONCAT(rooms.name,' || ',users.name,' || ',users.department) as title"), 'room_bookings.start', 'room_bookings.end', 'users.name as userName', 'users.department', 'room_bookings.purpose', 'room_bookings.start', 'room_bookings.end', 'room_bookings.hours', 'rooms.name as roomName')
            ->get();

        $roomData = Room::where('status', '1')->orderBy('name')->get();

        return view('admin.room.report-calendar')
        ->with('bookingData', json_encode($bookingData))
        ->with('roomData', $roomData);
    }

    //Single Car Carpool Calendar Report
    public function ReportsCalendarForSearch(Request $request)
    {
        $Id = $request->room_id;

        $bookingData = DB::table('room_bookings')
            ->join('users', 'users.id', '=', 'room_bookings.user_id')
            ->join('rooms', 'rooms.id', '=', 'room_bookings.room_id')
            ->where('room_bookings.room_id', '=', $Id)
            ->where('room_bookings.status', '=', '1')
            ->select('room_bookings.id', DB::raw("CONCAT(rooms.name,' || ',users.name,' || ',users.department) as title"), 'room_bookings.start', 'room_bookings.end', 'users.name as userName', 'users.department', 'room_bookings.purpose', 'room_bookings.start', 'room_bookings.end', 'room_bookings.hours', 'rooms.name as roomName')
            ->get();

        $roomData = Room::where('status', '1')->orderBy('name')->get();


        $searchData = Room::find($Id);

        // dd($searchData);

        return view('admin.room.report-calendar')
            ->with('bookingData', json_encode($bookingData))
            ->with('searchData', $searchData)
            ->with('roomData', $roomData);
    }

}
