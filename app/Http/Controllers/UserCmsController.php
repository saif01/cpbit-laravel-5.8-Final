<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AppCategory;
use App\AppSubCategory;
use App\AppComplain;
use Session;
use DB;
use App\HardCategory;
use App\HardSubCategory;
use App\HardComplian;
use App\AppRemarks;
use App\User;
use App\HardRemarks;
use App\HardDelievery;

use Validator;

use Illuminate\Support\Facades\Mail;
use App\Mail\AppComplainSubmitMail;
use App\Mail\HardComplainSubmitMail;

class UserCmsController extends Controller
{
    public function Index(){

        $categoryData = AppCategory::orderBy('category')->get();
        $hardCategoryData = HardCategory::orderBy('category')->get();

        return view('user.cms.index')->with('categoryData', $categoryData)->with('hardCategoryData', $hardCategoryData);
    }

    //User Profile Page
    public function UserProfile()
    {
        $allData = User::findOrFail(session()->get('user.id'));
        return view('user.cms.user-profile')->with('allData', $allData);
    }

    //App SubCategory
    public function AppSubcategory(Request $request){

        $cat_id  = $request->get('cat_id');
        $subCategoryData = AppSubCategory::where('cat_id', '=', $cat_id)->get();
        //return Response::json($subCategoryData);
        return response()->json($subCategoryData);
    }

