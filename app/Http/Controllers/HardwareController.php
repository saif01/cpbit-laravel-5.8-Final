<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\HardComplian;
use App\HardRemarks;
use App\User;
use DB;
use Session;
use App\HardDelievery;
use Carbon\Carbon;
use DataTables;


use Illuminate\Support\Facades\Mail;

class HardwareController extends Controller
{
    //Not Processd Complain Count
    public function NotProcessCount()
    {
        return HardComplian::where('status', '1')
            ->where('process', 'Not Process')
            ->where('status', '1')
            ->count();
    }

    //Not Processd Complain Count
    public function ProcessingCount()
    {
        return HardComplian::where('status', '1')
            ->where('process', 'Processing')
            ->where('status', '1')
            ->count();
    }

    //Not Processd Complain Count
    public function ClosedCount()
    {
        return HardComplian::where('status', '1')
            ->where('process', 'Closed')
            ->count();
    }

    //Not Processd Complain Count
    public function CanceledCount()
    {
        return HardComplian::where('status', '0')->count();
    }

    //Hardware Dashboard
    public function Index(){

        $cmsUser = User::where('cms', '1')->count();
        $totalComplain = HardComplian::where('status', '1')->count();
        $pandingCom = HardComplian::where('process', '!=', 'Closed')
            ->where('process', '!=', 'Damaged')
            ->where('status', '1')
            ->count();
        $pandingDelivery = HardComplian::where('process', '=', 'Closed')
            ->where('delivery', '=', 'Deliverable')
            ->where('status', '1')
            ->count();

        $chartData = DB::table('hard_complians')
            ->where('status', '=', '1')
            ->select('process',  DB::raw('count(*) as total'))
            ->groupBy('process')
            ->get();

        return view('admin.hardware.index')
            ->with('cmsUser', $cmsUser)
            ->with('totalComplain', $totalComplain)
            ->with('pandingDelivery', $pandingDelivery)
            ->with('pandingCom', $pandingCom)
            ->with('chartData', $chartData);
    }

    //Not Process Complains
    public function NotProcess()
    {

            if(request()->ajax())
            {


                $data =  DB::table('hard_complians')
                    ->join('users', 'users.id', '=', 'hard_complians.user_id')
                    ->select('hard_complians.*', 'users.name', 'users.department', 'users.bu_location')
                    ->where('hard_complians.process', '=', 'Not Process')
                    ->where('hard_complians.status', '=', '1')
                    ->orderBy('hard_complians.id', 'desc')
                    ->get();

                 //dd($data);

                return DataTables::of($data)

                        ->addColumn('com_num', function($data){
                            return '<span class="badge badge-pill gradient-green-tea white h5">'.$data->id.' </span>';
                        })


                        ->addColumn('userName', function($data){
                            $button = '';
                            $button = '<button id="'.$data->user_id.'" class="viewUserData btn gradient-green-teal btn-sm round" >'.$data->name.' <i class="fa fa-eye"></i></button>';
                            return $button;
                        })

                        ->addColumn('register', function($data){
                            return date("j-F-Y, g:i A", strtotime($data->created_at)) ;
                        })


                        ->addColumn('action', function($data){
                            return '<a href="'.route('hard.complain.action', $data->id).'" title="Action" class="btn gradient-amber-amber white round"> Action <i class="fa fa-external-link"></i></a>';
                        })

                        ->rawColumns(['com_num', 'userName', 'register' , 'action'])
                        ->make(true);
            }



        return view('admin.hardware.not-process');
    }

