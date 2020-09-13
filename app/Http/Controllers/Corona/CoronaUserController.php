<?php

namespace App\Http\Controllers\Corona;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Corona\CoronaUser;
use DataTables;
use Validator;
use App\Department;

class CoronaUserController extends Controller
{
    //All Data
    public function Dashboard(){

        $departments = Department::orderBy('dept_name')->get();

        if(request()->ajax())
        {
            $data = CoronaUser::latest('id');

            //dd($data);

            return DataTables::of($data)

                    ->addColumn('action', function($data){

                        $button = '';
                        if($data->status == 1){
                            $button .= '<button type="button" id="'.$data->id.'" makeValue="0" class="status btn btn-success btn-sm mr-1" >Active</button>';
                        }else{
                            $button .= '<button type="button" id="'.$data->id.'" makeValue="1" class="status btn btn-warning btn-sm" >Inactive</button>';
                        }


                        $button .= '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm mr-1" >Edit</button>';
                        $button .= '<button type="button" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';

                        return $button;
                    })

                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin.corona.all-user', compact('departments'));

    }

    //insert
    public function DataStore(Request $request)
    {
        $rules = array(
            'id_number'    =>  'required|unique:corona_users,id_number|min:3|max:20',
            'name'    =>  'required|max:50',
            'department'    =>  'required',
            'remarks'    =>  'nullable|max:1000',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        else{

            $id_number = strtoupper(preg_replace('/\s+/', '', $request->id_number));

            $form_data = array(
                'id_number'   =>  $id_number,
                'name'        =>  $request->name ,
                'department'  =>  $request->department,
                'remarks'  =>  $request->remarks ,
            );

            $success= CoronaUser::create($form_data);

            if($success){
                return response()->json(['success' => 'Data is successfully added']);
            }else{
                return response()->json(['success' => 'Something going wrong !!']);
            }
        }



    }

     //Edit
    public function DataEdit($id){

        // return response()->json(['result' => $id]);

        if(request()->ajax())
        {
            $data = CoronaUser::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    //Update
    public function DataUpdate(Request $request){

        $id = $request->hidden_id;

        $rules = array(
            'id_number'    =>  'required|min:3|max:50|unique:corona_users,id_number,'.$id,
            'name'    =>  'required|max:50',
            'department'    =>  'required',
            'remarks'    =>  'nullable|max:1000',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        else{

            $id_number = strtoupper(preg_replace('/\s+/', '', $request->id_number));


            $form_data = array(
                'id_number'   =>  $id_number,
                'name'        =>  $request->name ,
                'department'  =>  $request->department,
                'remarks'  =>  $request->remarks ,
            );


            $success = CoronaUser::whereId($id)->update($form_data);


            if($success){
                return response()->json(['success' => 'Data is successfully updated']);
            }else{
                return response()->json(['success' => 'Something going wrong !!']);
            }
        }



    }



    //Delete
    public function DataDelete($id){
        $data = CoronaUser::findOrFail($id);
        $success = $data->delete();
        if($success){
            return 'ok';
        }else{
            return 'error';
        }

    }

    //Status Change
    public function Status($id, $val){

        $data = CoronaUser::find($id);

        $data->status = $val;
        $success = $data->save();


        if($success){
            return 'ok';
        }else{
            return 'error';
        }

    }






}