    //App Complain Submit
    public function AppComplainSubmit(Request $request){

           $validateData = $request->validate([
            'cat_id' => 'required',
            'sub_id' => 'required',
            'details' => 'required|max:10000',
            'doc1' => 'max:1500 | file | mimes:ppt,pptx,jpg,jpeg,bmp,png,doc,docx,csv,rtf,xlsx,xls,txt,pdf',
            'doc2' => 'max:1500 | file | mimes:ppt,pptx,jpg,jpeg,bmp,png,doc,docx,csv,rtf,xlsx,xls,txt,pdf',
            'doc3' => 'max:1500 | file | mimes:ppt,pptx,jpg,jpeg,bmp,png,doc,docx,csv,rtf,xlsx,xls,txt,pdf',
            'doc4' => 'max:1500 | file |mimes:ppt,pptx,jpg,jpeg,bmp,png,doc,docx,csv,rtf,xlsx,xls,txt,pdf',
            ]);

        $data = new AppComplain();

        $doc1 = $request->file('doc1');
        if ($doc1) {
            $doc1_name = str_random(5);
            $ext = strtolower($doc1->getClientOriginalExtension());
            $doc1_full_name = $doc1_name . '.' . $ext;
            $upload_path = 'public/images/application/';
            $doc1_url = $upload_path . $doc1_full_name;
            $successImg = $doc1->move($upload_path, $doc1_full_name);
            $data->doc1 = $doc1_url;
        }

        $doc2 = $request->file('doc2');
        if ($doc2) {
            $doc2_name = str_random(5);
            $ext = strtolower($doc2->getClientOriginalExtension());
            $doc2_full_name = $doc2_name . '.' . $ext;
            $upload_path = 'public/images/application/';
            $doc2_url = $upload_path . $doc2_full_name;
            $successImg2 = $doc2->move($upload_path, $doc2_full_name);
            $data->doc2 = $doc2_url;
        }
        $doc3 = $request->file('doc3');
        if ($doc3) {
            $doc3_name = str_random(5);
            $ext = strtolower($doc3->getClientOriginalExtension());
            $doc3_full_name = $doc3_name . '.' . $ext;
            $upload_path = 'public/images/application/';
            $doc3_url = $upload_path . $doc3_full_name;
            $successImg3 = $doc3->move($upload_path, $doc3_full_name);
            $data->doc3 = $doc3_url;
        }

        $doc4 = $request->file('doc4');
        if ($doc4) {
            $doc4_name = str_random(5);
            $ext = strtolower($doc4->getClientOriginalExtension());
            $doc4_full_name = $doc4_name . '.' . $ext;
            $upload_path = 'public/images/application/';
            $doc4_url = $upload_path . $doc4_full_name;
            $successImg3 = $doc4->move($upload_path, $doc4_full_name);
            $data->doc4 = $doc4_url;
        }


        $cat_id = $request->cat_id;
        $sub_id = $request->sub_id;
        $details = $request->details;

        //Category Subcategory name
        $CatSubcat = DB::table('app_sub_categories')
            ->join('app_categories', 'app_categories.id', '=', 'app_sub_categories.cat_id')
            ->where('app_sub_categories.id', '=', $sub_id)
            ->select('app_sub_categories.subcategory', 'app_categories.category')
            ->first();
        $category = $CatSubcat->category;
        $subcategory = $CatSubcat->subcategory;

        $data->user_id = session()->get('user.id');
        $data->category = $category;
        $data->subcategory = $subcategory;
        $data->details = $details;
        $data->process = 'Not Process';
        $data->status = '1';
        $successData = $data->save();

        //Last Complain Number
        $compNumber = AppComplain::orderBy('id', 'desc')->select('id')->first();

        $mailData = (object) array(
            'compNumber' => $compNumber->id,
            'name' => session()->get('user.name'),
            'department'=> session()->get('user.department'),
            'bu_location' => session()->get('user.bu_location'),
            'category' => $category,
            'subcategory' => $subcategory,
            'details' => $details
        );

        //Send Mail
        Mail::to(['kalam@cpbangladesh.com'])->send(new AppComplainSubmitMail($mailData));

        if (Mail::failures()) {
            $notification = array(
                'title' => 'Error',
                'messege' => 'Email Not Send',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        } elseif ($successData) {
            $notification = array(
                'big-title' => 'Successfully, Your Complain Number:  ' . $compNumber->id,
                'big-alert-type' => 'success'
            );
            return Redirect()->route('user.cms.dashboard')->with($notification);
        } else {
            $notification = array(
                'big-title' => 'Error !! Somthing Going Wrong',
                'big-alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }


    }

    //Hard SubCategory
    public function HardSubcategory(Request $request)
    {

        $cat_id  = $request->get('cat_id');
        $hardSubCategoryData = HardSubCategory::where('cat_id', '=', $cat_id)->get();
        //return Response::json($subCategoryData);
        return response()->json($hardSubCategoryData);
    }

    //App Complain Submit
    public function HardComplainSubmit(Request $request)
    {

        $validateData = $request->validate([
            'cat_id' => 'required',
            'sub_id' => 'required',
            'details' => 'required|max:10000',
            //'details' => 'required|not_regex:/^.+$/i|max:2000',
            'computer_name' => 'required|max:50',
            'tools' => 'array|max:5',
            'documents' => 'max:3000 | file |mimes:ppt,pptx,jpg,jpeg,bmp,png,doc,docx,csv,rtf,xlsx,xls,txt,pdf',
        ]);

        $data = new HardComplian();

        $documents = $request->file('documents');
        if ($documents) {
            $documents_name = str_random(5);
            $ext = strtolower($documents->getClientOriginalExtension());
            $documents_full_name = $documents_name . '.' . $ext;
            $upload_path = 'public/images/hardware/';
            $documents_url = $upload_path . $documents_full_name;
            $successImg = $documents->move($upload_path, $documents_full_name);
            $data->documents = $documents_url;
        }

        $cat_id = $request->cat_id;
        $sub_id = $request->sub_id;
        $details = $request->details;

        //Category Subcategory name
        $CatSubcat = DB::table('hard_sub_categories')
            ->join('hard_categories', 'hard_categories.id', '=', 'hard_sub_categories.cat_id')
            ->where('hard_sub_categories.id', '=', $sub_id)
            ->select('hard_sub_categories.subcategory', 'hard_categories.category')
            ->first();



        $category = $CatSubcat->category;
        $subcategory = $CatSubcat->subcategory;

        //All Tools
        $toolsall = $request->tools;
        $tools = implode(",", $toolsall);

        $data->user_id = session()->get('user.id');
        $data->category = $category;
        $data->subcategory = $subcategory;
        $data->tools = $tools;
        $data->computer_name = $request->computer_name;
        $data->details = $details;
        $data->process = 'Not Process';
        $data->status = '1';
        $successData = $data->save();

        //Last Complain Number
        $compNumber = HardComplian::orderBy('id', 'desc')->select('id')->first();

        $mailData = (object) array(
            'compNumber' => $compNumber->id,
            'name' => session()->get('user.name'),
            'department' => session()->get('user.department'),
            'bu_location' => session()->get('user.bu_location'),
            'category' => $category,
            'subcategory' => $subcategory,
            'details' => $details
        );

        //Send Mail
        Mail::to(['it.support@cpbangladesh.com'])->send(new HardComplainSubmitMail($mailData));

        if (Mail::failures()) {
            $notification = array(
                'title' => 'Error',
                'messege' => 'Email Not Send',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        } elseif($successData) {
            $notification = array(
                'big-title' => 'Successfully, Your Complain Number:  '. $compNumber->id,
                'big-alert-type' => 'success'
            );
            return Redirect()->route('user.cms.dashboard')->with($notification);
        } else {
            $notification = array(
                'big-title' => 'Error !! Somthing Going Wrong',
                'big-alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
    }

    //App Complain History
    public function AppComplainHistory(){
        $allData = AppComplain::where('user_id', session()->get('user.id'))
            ->orderBy('id', 'desc')
            ->get();
        //dd($allData);
        return view('user.cms.app-history')->with('allData', $allData);
    }

    //Hard Complain History
    public function HardComplainHistory()
    {
        $allData = HardComplian::where('user_id', session()->get('user.id'))
            ->orderBy('id', 'desc')
            ->get();
        //dd($allData);
        return view('user.cms.hard-history')->with('allData', $allData);
    }

    //App Complain Remarks
    public function AppComplainRemarks(Request $request){
        $id = $request->get('id');
        if ($id) {
            $data = AppRemarks::where('comp_id', $id)
                ->get();
            return response()->json($data);
        }
    }

    //Hard Complain Remarks
    public function HardComplainRemarks(Request $request)
    {
        $id = $request->get('id');



        if ($id) {

            $delivery = $request->get('delivery');

            if( $delivery == 'Delivered')
            {
                $delivery = HardDelievery::where('comp_id', $id)->first();
                $remarks = HardRemarks::where('comp_id', $id)->get();
                return response()->json(['remarks' => $remarks, 'delivery' => $delivery]);

            }
            else
            {

                $delivery = 'NoData';
                $remarks = HardRemarks::where('comp_id', $id)->get();
                return response()->json(['remarks' => $remarks, 'delivery' => $delivery]);

            }

        }
    }

    //App Complain Cancel
    public function AppComplainCancel($id){
        $data = AppComplain::findOrFail($id);
        $data->status = 0;
        $successData = $data->save();

         if ($successData) {
            $notification = array(
                'big-title' => 'Successfully, Your Complain Canceled',
                'big-alert-type' => 'success'
            );
            return Redirect()->route('user.app.complain.history')->with($notification);
        } else {
            $notification = array(
                'big-title' => 'Error !! Somthing Going Wrong',
                'big-alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
    }

    //Hard Complain Cancel
    public function HardComplainCancel($id)
    {
        $data = HardComplian::findOrFail($id);
        $data->status = 0;
        $successData = $data->save();

        if ($successData) {
            $notification = array(
                'big-title' => 'Successfully, Your Complain Canceled',
                'big-alert-type' => 'success'
            );
            return Redirect()->route('user.hard.complain.history')->with($notification);
        } else {
            $notification = array(
                'big-title' => 'Error !! Somthing Going Wrong',
                'big-alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
    }

}