    //Processing Complains
    public function Processing()
    {

        if(request()->ajax())
        {

            $data =  DB::table('hard_complians')
                ->join('users', 'users.id', '=', 'hard_complians.user_id')
                ->select('hard_complians.*', 'users.name', 'users.department', 'users.bu_location')
                ->where('hard_complians.process', '=', 'Processing')
                ->where('hard_complians.status', '=', '1')
                ->orderBy('hard_complians.id', 'desc')
                ->get();

            // dd($data);

            return DataTables::of($data)

                    ->addColumn('com_num', function($data){
                        return '<span class="badge badge-pill gradient-green-tea white h5">'.$data->id.' </span>';
                    })


                    ->addColumn('userName', function($data){
                        $button = '';
                        $button = '<button id="'.$data->user_id.'" class="viewUserData btn gradient-green-teal btn-sm round" >'.$data->name.' <i class="fa fa-eye"></i></button>';
                        return $button;
                    })

                    ->addColumn('register', function($data){
                        return date("j-F-Y, g:i A", strtotime($data->created_at)) ;
                    })

                    ->addColumn('warrStatus', function($data){
                        if ($data->warranty == 's_w'){
                            return '<span class="bg-warning badge">Send To Warranty</span>';
                        }elseif ($data->warranty == 'b_w'){
                            return '<span class="bg-success badge">Back To Warranty</span>';
                        }elseif ($data->warranty == 'a_s_w'){
                            return '<span class="bg-info badge">Again Send To Warranty</span>';
                        }else{
                            return '<span class="bg-secondary badge">No Warranty</span>';
                        }

                    })

                    ->addColumn('action', function($data){
                        return '<a href="'.route('hard.complain.action', $data->id).'" title="Action" class="btn gradient-amber-amber white round">Action <i class="fa fa-external-link"></i></a>';
                    })

                    ->rawColumns(['com_num', 'userName', 'register' ,'warrStatus', 'action'])
                    ->make(true);
        }

        //dd($allData);
        return view('admin.hardware.processing');
    }

    //Closed Complains
    public function Closed()
    {

            if(request()->ajax())
            {

                $data = DB::table('hard_complians')
                    ->join('users', 'users.id', '=', 'hard_complians.user_id')
                    ->select('hard_complians.*', 'users.name', 'users.department', 'users.bu_location')
                    ->where('hard_complians.process', '=', 'Closed')
                    ->where('hard_complians.status', '=', '1')
                    ->orderBy('hard_complians.id', 'desc')
                    ->get();

               // dd($data);

                return DataTables::of($data)

                        ->addColumn('action', function($data){
                            return '<a href="'.route('hard.complain.action', $data->id).'" title="Action" class="btn gradient-amber-amber white round"> Details <i class="fa fa-eye"></i></a>';
                        })

                        ->addColumn('com_num', function($data){
                           return '<span class="badge badge-pill gradient-green-tea white h5">'.$data->id.' </span>';
                        })

                        ->addColumn('userName', function($data){
                            $button = '';
                            $button = '<button id="'.$data->user_id.'" class="viewUserData btn gradient-green-teal btn-sm round" >'.$data->name.' <i class="fa fa-eye"></i></button>';
                            return $button;
                        })

                        ->addColumn('lastUpdated', function($data){
                            return date("j-F-Y, g:i A", strtotime($data->updated_at));
                        })

                        ->addColumn('deliveryStatus', function($data){

                           if($data->delivery == 'Deliverable'){
                              return '<span class="bg-warning badge">Deliverable</span>';
                           }elseif($data->delivery == 'Delivered'){
                              return '<span class="bg-success badge">Delivered</span>';
                           }else{
                              return '<span class="bg-secondary badge">Not Deliverable</span>';
                           }

                        })


                        ->rawColumns(['com_num', 'userName', 'lastUpdated', 'deliveryStatus' ,'action'])
                        ->make(true);
            }


        return view('admin.hardware.closed');
    }

    //Canceled Complains
    public function Canceled()
    {


        if(request()->ajax())
        {

            $data =  DB::table('hard_complians')
                ->join('users', 'users.id', '=', 'hard_complians.user_id')
                ->select('hard_complians.*', 'users.name', 'users.bu_location')
                ->where('hard_complians.status', '=', '0')
                ->orderBy('hard_complians.id', 'desc')
                ->get();

            // dd($data);

            return DataTables::of($data)

                    ->addColumn('com_num', function($data){
                        return '<span class="badge badge-pill gradient-green-tea white h5">'.$data->id.' </span>';
                    })


                    ->addColumn('userName', function($data){
                        $button = '';
                        $button = '<button id="'.$data->user_id.'" class="viewUserData btn gradient-green-teal btn-sm round" >'.$data->name.' <i class="fa fa-eye"></i></button>';
                        return $button;
                    })

                    ->addColumn('lastUpdated', function($data){
                        return date("j-F-Y, g:i A", strtotime($data->updated_at)) ;
                    })

                    ->addColumn('register', function($data){
                        return date("j-F-Y, g:i A", strtotime($data->created_at)) ;
                    })



                    ->rawColumns(['com_num', 'userName', 'lastUpdated' ,'register'])
                    ->make(true);
        }

        //dd($allData);
        return view('admin.hardware.canceled');
    }

