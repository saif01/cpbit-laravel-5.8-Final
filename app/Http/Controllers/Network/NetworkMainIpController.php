<?php

namespace App\Http\Controllers\Network;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Network\NetworkMainIp;

class NetworkMainIpController extends Controller
{
    Public function All(){

        $allData = NetworkMainIp::orderBy('id','desc')->get();

        //dd($alldata);


        return view('admin.network.main-ip')->with('allData', $allData);

    }


      //Insert Data
      public function Insert(Request $request)
      {

        $pingType = $request->pingType;


        if( empty($pingType) ){
            $start =$request->start;
            $end =$request->end;
        }
        elseif($pingType == 'OfficeTime'){
            $start = '09:00:00';
            $end ='18:00:00';
        }
        elseif($pingType == 'fullDay'){
            $start = '06:00:00';
            $end ='18:00:00';
        }
        elseif($pingType == 'fullNight'){
            $start = '18:00:00';
            $end ='06:00:00';
        }
        elseif($pingType == 'dayNight'){
            $start = '01:01:01';
            $end ='23:59:59';
        }



          $data = new NetworkMainIp();


          $data->ip =$request->ip;
          $data->name =$request->name;
          $data->start =$start;
          $data->end =$end;
         // dd($data);

          $successData = $data->save();

          if ($successData) {
              $notification = array(
                  'title' => 'Successfully',
                  'messege' => 'Data Inserted',
                  'alert-type' => 'success'
              );
              return Redirect()->route('main.ip.all')->with($notification);
          } else {
              $notification = array(
                  'title' => 'Error',
                  'messege' => 'Somthing Going Wrong',
                  'alert-type' => 'error'
              );
              return Redirect()->back()->with($notification);
          }
      }


      //Delete data
      public function Delete($id)
      {
          $data = NetworkMainIp::find($id);
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



      public function Update(Request $request)
      {
          $id = request('id');
          $data = NetworkMainIp::find($id);

          $pingType = $request->pingType;


        if( empty($pingType) ){
            $start =$request->start;
            $end =$request->end;
        }
        elseif($pingType == 'OfficeTime'){
            $start = '09:00:00';
            $end ='18:00:00';
        }
        elseif($pingType == 'fullDay'){
            $start = '06:00:00';
            $end ='18:00:00';
        }
        elseif($pingType == 'fullNight'){
            $start = '18:00:00';
            $end ='06:00:00';
        }
        elseif($pingType == 'dayNight'){
            $start = '01:01:01';
            $end ='23:59:59';
        }


          $data->ip =$request->ip;
          $data->name =$request->name;
          $data->start =$start;
          $data->end =$end;
         // dd($data);

          $successData = $data->save();

          // Another Way to update records
         // $successData = $data->update($request->all());

          if ($successData) {
              $notification = array(
                  'title' => 'Successfully',
                  'messege' => 'Data updated',
                  'alert-type' => 'info'
              );
              return Redirect()->route('main.ip.all')->with($notification);
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
