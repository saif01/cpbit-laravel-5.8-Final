<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\HardCategory;
use App\InvNewProduct;
use DB;
use App\InvOldProduct;
use App\BuLocation;
use App\Department;
use App\Operation;
use Carbon\Carbon;

class InventoryController extends Controller
{

    public function Index(){

        $chartData = DB::table('inv_new_products')
            ->select('category',  DB::raw('count(*) as total'))
            ->groupBy('category')
            ->get();

        $totalProduct = InvOldProduct::count();
        $totalRunning = InvOldProduct::where('type', '=', 'Running')->count();
        $totalDamaged = InvOldProduct::where('type', '=', 'Damaged')->count();
        $newProduct   = InvNewProduct::count();

        //dd($chartData); 

        return view('admin.inventory.index')
            ->with('totalRunning', $totalRunning)
            ->with('totalDamaged', $totalDamaged)
            ->with('newProduct', $newProduct)
            ->with('chartData', $chartData)
            ->with('totalProduct', $totalProduct );
    }

    //Count New Product
    public function NewProduct(){
      return  InvNewProduct::whereNull('give_st')->orderBy('id', 'desc')->count();
    }

    //Add New Product
    public function AddNew(){
        $hardCategoryData = HardCategory::orderBy('category')->get();
        return view('admin.inventory.add-new')->with('hardCategoryData', $hardCategoryData);
    }

    //Add New Edit
    public function AddNewEdit($id){
        $data = InvNewProduct::findOrFail($id);
        $hardCategoryData = HardCategory::orderBy('category')->get();
        return view('admin.inventory.add-new-edit')
            ->with('hardCategoryData', $hardCategoryData)
            ->with('data', $data);
    }

    //All New
    public function AllNew(){
        $allData = InvNewProduct::whereNull('give_st')->orderBy('id', 'desc')->get();
        $buLocationData = BuLocation::orderBy('bu_location')->get();
        $deptData = Department::orderBy('dept_name')->get();
        $operationData = Operation::orderBy('operation')->get();

        return view('admin.inventory.all-new')
            ->with('buLocationData', $buLocationData)
            ->with('deptData', $deptData)
            ->with('operationData', $operationData)
            ->with('allData', $allData);
    }