    //Damaged Complains
    public function Damaged()
    {

        if(request()->ajax())
        {

            $data = DB::table('hard_complians')
                ->join('users', 'users.id', '=', 'hard_complians.user_id')
                ->select('hard_complians.*', 'users.name', 'users.department', 'users.bu_location')
                ->where('hard_complians.process', '=', 'Damaged')
                ->where('hard_complians.status', '=', '1')
                ->orderBy('hard_complians.id', 'desc')
                ->get();

            // dd($data);

            return DataTables::of($data)

                    ->addColumn('action', function($data){
                        return '<a href="'.route('hard.complain.action', $data->id).'" title="Action" class="btn gradient-amber-amber white round"> Details <i class="fa fa-eye"></i></a>';
                    })

                    ->addColumn('com_num', function($data){
                        return '<span class="badge badge-pill gradient-green-tea white h5">'.$data->id.' </span>';
                    })


                    ->addColumn('userName', function($data){
                        $button = '';
                        $button = '<button id="'.$data->user_id.'" class="viewUserData btn gradient-green-teal btn-sm round" >'.$data->name.' <i class="fa fa-eye"></i></button>';
                        return $button;
                    })

                    ->addColumn('lastUpdated', function($data){
                        return date("j-F-Y, g:i A", strtotime($data->updated_at)) ;
                    })



                    ->rawColumns(['com_num', 'userName', 'lastUpdated' ,'action'])
                    ->make(true);
        }

        return view('admin.hardware.damaged');
    }

    //Complain Action Page
    public function Action($id)
    {
        $compData = DB::table('hard_complians')
            ->join('users', 'users.id', '=', 'hard_complians.user_id')
            ->select('hard_complians.*', 'users.name', 'users.department')
            ->where('hard_complians.id', '=', $id)
            ->where('hard_complians.status', '=', '1')
            ->first();

        $remarksData = HardRemarks::orderBy('id', 'asc')->where('comp_id', $id)->get();

        $deliveryData = HardDelievery::where('comp_id', $id)->first();

       // dd( $deliveryData);

        return view('admin.hardware.action', compact('compData', 'remarksData', 'deliveryData'));
    }

    //All Complains Reports
    public function AllReports()
    {


            if(request()->ajax())
            {

                $data = DB::table('hard_complians')
                ->join('users', 'users.id', '=', 'hard_complians.user_id')
                ->select('hard_complians.*', 'users.name', 'users.department', 'users.bu_location')
                ->orderBy('hard_complians.id', 'desc')
                ->get();

                // dd($data);

                return DataTables::of($data)

                        ->addColumn('com_num', function($data){
                            return '<span class="badge badge-pill gradient-green-tea white h5">'.$data->id.' </span>';
                        })


                        ->addColumn('userName', function($data){
                            $button = '';
                            $button = '<button id="'.$data->user_id.'" class="viewUserData btn gradient-green-teal btn-sm round" >'.$data->name.' <i class="fa fa-eye"></i></button>';
                            return $button;
                        })

                        ->addColumn('lastUpdated', function($data){
                            return date("j-F-Y, g:i A", strtotime($data->updated_at)) ;
                        })

                        ->addColumn('register', function($data){
                            return date("j-F-Y, g:i A", strtotime($data->created_at)) ;
                        })

                        ->addColumn('comStatus', function($data){
                            if($data->status == 1){
                                return 'Active';
                            }else{
                                return 'Canceled';
                            }
                            return date("j-F-Y, g:i A", strtotime($data->created_at)) ;
                        })



                        ->rawColumns(['com_num', 'userName', 'lastUpdated' ,'register', 'comStatus'])
                        ->make(true);
            }

        return view('admin.hardware.reports-all');
    }

