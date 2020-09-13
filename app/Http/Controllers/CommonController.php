<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

class CommonController extends Controller
{
    public function CkeckValue(Request $request)
    {
        if ($request->get('value')) {
            $value = $request->get('value');
            $table = $request->get('table');
            $field = $request->get('field');
            $data = DB::table($table)
                ->where($field, $value)
                ->count();
            if ($data > 0) {
                echo 'not_unique';
            } else {
                echo 'unique';
            }
        }
    }

    public function ChangeStatus($id, $table, $filed, $value)
    {

        $successData = DB::table($table)->where('id', $id)
            ->update(array($filed => $value));
        if ($successData) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'Updated',
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

    //Edit form value find
    public function EditDataFind(Request $request)
    {
         $id  = $request->get('id');
        if($id){
            $table = $request->get('table');
            $data = DB::table($table)
                    ->where('id', $id)
                    ->first();

            echo json_encode($data);
            //echo 'okkkk';
        }

    }

}
