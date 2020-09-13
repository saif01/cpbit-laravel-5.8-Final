<?php

namespace App\Http\Controllers\Network;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use  App\Models\Network\NetworkGroup;
use App\Models\Network\NetworkSubIp;

class NetworkGroupController extends Controller
{

    //Group List for Network Master
    public function GroupNameList(){
        $GroupData = NetworkGroup::orderBy('name')->select('name')->get();
        return $GroupData;
    }

    public function All()
    {
        $allData = NetworkGroup::orderBy('id', 'desc')->get();
        //print_r($allData);
        return view('admin.network.group')->with('allData', $allData);
    }

    //Insert Data
    public function Insert(Request $request)
    {

        $data = new NetworkGroup();

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
            return Redirect()->route('network.group.all')->with($notification);
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
        $data = NetworkGroup::find($id);
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


    //Update
    public function Update(Request $request)
    {
        $id = request('id');
        $data = NetworkGroup::find($id);

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
            return Redirect()->route('network.group.all')->with($notification);
        } else {
            $notification = array(
                'title' => 'Error',
                'messege' => 'Somthing Going Wrong',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
    }


     //BY Group Name Sub IP List
     public function ByGroupSubIpList($group_name){
        $allData = NetworkSubIp::where('group_name', $group_name)->get();
        return view('admin.network.group-sub-ip')
            ->with('allData', $allData)
            ->with('group_name',$group_name);
      }






}