    //Deliverable Report
    public function AllDeliverable()
    {

        if(request()->ajax())
        {

            $data =  DB::table('hard_complians')
                ->join('users', 'users.id', '=', 'hard_complians.user_id')
                ->where('hard_complians.delivery', '=', 'Deliverable')
                ->select('hard_complians.*', 'users.name', 'users.department', 'users.bu_location')
                ->where('hard_complians.status', '=', '1')
                ->orderBy('hard_complians.id', 'desc')
                ->get();

            // dd($data);

            return DataTables::of($data)

                    ->addColumn('action', function($data){
                        return '<a href="'.route('hard.complain.action', $data->id).'" title="Action" class="btn gradient-amber-amber white round"> Details <i class="fa fa-eye"></i></a>';
                    })

                    ->addColumn('com_num', function($data){
                        return '<span class="badge badge-pill gradient-green-tea white h5">'.$data->id.' </span>';
                    })


                    ->addColumn('userName', function($data){
                        $button = '';
                        $button = '<button id="'.$data->user_id.'" class="viewUserData btn gradient-green-teal btn-sm round" >'.$data->name.' <i class="fa fa-eye"></i></button>';
                        return $button;
                    })

                    ->addColumn('lastUpdated', function($data){
                        return date("j-F-Y, g:i A", strtotime($data->updated_at)) ;
                    })



                    ->rawColumns(['com_num', 'userName', 'lastUpdated' ,'action'])
                    ->make(true);
        }

        return view('admin.hardware.deliverable');
    }

    //Delivered Report
    public function AllDelivered()
    {

            if(request()->ajax())
            {

                $data = DB::table('hard_complians')
                    ->join('users', 'users.id', '=', 'hard_complians.user_id')
                    ->join('hard_delieveries', 'hard_delieveries.comp_id', '=', 'hard_complians.id')
                    ->where('hard_complians.delivery', '=', 'Delivered')
                    ->select('hard_complians.*', 'users.name', 'users.bu_location', 'users.department', 'hard_delieveries.name as deliName', 'hard_delieveries.contact as deliContact')
                    ->orderBy('hard_complians.id', 'desc')
                    ->get();

               // dd($data);

                return DataTables::of($data)

                        ->addColumn('action', function($data){

                            return '<a href="'.route('hard.complain.action', $data->id).'" title="Action" class="btn gradient-amber-amber white round"> Details <i class="fa fa-eye"></i></a>';

                        })

                        ->addColumn('com_num', function($data){
                           return '<span class="badge badge-pill gradient-green-tea white h5">'.$data->id.' </span>';
                        })


                        ->addColumn('userName', function($data){
                            $button = '';
                            $button = '<button id="'.$data->user_id.'" class="viewUserData btn gradient-green-teal btn-sm round" >'.$data->name.' <i class="fa fa-eye"></i></button>';
                            return $button;
                        })

                        ->addColumn('lastUpdated', function($data){
                            return date("j-F-Y, g:i A", strtotime($data->updated_at)) ;
                        })


                        ->rawColumns(['com_num', 'userName', 'lastUpdated' ,'action'])
                        ->make(true);
            }

        return view('admin.hardware.delivered');
    }

