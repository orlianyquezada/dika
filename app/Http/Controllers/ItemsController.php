<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Item;
use App\Models\Customer;
use DB;

class ItemsController extends Controller
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
        $shipments = DB::table('shipments')->get();
        $users = DB::table('users')->get();
        $customers = Customer::all();
        return view('items.view-items',compact('conditions','status','customers','shipments','users'));
    }

    public function store(Request $request){
        $input = $request->all();
        $rules = [
            'datetime_it' => 'required|date',
            'item_it' => 'required',
            'quanty_it' => 'required|integer',
            'qty_boxes_it' => 'required|integer',
            'ubication_it' => 'required',
            'customer_id' => 'required|integer',
            'condition_id' => 'required|integer',
            'status_id' => 'required|integer',
            'user_id' => 'required|integer',
        ];
        $messagges = [
            'datetime_it.required' => 'The datetime field is required',
            'datetime_it.date' => 'The date field must be date-formatted',
            'item_it.required' => 'The item field is required',
            'quanty_it.required' => 'The quanty field is required',
            'quanty_it.integer' => 'The quanty field must have numbers',
            'qty_boxes_it.required' => 'The quanty boxes field is required',
            'qty_boxes_it.integer' => 'The quanty boxes field must have numbers',
            'ubication_it.required' => 'The ubication field is required',
            'customer_id.required' => 'The customer field is required',
            'customer_id.integer' => 'The customer field must have numbers',
            'condition_id.required' => 'The condition field is required',
            'condition_id.integer' => 'The condition field must have numbers',
            'status_id.required' => 'The status field is required',
            'status_id.integer' => 'The status field must have numbers',
            'user_id.required' => 'The user field is required',
            'user_id.integer' => 'The user field must have numbers'
        ];

        $validator = Validator::make($input,$rules,$messagges);

        if ($validator->fails()) {
            return redirect()->route('items')->withErrors($validator);
        }else{
            $saved = Item::create($request->all());
            if ($saved){
                return redirect()->route('items')->with('flash','¡The item has been successfully saved!');
            }else{
                return redirect()->route('items')->withErrors();
            }
        }
    }

    public function getItems(){
        $items = Item::join('customers','customers.id','=','items.customer_id')
                    ->join('status','status.id','=','items.status_id')
                    ->join('conditions','conditions.id','=','items.condition_id')
                    ->leftjoin('shipments','shipments.id','=','items.shipment_id')
                    ->select('customers.name_cu','status.status_st','conditions.condition_co','shipments.shipment_sh','items.*')
                    ->get();
        $forDtt['data'] = $items;
        return response()->json($forDtt, 200);
    }

    public function consultItem($idItem){
        $verify = Item::where('item_id',$idItem)->get()->first();
        if ($verify){
            $itemOpen = Item::join('customers','customers.id','=','items.customer_id')
                            ->join('conditions','conditions.id','=','items.condition_id')
                            ->join('status','status.id','=','items.status_id')
                            ->where('items.id','=',$idItem)
                            ->select('customers.*','conditions.condition_co','status.status_st','items.*')
                            ->get();
            $itemClose = Item::join('customers','customers.id','=','items.sub_customer_id')
                            ->join('conditions','conditions.id','=','items.condition_id')
                            ->join('status','status.id','=','items.status_id')
                            ->join('shipments','shipments.id','=','items.shipment_id')
                            ->join('users','users.id','=','items.employee_id')
                            ->where('items.item_id','=',$idItem)
                            ->select('customers.*','conditions.condition_co','status.status_st','shipments.shipment_sh','users.name','items.*')
                            ->get();
            return response()->json([$status,$itemOpen,$itemClose], 200);
        }else{
            $status ='open';
            $item = Item::join('customers','customers.id','=','items.customer_id')
                        ->join('conditions','conditions.id','=','items.condition_id')
                        ->join('status','status.id','=','items.status_id')
                        ->where('items.id','=',$idItem)
                        ->select('customers.*','conditions.condition_co','status.status_st','items.*')
                        ->get();
            return response()->json([$status,$item], 200);
        }
    }

    public function consultSubCustomers($idCustomer){
        return responsive()->json($idCustomer,200);
    }

    public function updateItem(Request $request){
        $date = $request->input('date');
        $time = $request->input('time');
        $concatDateTime = $date.' '.$time;
            $input = $request->all();
            $rules = [
                'date' => 'required|date',
                'time' => 'required|time',
                'item_it' => 'required',
                'quanty_it' => 'required|integer',
                'qty_boxes_it' => 'required|integer',
                'ubication_it' => 'required',
                'customer_id' => 'required|integer',
                'condition_id' => 'required|integer',
                'status_id' => 'required|integer',
                'user_id' => 'required|integer',
            ];
            $messagges = [
                'date.required' => 'The date field is required',
                'date.date' => 'The date field must be date-formatted',
                'time.required' => 'The time field is required',
                'time.date' => 'The time field must be time-formatted',
                'item_it.required' => 'The item field is required',
                'quanty_it.required' => 'The quanty field is required',
                'quanty_it.integer' => 'The quanty field must have numbers',
                'qty_boxes_it.required' => 'The quanty boxes field is required',
                'qty_boxes_it.integer' => 'The quanty boxes field must have numbers',
                'ubication_it.required' => 'The ubication field is required',
                'customer_id.required' => 'The customer field is required',
                'customer_id.integer' => 'The customer field must have numbers',
                'condition_id.required' => 'The condition field is required',
                'condition_id.integer' => 'The condition field must have numbers',
                'status_id.required' => 'The status field is required',
                'status_id.integer' => 'The status field must have numbers',
                'user_id.required' => 'The user field is required',
                'user_id.integer' => 'The user field must have numbers'
            ];

            $validator = Validator::make($input,$rules,$messagges)->validate();

            $item = Item::find($request->input('id'));
            if ($item){
                $item->datetime_it = $concatDateTime;
                $item->item_it = $request->input('item_it');
                $item->quanty_it = $request->input('quanty_it');
                $item->qty_boxes_it = $request->input('qty_boxes_it');
                $item->ubication_it = $request->input('ubication_it');
                $item->observation_it = $request->input('observation_it');
                $item->customer_id = $request->input('customer_id');
                $item->condition_id = $request->input('condition_id');
                $item->status_id = $request->input('status_id');
                $item->user_id = $request->input('user_id');
                $item->save();
            }

    }

    public function deleteItem($idItem){
        $item = Item::find($idItem);
        $item->delete();
    }

    public function closeItem(Request $request){
        $input = $request->all();
        $rules = [
            'datetime_it' => 'required|date',
            'ubication_it' => 'required',
            'sub_customer_id' => 'required|integer',
            'condition_id' => 'required|integer',
            'status_id' => 'required|integer',
            'shipment_id' => 'required|integer',
            'employee_id' => 'required|integer',
            'item_id' => 'required|integer',
            'user_id' => 'required|integer',
        ];
        $messagges = [
            'datetime_it.required' => 'The datetime field is required',
            'datetime_it.date' => 'The date field must be date-formatted',
            'ubication_it.required' => 'The ubication field is required',
            'sub_customer_id.required' => 'The customer field is required',
            'sub_customer_id.integer' => 'The customer field must have numbers',
            'condition_id.required' => 'The condition field is required',
            'condition_id.integer' => 'The condition field must have numbers',
            'status_id.required' => 'The status field is required',
            'status_id.integer' => 'The status field must have numbers',
            'shipment_id.required' => 'The shipment field is required',
            'shipment_id.integer' => 'The shipment field must have numbers',
            'employee_id.required' => 'The employee field is required',
            'employee_id.integer' => 'The employee field must have numbers',
            'item_id.required' => 'The item ID field is required',
            'item_id.integer' => 'The item ID field must have numbers',
            'user_id.required' => 'The user field is required',
            'user_id.integer' => 'The user field must have numbers'
        ];

        $validator = Validator::make($input,$rules,$messagges)->validate();

        $saved = Item::create($input);
    }
}
