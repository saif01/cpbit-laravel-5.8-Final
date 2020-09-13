<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\SmsUser;
use App\User;
use DB;

class SmsUserController extends Controller
{
    public function Index(){
        
         $smsOperationData = DB::table('sms_operations')->get();
         $smsUser = DB::table('users')
            ->leftJoin('sms_users', 'sms_users.user_id', '=', 'users.id')
            ->select('users.*', 'sms_users.access')
            ->get();

        //dd($smsUser);

        return view('admin.super.sms.sms-user')
            ->with('smsOperationData', $smsOperationData)
            ->with('smsUser', $smsUser);
        
    }

    public function UserAccess($id){

        $smsUser = DB::table('users')
        ->where('users.id', '=', $id)
        ->leftJoin('sms_users', 'sms_users.user_id', '=', 'users.id')
        ->select('users.*', 'sms_users.access')
        ->first();

        // $userData = User::find($id);
         $smsOperationData = DB::table('sms_operations')->get();
        // $smsUser = DB::table('sms_users')->where('user_id', $id)->first();

        //dd($smsUser);

       return view('admin.super.sms.sms-user-access')  
            ->with('smsOperationData', $smsOperationData)
            ->with('smsUser', $smsUser);
           

    }

    //User Access Update
    public function SmsUserUpdate(Request $request){

        $user_id = $request->user_id;
        $access = $request->access;
        if(!empty($access)){
            $access = implode(",", $access);
        }
       
        $tblId = DB::table('sms_users')->where('user_id',$user_id)->select('id')->first();
       
         if( $tblId ){

            if( empty($access) ){
                //Delete Access
                $data = SmsUser::find($tblId->id);
                $successData = $data->delete();

            }else{

                //Update Existing Access
                $data = SmsUser::find($tblId->id);
                $data->user_id = $user_id;
                $data->access = $access;
                $successData = $data->save();
            }


        }else{
            //New Access Insert
            $data = new SmsUser();
            $data->user_id = $user_id;
            $data->access = $access;
            $successData = $data->save();

           // echo $access;
        }


        if ($successData) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'Data Inserted',
                'alert-type' => 'success'
            );
            return Redirect()->route('sms.user.super')->with($notification);
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
