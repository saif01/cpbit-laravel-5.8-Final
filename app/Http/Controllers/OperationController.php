<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Operation;

class OperationController extends Controller
{
    public function All()
    {
        $allData = Operation::orderBy('id', 'desc')->get();
        //print_r($allData);
        return view('admin.inventory.operation')->with('allData', $allData);
    }

    //Insert Data
    public function Insert(Request $request)
    {

        $data = new Operation();

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
            return Redirect()->route('operation.all')->with($notification);
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
        $data = Operation::find($id);
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
        $data = Operation::find($id);

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
            return Redirect()->route('operation.all')->with($notification);
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
