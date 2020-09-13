<?php

namespace App\Http\Controllers\Network;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use  App\Models\Network\NetworkSubIp;
use  App\Models\Network\NetworkGroup;

class NetworkSubIpController extends Controller
{
    public function All()
    {
        $allData = NetworkSubIp::orderBy('id', 'desc')->get();
        $groupData = NetworkGroup::orderBy('name')->select('name')->get();
        //print_r($allData);
        return view('admin.network.sub-ip')->with('allData', $allData)->with('groupData', $groupData);
    }

    //Insert Data
    public function Insert(Request $request)
    {

        $data = new NetworkSubIp();

        // Another Way to insert records
        $successData = $data->create($request->all());

        // $data->dept_name = request('dept_name');
        // $successData = $data->save();

        if ($successData) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'Data Inserted',
                'alert-type' => 'success'
            );
            return Redirect()->route('sub.ip.all')->with($notification);
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
        $data = NetworkSubIp::find($id);
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
        $data = NetworkSubIp::find($id);

        // $data->dept_name = request('dept_name');
        // $successData = $data->save();
        //echo $data;

        // Another Way to update records
        $successData = $data->update($request->all());

        if ($successData) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'Data updated',
                'alert-type' => 'info'
            );
            return Redirect()->route('sub.ip.all')->with($notification);
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
