<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Movements\RegisterMovementRequest;
use App\Models\Movement;
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
        return view('movements.movements', compact('conditions','status','customers','shipments','users'));
    }

    public function store(Request $request){
        $saved = Movement::create($request->all());
        if ($saved){
            if(empty($request->movement_id)){
                return redirect('/movements/movements')->with('flash','¡The movement has been successfully saved!');
            }else{
                return redirect('/movements/movements')->with('flash','¡The movement has been successfully closed!');
            }
        }else{
            return view('home');
        }
    }

    public function getMovements(){
        $movements = Movement::join('customers','customers.id','=','movements.customer_id')
                               ->join('conditions','conditions.id','=','movements.condition_id')
                               ->join('status','status.id','=','movements.status_id')
                               ->where('movements.movement_id','=',NULL)
                               ->select('customers.name_cu','conditions.condition_co','status.status_st','movements.*')
                               ->get();
        $forDtt['data'] = $movements;
        return response()->json($forDtt, 200);
    }

    public function viewMovement($idMovement){
        $movement = Movement::join('customers','customers.id','=','movements.customer_id')
                            ->join('conditions','conditions.id','=','movements.condition_id')
                            ->join('status','status.id','=','movements.status_id')
                            ->join('movements','movements.id','=','movements.movement_id')
                            ->where('movements.id','=',$idMovement)
                            ->select('customers.*','conditions.condition_co','status.status_st','movements.*')
                            ->get();
        
        return response()->json($movement, 200);
    }

    public function updateMovement(Request $request){
        $movement = Movement::find($request->id);
        if ($movement){
            $movement->date_mo = $request->date_mo;
            $movement->item_mo = $request->item_mo;
            $movement->quanty_mo = $request->quanty_mo;
            $movement->qty_boxes_mo = $request->qty_boxes_mo;
            $movement->ubication_mo = $request->ubication_mo;
            $movement->observation_mo = $request->observation_mo;
            $movement->customer_id = $request->customer_id;
            $movement->condition_id = $request->condition_id;
            $movement->status_id = $request->status_id;
            $movement->user_id = $request->user_id;
            $movement->save();
        }
    }

    public function deleteMovement($idMovement){
        Movement::destroy($idMovement);
    }
}
