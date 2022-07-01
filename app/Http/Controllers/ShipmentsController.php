<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Shipment;

class ShipmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('shipments.view-shipments');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getShipments()
    {
        $shipments = Shipment::all();
        $forDtt['data'] = $shipments;
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
            'shipment_sh' => 'required|regex:/^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/',
        ];
        $messagges = [
            'shipment_sh.required' => 'The name field is required',
            'shipment_sh.regex' => 'The name field only accepts letters',
        ];

        $validator = Validator::make($input,$rules,$messagges);

        if ($validator->fails()) {
            return redirect()->route('shipments')->withErrors($validator);
        }else{
            $verify = Shipment::where('shipment_sh',$request->input('shipment_sh'))->get()->first();
            if ($verify){
                return redirect()->route('shipments')->withErrors('¡There is a shipment with that name!');
            }else{
                $saved = Shipment::create($input);
                if ($saved){
                    return redirect()->route('shipments')->with('flash','¡The shipment has been successfully saved!');
                }else{
                    return redirect()->route('shipments')->withErrors();
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
    public function consultShipment($id)
    {
        $shipment = Shipment::find($id);
        return response()->json($shipment,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateShipment(Request $request, $id)
    {
        $input = $request->all();
        $rules = [
            'shipment_sh' => 'required|regex:/^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/',
        ];
        $messagges = [
            'shipment_sh.required' => 'The name field is required',
            'shipment_sh.regex' => 'The name field only accepts letters',
        ];

        $validator = Validator::make($input,$rules,$messagges)->validate();

        $verify = Shipment::where('shipment_sh',$request->input('shipment_sh'))->where('id','!=',$id)->get()->first();
        if ($verify){
            return response()->json(0);
        }else{
            $shipment = Shipment::find($id);
            if ($shipment){
                $shipment->shipment_sh = $request->input('shipment_sh');
                $shipment->save();
            }
            return response()->json(1);
        }
    }
}