    //Complain Not Process Action Update
    public function ActionNotProcess(Request $request, $id, $user_id)
    {
        $validateData = $request->validate([
            'remarks' => 'required|max:20000',
            'document' => 'max:3000|mimes:jpg,jpeg,bmp,png,doc,docx,csv,rtf,xlsx,xls,txt,pdf', // file only jgp and size Not more than 3 MB
        ]);


        //Insert AppRemarks table Data
        $data = new HardRemarks();

        $document = $request->file('document');
        $process = $request->process;
        $remarks = $request->remarks;
        $warranty = $request->warranty;
        $delivery = $request->delivery;

        //All Tools
        $toolsall = $request->tools;
        if($toolsall){
            $tools = implode(",", $toolsall);
        }else{
           $tools ='';
        }


        //user Data
        $userData = User::findOrFail($user_id);
        $bu_emails = $userData->bu_email;
        $bu_emails_without_last_comma = rtrim($bu_emails,',');
        $mailData = array(
            'to' => $userData->email,
            'bu_email' => $bu_emails_without_last_comma,
            'name' => $userData->name,
            'process' => $process,
            'remarks' => $remarks,
            'compId' => $id,
            'tools' => $tools,
            'warranty' => $warranty,
            'delivery' => $delivery,
            'document' => $document
        );



        //$array = explode(",",$mailData['bu_email']);
        //dd($bu_emails_without_last_comma, $array);

        //Send Mail
        Mail::send('mail.admin.hard-complain-action', $mailData, function ($message) use ($mailData) {
            //Remove if space have
            $array = array_map('trim', explode(',', $mailData['bu_email']));

            $message->to($mailData['to']);
            $message->cc($array);
            $message->subject($mailData['compId'].' : Hardware Complain Update');
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
            $upload_path = 'public/images/hardware/';
            $document_url = $upload_path . $document_full_name;
            $successImg = $document->move($upload_path, $document_full_name);
            $data->document = $document_url;
        }

         //Update HardComplian table Process
        if($process != 'Not Process'){
            $complainData = HardComplian::findOrFail($id);
            $complainData->process = $process;
            $complainData->warranty = $warranty;
            $complainData->delivery = $delivery;
            $successData = $complainData->save();
        }

        $data->comp_id = $id;
        $data->process = $process;
        $data->warranty = $warranty;
        $data->remarks = $remarks;
        $data->action_by = session()->get('admin.name');
        $data->action_id = session()->get('admin.id');
        $data->updated_at = Carbon::now();
        $successData2 = $data->save();
        //echo $data;

        if (Mail::failures()) {
            $notification = array(
                'title' => 'Error',
                'messege' => 'Email Not Send',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        } elseif($successData2) {
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

    //Complain Action Update
    public function ActionProcessing(Request $request, $id, $user_id)
    {
        $validateData = $request->validate([
            'remarks' => 'required|max:20000',
            'document' => 'max:3000|mimes:jpg,jpeg,bmp,png,doc,docx,csv,rtf,xlsx,xls,txt,pdf', // file only jgp and size Not more than 3 MB
        ]);


        //Insert AppRemarks table Data
        $data = new HardRemarks();

        $document = $request->file('document');
        $process = $request->process;
        $remarks = $request->remarks;
        $delivery = $request->delivery;


        //user Data
        $userData = User::findOrFail($user_id);
        $bu_emails = $userData->bu_email;
        $bu_emails_without_last_comma = rtrim($bu_emails,',');
        $mailData = array(
            'to' => $userData->email,
            'bu_email' => $bu_emails_without_last_comma,
            'name' => $userData->name,
            'process' => $process,
            'remarks' => $remarks,
            'compId' => $id,
            'tools' => '',
            'warranty' => '',
            'delivery' => $delivery,
            'document' => $document
        );

        //Send Mail
        Mail::send('mail.admin.hard-complain-action', $mailData, function ($message) use ($mailData) {
            //Remove if space have
            $array = array_map('trim', explode(',', $mailData['bu_email']));
            $message->to($mailData['to']);
            $message->cc($array);
            $message->subject($mailData['compId'] . ' : Hardware Complain Update');
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
            $upload_path = 'public/images/hardware/';
            $document_url = $upload_path . $document_full_name;
            $successImg = $document->move($upload_path, $document_full_name);
            $data->document = $document_url;
        }

        //Update HardComplian table Process
        $complainData = HardComplian::findOrFail($id);
        $complainData->process = $process;
        $complainData->delivery = $delivery;
        $complainData->updated_at = Carbon::now();
        $successData = $complainData->save();


        $data->comp_id = $id;
        $data->process = $process;
        $data->remarks = $remarks;
        $data->action_by = session()->get('admin.name');
        $data->action_id = session()->get('admin.id');
        $data->updated_at = Carbon::now();
        $successData2 = $data->save();
        //echo $data;

        if (Mail::failures()) {
            $notification = array(
                'title' => 'Error',
                'messege' => 'Email Not Send',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        } elseif ($successData2) {
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


    //Warranty Action
    public function ActionWarranty(Request $request, $id, $user_id)
    {
        $validateData = $request->validate([
            'remarks' => 'required|max:20000',
            'document' => 'max:3000|mimes:jpg,jpeg,bmp,png,doc,docx,csv,rtf,xlsx,xls,txt,pdf', // file only jgp and size Not more than 3 MB
        ]);


        //Insert AppRemarks table Data
        $data = new HardRemarks();

        $document = $request->file('document');
        $process = 'Processing';
        $remarks = $request->remarks;

        $warranty_st = $request->warranty_st;

        //user Data
        $userData = User::findOrFail($user_id);
        $bu_emails = $userData->bu_email;
        $bu_emails_without_last_comma = rtrim($bu_emails,',');
        $mailData = array(
            'to' => $userData->email,
            'bu_email' => $bu_emails_without_last_comma,
            'name' => $userData->name,
            'process' => $process,
            'remarks' => $remarks,
            'compId' => $id,
            'tools' => '',
            'warranty' => $warranty_st,
            'delivery' => '',
            'document' => $document
        );

        //Send Mail
        Mail::send('mail.admin.hard-complain-action', $mailData, function ($message) use ($mailData) {

            //Remove if space have
            $array = array_map('trim', explode(',', $mailData['bu_email']));
            $message->to($mailData['to']);
            $message->cc($array);
            $message->subject($mailData['compId'] . ' : Hardware Complain Update');
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
            $upload_path = 'public/images/hardware/';
            $document_url = $upload_path . $document_full_name;
            $successImg = $document->move($upload_path, $document_full_name);
            $data->document = $document_url;
        }

        //Update HardComplian table Process
        $complainData = HardComplian::findOrFail($id);
        $complainData->process = $process;
        $complainData->warranty = $warranty_st;
        $complainData->updated_at = Carbon::now();
        $successData = $complainData->save();


        $data->comp_id = $id;
        $data->process = $process;
        $data->remarks = $remarks;
        $data->warranty = $warranty_st;
        $data->action_by = session()->get('admin.name');
        $data->action_id = session()->get('admin.id');
        $data->updated_at = Carbon::now();
        $successData2 = $data->save();
        //echo $data;

        if (Mail::failures()) {
            $notification = array(
                'title' => 'Error',
                'messege' => 'Email Not Send',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        } elseif ($successData2) {
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

    // Delivery Action Update
    public function ActionDelivery(Request $request, $id, $user_id)
    {
        $validateData = $request->validate([
            'name' => 'required|min:3|max:50',
            'contact' => 'required|digits_between:11,11|numeric',
            'document' => 'max:3000|mimes:jpg,jpeg,bmp,png,doc,docx,csv,rtf,xlsx,xls,txt,pdf', // file only jgp and size Not more than 3 MB
        ]);


        //Insert AppRemarks table Data
        $data = new HardDelievery();

        $document = $request->file('document');
        $remarks = $request->remarks;
        $name = $request->name;
        $contact = $request->contact;



        //user Data
        $userData = User::findOrFail($user_id);
        $bu_emails = $userData->bu_email;
        $bu_emails_without_last_comma = rtrim($bu_emails,',');
        $mailData = array(
            'to' => $userData->email,
            'bu_email' => $bu_emails_without_last_comma,
            'name' => $userData->name,
            'process' => 'Delivered',
            'remarks' => $remarks,
            'compId' => $id,
            'tools' => '',
            'warranty' => '',
            'delivery' => 'Delivered',
            'document' => $document,
            'recName'  => $name,
            'recContact' => $contact
        );

        //Send Mail
        Mail::send('mail.admin.hard-complain-action', $mailData, function ($message) use ($mailData) {
            //Remove if space have
            $array = array_map('trim', explode(',', $mailData['bu_email']));
            $message->to($mailData['to']);
            $message->cc($array);
            $message->subject($mailData['compId'] . ' : Hardware Complain Update');
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
            $upload_path = 'public/images/hardware/';
            $document_url = $upload_path . $document_full_name;
            $successImg = $document->move($upload_path, $document_full_name);
            $data->document = $document_url;
        }

        //Update HardComplian table Process
        $complainData = HardComplian::findOrFail($id);
        $complainData->delivery = 'Delivered';
        $complainData->updated_at = Carbon::now();
        $successData = $complainData->save();


        $data->comp_id = $id;
        $data->name = $name;
        $data->contact = $contact;
        $data->remarks = $remarks;
        $data->action_by = session()->get('admin.name');
        $data->action_id = session()->get('admin.id');
        $data->updated_at = Carbon::now();
        $successData2 = $data->save();
        //echo $data;

        if (Mail::failures()) {
            $notification = array(
                'title' => 'Error',
                'messege' => 'Email Not Send',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        } elseif ($successData2) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'Product Delivered',
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
