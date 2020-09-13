<?php

namespace App\Http\Controllers\Corona;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Corona\CoronaCheckpoint;
use DataTables;
use Validator;

class CheckpointController extends Controller
{
    //All Data
    public function Dashboard(){



        if(request()->ajax())
        {
            $data = CoronaCheckpoint::latest('id');

            //dd($data);

            return DataTables::of($data)

                    ->addColumn('action', function($data){

                        $button = '';

                        $button .= '<button type="button" id="'.$data->id.'" class="edit btn btn-primary btn-sm mr-1" >Edit</button>';
                        $button .= '<button type="button" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';

                        return $button;
                    })

                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin.corona.checkpoint');

    }

    //insert
    public function DataStore(Request $request)
    {
        $rules = array(
            'name'    =>  'required|unique:corona_checkpoints,name|min:3|max:20',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        else{

            $form_data = array(
                'name'        =>  $request->name,
            );

            $success= CoronaCheckpoint::create($form_data);

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
            $data = CoronaCheckpoint::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    //Update
    public function DataUpdate(Request $request){

        $id = $request->hidden_id;

        $rules = array(
            'name'    =>  'required|min:3|max:50|unique:corona_checkpoints,name,'.$id,
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        else{

            $id_number = strtoupper(preg_replace('/\s+/', '', $request->id_number));

            $form_data = array(
                'name'        =>  $request->name,
            );


            $success = CoronaCheckpoint::whereId($id)->update($form_data);


            if($success){
                return response()->json(['success' => 'Data is successfully updated']);
            }else{
                return response()->json(['success' => 'Something going wrong !!']);
            }
        }



    }



    //Delete
    public function DataDelete($id){
        $data = CoronaCheckpoint::findOrFail($id);
        $success = $data->delete();
        if($success){
            return 'ok';
        }else{
            return 'error';
        }

    }



}

