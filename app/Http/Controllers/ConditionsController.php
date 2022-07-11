<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Condition;

class ConditionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('conditions.view-conditions');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getConditions()
    {
        $condition = Condition::all();
        $forDtt['data'] = $condition;
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
            'condition_co' => 'required|regex:/^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/',
        ];
        $messagges = [
            'condition_co.required' => 'The name field is required',
            'condition_co.regex' => 'The name field only accepts letters',
        ];

        $validator = Validator::make($input,$rules,$messagges);

        if ($validator->fails()) {
            return redirect()->route('conditions')->withErrors($validator);
        }else{
            $verify = Condition::where('condition_co',$request->input('condition_co'))->first();
            if ($verify){
                return redirect()->route('conditions')->withErrors('¡There is a condition with that name!');
            }else{
                $saved = Condition::create($input);
                if ($saved){
                    return redirect()->route('conditions')->with('flash','¡The condition has been successfully saved!');
                }else{
                    return redirect()->route('conditions')->withErrors();
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
    public function consultCondition($id)
    {
        $condition = Condition::find($id);
        return response()->json($condition,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateCondition(Request $request, $id)
    {
        $input = $request->all();
        $rules = [
            'condition_co' => 'required|regex:/^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/',
        ];
        $messagges = [
            'condition_co.required' => 'The name field is required',
            'condition_co.regex' => 'The name field only accepts letters',
        ];

        $validator = Validator::make($input,$rules,$messagges)->validate();

        $verify = Condition::where('condition_co',$request->input('condition_co'))->where('id','!=',$id)->first();
        if ($verify){
            return response()->json(0);
        }else{
            $condition = Condition::find($id);
            if ($condition){
                $condition->condition_co = $request->input('condition_co');
                $condition->save();
            }
            return response()->json(1);
        }
    }
}
