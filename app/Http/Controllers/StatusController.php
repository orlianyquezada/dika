<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Status;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('status.view-status');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getStatus()
    {
        $status = Status::all();
        $forDtt['data'] = $status;
        return response()->json($forDtt, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $rules = [
            'status_st' => 'required|regex:/^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/',
        ];
        $messagges = [
            'status_st.required' => 'The name field is required',
            'status_st.regex' => 'The name field only accepts letters',
        ];

        $validator = Validator::make($input,$rules,$messagges);

        if ($validator->fails()) {
            return redirect()->route('status')->withErrors($validator);
        }else{
            $verify = Status::where('status_st',$request->input('status_st'))->get()->first();
            if ($verify){
                return redirect()->route('status')->withErrors('¡There is a status with that name!');
            }else{
                $saved = Status::create($input);
                if ($saved){
                    return redirect()->route('status')->with('flash','¡The status has been successfully saved!');
                }else{
                    return redirect()->route('status')->withErrors();
                }
            }
        }
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function consultStatus($id)
    {
        $status = Status::find($id);
        return response()->json($status,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        $input = $request->all();
        $rules = [
            'status_st' => 'required|regex:/^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/',
        ];
        $messagges = [
            'status_st.required' => 'The name field is required',
            'status_st.regex' => 'The name field only accepts letters',
        ];

        $validator = Validator::make($input,$rules,$messagges)->validate();

        $verify = Status::where('status_st',$request->input('status_st'))->where('id','!=',$id)->get()->first();
        if ($verify){
            return response()->json(0);
        }else{
            $status = Status::find($id);
            if ($status){
                $status->status_st = $request->input('status_st');
                $status->save();
            }
            return response()->json(1);
        }
    }
}
