<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\HardSubCategory;
use App\HardCategory;

class HardCategorySubcategoryController extends Controller
{
    //Category
    public function AllCategory()
    {
        $allData = HardCategory::orderBy('id', 'desc')->get();
        return view('admin.hardware.category')->with('allData', $allData);
    }

    //Category Insert
    public function Insert(Request $request)
    {

        $data = new HardCategory();

        // Another Way to insert records
        $successData = $data->create($request->all());

        if ($successData) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'Data Inserted',
                'alert-type' => 'success'
            );
            return Redirect()->route('all.hard.category')->with($notification);
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
    public function Delete($id)
    {
        $data = HardCategory::find($id);
        //Delete from Database
        $success = $data->delete();

        if ($success) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'Data Deleted',
                'alert-type' => 'success'
            );
            return Redirect()->route('all.hard.category')->with($notification);
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
    public function Update(Request $request)
    {
        $id = request('id');
        $data = HardCategory::find($id);

        // Another Way to update records
        $successData = $data->update($request->all());

        if ($successData) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'Data updated',
                'alert-type' => 'info'
            );
            return Redirect()->route('all.hard.category')->with($notification);
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
    public function AllSubCategory()
    {

        $allData = DB::table('hard_categories')
            ->join('hard_sub_categories', 'hard_sub_categories.cat_id', '=', 'hard_categories.id')
            ->orderBy('hard_sub_categories.id', 'desc')
            ->select('hard_sub_categories.*', 'hard_categories.category')
            ->get();

        $categoryData =  HardCategory::orderBy('category')->get();

        return view('admin.hardware.subcategory')->with('allData', $allData)->with('categoryData', $categoryData);
    }

    //SubCategory Insert
    public function InsertSubcategory(Request $request)
    {

        $data = new HardSubCategory();

        // Another Way to insert records
        $successData = $data->create($request->all());

        if ($successData) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'Data Inserted',
                'alert-type' => 'success'
            );
            return Redirect()->route('all.hard.subcategory')->with($notification);
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
        $data = HardSubCategory::find($id);

        // Another Way to update records
        $successData = $data->update($request->all());

        if ($successData) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'Data updated',
                'alert-type' => 'info'
            );
            return Redirect()->route('all.hard.subcategory')->with($notification);
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
        $data = HardSubCategory::find($id);
        //Delete from Database
        $success = $data->delete();

        if ($success) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'Data Deleted',
                'alert-type' => 'success'
            );
            return Redirect()->route('all.hard.subcategory')->with($notification);
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
