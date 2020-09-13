<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Session;
use App\AppRemarks;
use App\AppComplain;
use App\User;

use Illuminate\Support\Facades\Mail;

class ApplicationController extends Controller
{
    //Not Processd Complain Count
     public function NotProcessCount(){
        return AppComplain::where('status', '1')->where('process', 'Not Process')->count();
    }

    //Not Processd Complain Count
    public function ProcessingCount(){
        return AppComplain::where('status', '1')->where('process', 'Processing')->count();
    }

    //Not Processd Complain Count
    public function ClosedCount(){
        return AppComplain::where('status', '1')->where('process', 'Closed')->count();
    }

    public function Index(){
        $cmsUser = User::where('cms', '1')->count();
        $totalComplain = AppComplain::where('status', '1')->count();
        $notClosed = AppComplain::where('process','!=', 'Closed')->count();

        $chartData = DB::table('app_complains')
            ->where('status', '=', '1')
            ->select('process',  DB::raw('count(*) as total'))
            ->groupBy('process')
            ->get();

        //dd($chartData);

       return view('admin.application.index')->with('cmsUser', $cmsUser)->with('totalComplain', $totalComplain)->with('notClosed', $notClosed)->with('chartData', $chartData);
    }

    //Not Process Complains
    public function NotProcess(){
        $allData = DB::table('app_complains')
            ->join('users', 'users.id', '=', 'app_complains.user_id')
            ->select('app_complains.*', 'users.name', 'users.department')
            ->where('app_complains.process', '=', 'Not Process')
            ->where('app_complains.status', '=', '1')
            ->orderBy('app_complains.id', 'desc')
            ->get();

        //dd($allData);
        return view('admin.application.not-process')->with('allData', $allData);
    }

    //Processing Complains
    public function Processing()
    {
        $allData = DB::table('app_complains')
            ->join('users', 'users.id', '=', 'app_complains.user_id')
            ->select('app_complains.*', 'users.name', 'users.department')
            ->where('app_complains.process', '=', 'Processing')
            ->where('app_complains.status', '=', '1')
            ->orderBy('app_complains.id', 'desc')
            ->get();

        //dd($allData);
        return view('admin.application.processing')->with('allData', $allData);
    }

    //Closed Complains
    public function Closed()
    {
        $allData = DB::table('app_complains')
            ->join('users', 'users.id', '=', 'app_complains.user_id')
            ->select('app_complains.*', 'users.name', 'users.department')
            ->where('app_complains.process', '=', 'Closed')
            ->where('app_complains.status', '=', '1')
            ->orderBy('app_complains.id', 'desc')
            ->get();

        //dd($allData);
        return view('admin.application.closed')->with('allData', $allData);
    }

    //All Complains Reports
    public function AllReports()
    {
        $allData = DB::table('app_complains')
            ->join('users', 'users.id', '=', 'app_complains.user_id')
            ->select('app_complains.*', 'users.name', 'users.department')
            ->orderBy('app_complains.id', 'desc')
            ->get();

        //dd($allData);
        return view('admin.application.reports-all')->with('allData', $allData);
    }

    //Complain Action Page
    public function Action($id){
        $compData = DB::table('app_complains')
            ->join('users', 'users.id', '=', 'app_complains.user_id')
            ->select('app_complains.*', 'users.name', 'users.department')
            ->where('app_complains.id', '=', $id)
            ->where('app_complains.status', '=', '1')
            ->first();

        $remarksData = AppRemarks::orderBy('id', 'asc')->where('comp_id', $id)->get();

        return view('admin.application.action')->with('compData', $compData)->with('remarksData', $remarksData);
    }

    //Complain Action Update
    public function ActionUpdate(Request $request, $id, $user_id){
        $validateData = $request->validate([
            'remarks' => 'required|max:20000',
            'document' => 'max:3000 | file |mimes:ppt,pptx,jpg,jpeg,bmp,png,doc,docx,csv,rtf,xlsx,xls,txt,pdf',
        ]);

        //Update AppComplain table Process
        $complainData = AppComplain::findOrFail($id);
        $complainData->process = $request->process;
        $successData = $complainData->save();

        //Insert AppRemarks table Data
        $data = new AppRemarks();

        $document = $request->file('document');
        $process = $request->process;
        $remarks = $request->remarks;

        //user Data
        $userData = User::findOrFail($user_id);
        $mailData = array(
            'to' => $userData->email,
            'bu_email' => $userData->bu_email,
            'name' => $userData->name,
            'process' => $process,
            'remarks' => $remarks,
            'compId' => $id,
            'document' => $document
        );

        //Send Mail
        Mail::send('mail.admin.app-complain-action', $mailData, function ($message) use ($mailData) {
            //Remove if space have
            $array = array_map('trim', explode(',', $mailData['bu_email']));
            $message->to($mailData['to']);
            $message->cc($array);
            $message->subject($mailData['compId'].' : Application Complain Update');
            $message->from('it-noreply@cpbangladesh.com');
            //If Attachment Have
            if ($mailData['document']) {
                $message->attach(
                    $mailData['document']->getRealPath(),
                    array(
                        'as' => 'ApplicationReplay.' . $mailData['document']->getClientOriginalExtension(),
                        'mime' => $mailData['document']->getMimeType()
                    )
                );
            }
        });


        //Document Have Or Not
        if ($document) {
            $document_name = str_random(5);
            $ext = strtolower($document->getClientOriginalExtension());
            $document_full_name = $document_name . '.' . $ext;
            $upload_path = 'public/images/application/';
            $document_url = $upload_path . $document_full_name;
            $successImg = $document->move($upload_path, $document_full_name);
            $data->document = $document_url;
        }



        $data->comp_id = $id;
        $data->process = $process;
        $data->remarks = $remarks;
        $data->action_by = session()->get('admin.name');
        $data->action_id = session()->get('admin.id');
        $successData2 = $data->save();
        //echo $data;



        if(Mail::failures()){
            $notification = array(
                'title' => 'Error',
                'messege' => 'Email Not Send',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
        elseif ($successData && $successData2 ) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'Remarks Updated',
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
