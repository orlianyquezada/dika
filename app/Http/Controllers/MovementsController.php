<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Movements\RegisterMovementRequest;
use App\Models\InputMovement;
use App\Models\Customer;
use App\User;
use DB;

class MovementsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $conditions =  DB::table('conditions')->get();
        $status =  DB::table('status')->get();
        $customers = Customer::all();
        $shipments = DB::table('shipments')->get();
        $users = User::all();
        return view('movements.view-movements', compact('conditions','status','customers','shipments','users'));
    }

    public function store(Request $request){
        $saved = InputMovement::create($request->all());
        if ($saved){
            return redirect()->route('movements')->with('flash','¡The movement has been successfully saved!');
        }else{
            return view('home');
        }
    }

    public function getMovements(){
        $movements = InputMovement::join('customers','customers.id','=','input_movements.customer_id')
                                    ->join('status','status.id','=','input_movements.status_id')
                                    ->select('customers.name_cu','status.status_st','input_movements.*')
                                    ->get();
        $forDtt['data'] = $movements;
        return response()->json($forDtt, 200);
    }

    public function viewMovement($idMovement){
        $movement = InputMovement::join('customers','customers.id','=','input_movements.customer_id')
                                ->join('conditions','conditions.id','=','input_movements.condition_id')
                                ->join('status','status.id','=','input_movements.status_id')
                                ->where('input_movements.id','=',$idMovement)
                                ->select('customers.*','conditions.condition_co','status.status_st','input_movements.*')
                                ->get();
        return response()->json($movement, 200);
    }

    public function updateMovement(Request $request){
        $movement = InputMovement::find($request->input('id'));
        if ($movement){
            $movement->datetime_inm = $request->input('datetime_inm');
            $movement->item_inm = $request->input('item_inm');
            $movement->quanty_inm = $request->input('quanty_inm');
            $movement->qty_boxes_inm = $request->input('qty_boxes_inm');
            $movement->ubication_inm = $request->input('ubication_inm');
            $movement->observation_inm = $request->input('observation_inm');
            $movement->customer_id = $request->input('customer_id');
            $movement->condition_id = $request->input('condition_id');
            $movement->status_id = $request->input('status_id');
            $movement->user_id = $request->input('user_id');
            $movement->save();
        }
    }

    public function deleteMovement($idMovement){
        $movement = InputMovement::find($idMovement);
        $movement->delete();
    }
}