    //Delete New
    public function NewDelete($id){
        $data = InvNewProduct::find($id);
        //Document Path
        $document_path = $data->document;
        if (file_exists($document_path)) {
            //Delete Existing File
            @unlink($document_path);
        }
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

    //All Given
    public function AllGiven()
    {
        $allData = InvNewProduct::whereNotNull('give_st')->orderBy('id', 'desc')->get();
        return view('admin.inventory.all-given')->with('allData', $allData);
    }

    //All Warranty
    public function AllWarranty()
    {
        $allData = InvNewProduct::whereNotNull('warranty')->orderBy('id', 'desc')->get();
        return view('admin.inventory.all-warranty')->with('allData', $allData);
    }

    //All Warranty Available
    public function AllWarrantyAvailable()
    {
        $currentdate = date('Y-m-d');
        $allData = InvNewProduct::whereNotNull('warranty')
            ->where('warranty', '>=', $currentdate)
            ->orderBy('id', 'desc')
            ->get();
        return view('admin.inventory.all-warranty-available')->with('allData', $allData);
    }

    //All Warranty Expired
    public function AllWarrantyExpired()
    {
        $currentdate = date('Y-m-d');
        $allData = InvNewProduct::whereNotNull('warranty')
            ->where('warranty', '<=', $currentdate)
            ->orderBy('id', 'desc')
            ->get();
        return view('admin.inventory.all-warranty-expired')->with('allData', $allData);
    }


    //Add New Action
    public function AddNewAction(Request $request){

        $validateData = $request->validate([
            'remarks' => 'required | max:2000',
            'document' => 'max:3000 | file | mimes:ppt,pptx,jpg,jpeg,bmp,png,doc,docx,csv,rtf,xlsx,xls,txt,pdf',
        ]);

        $data = new InvNewProduct();

        $document = $request->file('document');
        if ($document) {
            $document_name = str_random(5);
            $ext = strtolower($document->getClientOriginalExtension());
            $document_full_name = $document_name . '.' . $ext;
            $upload_path = 'public/images/inventory/';
            $document_url = $upload_path . $document_full_name;
            $successImg = $document->move($upload_path, $document_full_name);
            $data->document = $document_url;
        }

        $wrr_st = $request->warr_st;
        $purchase = $request->purchase;
        if($wrr_st == 1){
            $dt_st = strtotime($purchase);
            $month_count = $request->month_type * $request->month_data;
           $data->warranty = date("Y-m-d", strtotime("+$month_count month", $dt_st));
        }

        $sub_id = $request->sub_id;
        //Category Subcategory name
        $CatSubcat = DB::table('hard_sub_categories')
            ->join('hard_categories', 'hard_categories.id', '=', 'hard_sub_categories.cat_id')
            ->where('hard_sub_categories.id', '=', $sub_id)
            ->select('hard_sub_categories.subcategory', 'hard_categories.category')
            ->first();

        $data->category = $CatSubcat->category;
        $data->subcategory = $CatSubcat->subcategory;
        $data->name = $request->name;
        $data->serial = $request->serial;
        $data->purchase = $request->purchase;
        $data->remarks = $request->remarks;
        $successData= $data->save();

        if ($successData) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'Data Added',
                'alert-type' => 'success'
            );
            return Redirect()->route('inv.all.new')->with($notification);
        } else {
            $notification = array(
                'title' => 'Error',
                'messege' => 'Somthing Going Wrong',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
    }

    //New  Edit Action
    public function AddEditAction(Request $request, $id)
    {

       $validateData = $request->validate([
            'remarks' => 'required | max:2000',
            'document' => 'max:3000 | file | mimes:ppt,pptx,jpg,jpeg,bmp,png,doc,docx,csv,rtf,xlsx,xls,txt,pdf',
        ]);

        $data = InvNewProduct::find($id);

        $document = $request->file('document');
        if ($document) {
            if ($document) {
                $document_path = $data->document;
                if ($document_path) {
                    @unlink($document_path);
                }
            }
            $document_name = str_random(5);
            $ext = strtolower($document->getClientOriginalExtension());
            $document_full_name = $document_name . '.' . $ext;
            $upload_path = 'public/images/inventory/';
            $document_url = $upload_path . $document_full_name;
            $successImg = $document->move($upload_path, $document_full_name);
            $data->document = $document_url;
        }


        $purchase = $request->purchase;
        $wrr_st = $request->warr_st;
        if(isset($request->warr_st)){
            if ($wrr_st == 1) {
                $dt_st = strtotime($purchase);
                $month_count = $request->month_type * $request->month_data;
                $data->warranty = date("Y-m-d", strtotime("+$month_count month", $dt_st));
            }
            elseif ($wrr_st == 0) {
                $data->warranty = null;
            }
        }


        $sub_id = $request->sub_id;

        if( !empty($sub_id) ){
                //Category Subcategory name
                $CatSubcat = DB::table('hard_sub_categories')
                    ->join('hard_categories', 'hard_categories.id', '=', 'hard_sub_categories.cat_id')
                    ->where('hard_sub_categories.id', '=', $sub_id)
                    ->select('hard_sub_categories.subcategory', 'hard_categories.category')
                    ->first();

                $data->category = $CatSubcat->category;
                $data->subcategory = $CatSubcat->subcategory;
        }

        $data->name = $request->name;
        $data->serial = $request->serial;
        $data->purchase = $request->purchase;
        $data->remarks = $request->remarks;
        $successData = $data->save();

        if ($successData) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'Data Updated',
                'alert-type' => 'success'
            );
            return Redirect()->route('inv.all.new')->with($notification);
        } else {
            $notification = array(
                'title' => 'Error',
                'messege' => 'Somthing Going Wrong',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
    }


    //Add Old Preoduct
    public function AddOld(){
        $hardCategoryData = HardCategory::orderBy('category')->get();
        $buLocationData = BuLocation::orderBy('bu_location')->get();
        $deptData = Department::orderBy('dept_name')->get();
        $operationData = Operation::orderBy('operation')->get();
        return view('admin.inventory.add-old')
            ->with('hardCategoryData', $hardCategoryData)
            ->with('buLocationData', $buLocationData)
            ->with('operationData', $operationData)
            ->with('deptData', $deptData);
    }

    //Edit Old Preoduct
    public function EditOld($id){
        $hardCategoryData = HardCategory::orderBy('category')->get();
        $buLocationData = BuLocation::orderBy('bu_location')->get();
        $deptData = Department::orderBy('dept_name')->get();
        $operationData = Operation::orderBy('operation')->get();

        $data = InvOldProduct::findOrFail($id);


        return view('admin.inventory.add-old-edit')
            ->with('hardCategoryData', $hardCategoryData)
            ->with('buLocationData', $buLocationData)
            ->with('deptData', $deptData)
            ->with('operationData', $operationData)
            ->with('data', $data);
    }

    //Add Old Action
    public function AddOldAction(Request $request)
    {

        $data = new InvOldProduct();

        $sub_id = $request->sub_id;
        //Category Subcategory name
        $CatSubcat = DB::table('hard_sub_categories')
            ->join('hard_categories', 'hard_categories.id', '=', 'hard_sub_categories.cat_id')
            ->where('hard_sub_categories.id', '=', $sub_id)
            ->select('hard_sub_categories.subcategory', 'hard_categories.category')
            ->first();

        $data->category = $CatSubcat->category;
        $data->subcategory = $CatSubcat->subcategory;
        $data->bu_location = $request->bu_location;
        $data->operation = $request->operation;
        $data->department = $request->department;
        $data->name = $request->name;
        $data->serial = $request->serial;
        $data->remarks = $request->remarks;
        $data->type = $request->type;
        $successData = $data->save();

        if ($successData) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'Data Added',
                'alert-type' => 'success'
            );
            return Redirect()->route('inv.all.old')->with($notification);
        } else {
            $notification = array(
                'title' => 'Error',
                'messege' => 'Somthing Going Wrong',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
    }

     //Edit Old Action
    public function EditOldAction(Request $request, $id)
    {

        $data = InvOldProduct::findOrFail($id);

        $sub_id = $request->sub_id;
        if( !empty($sub_id) ){
                //Category Subcategory name
                $CatSubcat = DB::table('hard_sub_categories')
                    ->join('hard_categories', 'hard_categories.id', '=', 'hard_sub_categories.cat_id')
                    ->where('hard_sub_categories.id', '=', $sub_id)
                    ->select('hard_sub_categories.subcategory', 'hard_categories.category')
                    ->first();
                $data->category = $CatSubcat->category;
                $data->subcategory = $CatSubcat->subcategory;
        }



        $data->bu_location = $request->bu_location;
        $data->operation = $request->operation;
        $data->department = $request->department;
        $data->name = $request->name;
        $data->serial = $request->serial;
        $data->remarks = $request->remarks;
        $data->type = $request->type;
        $data->updated_at = Carbon::now();
        $successData = $data->save();

        if ($successData) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'Data Updated',
                'alert-type' => 'info'
            );
            return Redirect()->route('inv.all.old')->with($notification);
        } else {
            $notification = array(
                'title' => 'Error',
                'messege' => 'Somthing Going Wrong',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
    }

    //Give New Product
    public function GiveNewAction(Request $request)
    {

        $id = $request->new_pro_id;

        $data = new InvOldProduct();
        $data->new_pro_id = $id;
        $data->category = $request->category;
        $data->subcategory = $request->subcategory;
        $data->bu_location = $request->bu_location;
        $data->operation = $request->operation;
        $data->department = $request->department;
        $data->name = $request->name;
        $data->serial = $request->serial;
        $data->type = 'Running';
        $data->rec_name = $request->rec_name;
        $data->rec_position = $request->rec_position;
        $data->rec_contact = $request->rec_contact;
        $data->remarks = $request->remarks;
        $successData = $data->save();

        $data2 =InvNewProduct::findOrFail($id);
        $data2->give_st = 1;
        $successData2 = $data2->save();

        if ($successData && $successData2) {
            $notification = array(
                'title' => 'Successfully',
                'messege' => 'Data Updated',
                'alert-type' => 'success'
            );
            return Redirect()->route('inv.all.old')->with($notification);
        } else {
            $notification = array(
                'title' => 'Error',
                'messege' => 'Somthing Going Wrong',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
    }

    //All Old Product
    public function AllOld()
    {
        $allData = InvOldProduct::orderBy('id', 'desc')->get();
        $hardCategoryData = HardCategory::orderBy('category')->get();
        $buLocationData = BuLocation::orderBy('bu_location')->get();
        $deptData = Department::orderBy('dept_name')->get();
        return view('admin.inventory.all-old')
            ->with('hardCategoryData', $hardCategoryData)
            ->with('buLocationData', $buLocationData)
            ->with('deptData', $deptData)
            ->with('allData', $allData);
    }

    //All Running Product
    public function AllOldRunning()
    {
        $allData = InvOldProduct::orderBy('id', 'desc')
            ->where('type', '=', 'Running')
            ->get();
        return view('admin.inventory.all-old-running')->with('allData', $allData);
    }

    //All Damaged Product
    public function AllOldDamaged()
    {
        $allData = InvOldProduct::orderBy('id', 'desc')
            ->where('type', '=', 'Damaged')
            ->get();
        return view('admin.inventory.all-old-damaged')->with('allData', $allData);
    }


    //All Old Search Product
    public function OldSearchAction(Request $request)
    {
        $category = $request->category;
        $bu_location = $request->bu_location;
        $department = $request->department;

        if(!empty($category) && !empty($bu_location) && !empty($department)){

            $allData = InvOldProduct::where('category', '=', $category)
                ->where('bu_location', '=', $bu_location)
                ->where('department', '=', $department)
                ->orderBy('id', 'desc')->get();
        }
        elseif (!empty($category) && !empty($bu_location) && empty($department))
        {
            $allData = InvOldProduct::where('category', '=', $category)
                ->where('bu_location', '=', $bu_location)
                ->orderBy('id', 'desc')->get();
        }
        elseif (!empty($category) && empty($bu_location) && !empty($department))
        {
            $allData = InvOldProduct::orderBy('id', 'desc')
                ->where('category', '=', $category)
                ->where('department', '=', $department)
                ->get();
        }
        elseif (empty($category) && !empty($bu_location) && !empty($department))
        {
            $allData = InvOldProduct::orderBy('id', 'desc')
                ->where('bu_location', '=', $bu_location)
                ->where('department', '=', $department)
                ->get();
        }
        elseif (!empty($category) && !empty($bu_location) && empty($department))
        {
            $allData = InvOldProduct::orderBy('id', 'desc')
                ->where('category', '=', $category)
                ->where('bu_location', '=', $bu_location)
                ->get();
        }
        elseif (!empty($category) && empty($bu_location) && empty($department)) {
            $allData = InvOldProduct::orderBy('id', 'desc')
                ->where('category', '=', $category)
                ->get();
        } elseif (empty($category) && !empty($bu_location) && empty($department)) {
            $allData = InvOldProduct::orderBy('id', 'desc')
                ->where('bu_location', '=', $bu_location)
                ->get();
        } elseif (empty($category) && empty($bu_location) && !empty($department)) {
            $allData = InvOldProduct::orderBy('id', 'desc')
                ->where('department', '=', $department)
                ->get();
        }
        else{
            $allData = InvOldProduct::orderBy('id', 'desc')->get();
        }


        $hardCategoryData = HardCategory::orderBy('category')->get();
        $buLocationData = BuLocation::orderBy('bu_location')->get();
        $deptData = Department::orderBy('dept_name')->get();
        return view('admin.inventory.all-old')
            ->with('hardCategoryData', $hardCategoryData)
            ->with('buLocationData', $buLocationData)
            ->with('deptData', $deptData)
            ->with('srcTitle', 'srcTitle')
            ->with('allData', $allData);
    }

    //Old Data Details
    public function DetailsOld(Request $request){
        $id = $request->get('id');
        $data = InvOldProduct::find($id);
        return response()->json($data);
    }

    //Given Details
    public function GivenDetails(Request $request)
    {
        $id = $request->get('id');
        $data = InvOldProduct::where('new_pro_id', '=', $id)->first();
        // $data =DB::table('inv_old_products')
        //     ->where('new_pro_id', '=', '43');
        return response()->json($data);
    }

    //Single New Product Details
    public function SingleNewProduct(Request $request){
        $id = $request->get('id');
        return InvNewProduct::find($id);

    }

    //Operation List
    public function OperationList(){
        $data = Operation::orderBy('operation')->get();
        return $data;
    }

    //By Operation List Report
    public function OperationReport($op){

        $operation = $op;

        $allData = DB::table('inv_old_products')
            ->where('operation', '=', $op)
            ->select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->get();

        //dd($data);
        return view('admin.inventory.operation-report')
            ->with('allData', $allData)
            ->with('operation', $operation);
    }

}
