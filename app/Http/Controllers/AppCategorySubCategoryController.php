<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\AppCategory;
use App\AppSubCategory;
use DB;

class AppCategorySubCategoryController extends Controller
{
    //Category
    public function AllCategory(){

        $allData = AppCategory::orderBy('id', 'desc')->get();
        return view('admin.application.category')->with('allData', $allData);
    }

    //Category Insert
    public function Insert(Request $request){

        $data = new AppCategory();

        // Another Way to insert records
        $successData = $data->create($request->all());

        if ($successData) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'Data Inserted',
                'alert-type' => 'success'
            );
            return Redirect()->route('all.app.category')->with($notification);
        } else {
            $notification = array(
                'title' => 'Error',
                'messege' => 'Somthing Going Wrong',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
    }


    //Category Delete data
    public function Delete($id){
        $data = AppCategory::find($id);
        //Delete from Database
        $success = $data->delete();

        if ($success) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'Data Deleted',
                'alert-type' => 'success'
            );
            return Redirect()->route('all.app.category')->with($notification);
        } else {
            $notification = array(
                'title' => 'Error',
                'messege' => 'Somthing Going Wrong',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
    }


    //Category Update
    public function Update(Request $request){
        $id = request('id');
        $data = AppCategory::find($id);

        // Another Way to update records
        $successData = $data->update($request->all());

        if ($successData) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'Data updated',
                'alert-type' => 'info'
            );
            return Redirect()->route('all.app.category')->with($notification);
        } else {
            $notification = array(
                'title' => 'Error',
                'messege' => 'Somthing Going Wrong',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
    }


    //SubCategory
    public function AllSubCategory(){

        $allData = DB::table('app_categories')
            ->join('app_sub_categories', 'app_sub_categories.cat_id', '=', 'app_categories.id')
            ->orderBy('app_sub_categories.id', 'desc')
            ->select('app_sub_categories.*', 'app_categories.category')
            ->get();

        $categoryData =  AppCategory::orderBy('category')->get();

        return view('admin.application.subcategory')->with('allData', $allData)->with('categoryData', $categoryData);
    }

    //SubCategory Insert
    public function InsertSubcategory(Request $request){

        $data = new AppSubCategory();

        // Another Way to insert records
        $successData = $data->create($request->all());

        if ($successData) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'Data Inserted',
                'alert-type' => 'success'
            );
            return Redirect()->route('all.app.subcategory')->with($notification);
        } else {
            $notification = array(
                'title' => 'Error',
                'messege' => 'Somthing Going Wrong',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
    }


    //SubCategory Update
    public function UpdateSubcategory(Request $request)
    {
        $id = request('id');
        $data = AppSubCategory::find($id);

        // Another Way to update records
        $successData = $data->update($request->all());

        if ($successData) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'Data updated',
                'alert-type' => 'info'
            );
            return Redirect()->route('all.app.subcategory')->with($notification);
        } else {
            $notification = array(
                'title' => 'Error',
                'messege' => 'Somthing Going Wrong',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
    }

    //SubCategory Delete data
    public function DeleteSubcategory($id)
    {
        $data = AppSubCategory::find($id);
        //Delete from Database
        $success = $data->delete();

        if ($success) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'Data Deleted',
                'alert-type' => 'success'
            );
            return Redirect()->route('all.app.subcategory')->with($notification);
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
