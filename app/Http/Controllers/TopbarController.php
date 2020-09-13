<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\TopbarAddress;

class TopbarController extends Controller
{

    public function TopbarData($data){
        return TopbarAddress::where('project', $data)->first();
    }


    public function All()
    {
        $allData = TopbarAddress::orderBy('id', 'desc')->get();
        //print_r($allData);
        return view('admin.super.topbar-address')->with('allData', $allData);
    }

    //Insert Data
    public function Insert(Request $request)
    {
        $project = $request->project;
        $data = TopbarAddress::where('project', $project)->count();

        if($data > 0){
            $notification = array(
                'title' => 'Error',
                'messege' => 'Project Info. Already Added',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }else{
            $data = new TopbarAddress();
            $successData = $data->create($request->all());
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


    //Delete data
    public function Delete($id)
    {
        $data = TopbarAddress::find($id);
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

    //update
    public function Update(Request $request)
    {
        $id = $request->id;
        $data = TopbarAddress::find($id);
        $successData = $data->update($request->all());

        if ($successData) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'Data updated',
                'alert-type' => 'info'
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
}
