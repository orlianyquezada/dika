<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Item;
use App\Models\ConditionItem;
use App\Models\Condition;
use App\Models\ItemStatus;
use App\Models\Status;
use App\Models\Shipment;
use App\Models\Customer;
use App\Models\SubCustomer;
use App\User;
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
        $conditions =  Condition::all();
        $status =  Status::all();
        $shipments = Shipment::all();
        $users = User::all();
        $customers = DB::select('SELECT * FROM customers WHERE id IN (SELECT a.id FROM customers a, sub_customers b WHERE a.id=b.customer_id)');
        return view('items.view-items',compact('conditions','status','customers','shipments','users'));
    }

    public function store(Request $request){
        $input = $request->all();
        $rules = [
            'datetime_input_it' => 'required|date',
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
            'datetime_input_it.required' => 'The datetime field is required',
            'datetime_input_it.date' => 'The date field must be date-formatted',
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

        $item = Item::create($request->all());
        $idItem = $item->id;
        $conditionItem = new ConditionItem; //Guardar condition
        $conditionItem->item_id = $idItem;
        $conditionItem->condition_id = $request->input("condition_id");
        $conditionItem->user_id = $request->input("user_id");
        $conditionItem->save();
        $itemStatus = new ItemStatus; //Guardar status
        $itemStatus->item_id = $idItem;
        $itemStatus->status_id = $request->input("status_id");
        $itemStatus->user_id = $request->input("user_id");
        $itemStatus->save();
        return response()->json(1,200);
    }

    public function getItems(){
        $consult = Item::all();
        $forDtt['data'] = $consult;
        return response()->json($forDtt, 200);
    }

    public function consultItem($idItem){
        $item = Item::find($idItem);
        $customer = $item->customers()->first();
        $subCustomer = $item->subCustomer()->first();
        $conditions = $item->conditions()->orderBy('created_at','ASC')->get();
        $status = $item->status()->orderBy('created_at','ASC')->get();
        $shipment = $item->shipment()->first();
        $employee = $item->employee()->first();
        $user = $item->user()->first();
        return response()->json([$item,$customer,$subCustomer,$conditions,$status,$shipment,$employee,$user],200);
    }

    public function consultSubCustomer($idCustomer){
        $subCustomers = Customer::find($idCustomer)->customerAsSubCustomer()->get();
        return response()->json($subCustomers,200);
    }

    public function updateItem(Request $request){
        if (empty($request->input('item_id'))){
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
                'datetime_it.required' => 'The date field is required',
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

            $validator = Validator::make($input,$rules,$messagges)->validate();

            $item = Item::find($request->input('id'));
            if ($item){
                $item->datetime_it = $request->input('datetime_it');
                $item->item_it = $request->input('item_it');
                $item->quanty_it = $request->input('quanty_it');
                $item->qty_boxes_it = $request->input('qty_boxes_it');
                $item->ubication_it = $request->input('ubication_it');
                $item->observation_it = $request->input('observation_it');
                $item->customer_id = $request->input('customer_id');
                $item->user_id = $request->input('user_id');
                $item->save();
            }
            $condition = ConditionItem::where('item_id',$request->input('id'))->latest()->first()->condition_id;
            if ($condition != $request->input('condition_id')){
                $conditionItem = new ConditionItem; //Guardar condition
                $conditionItem->item_id = $request->input("id");
                $conditionItem->condition_id = $request->input("condition_id");
                $conditionItem->user_id = $request->input("user_id");
                $conditionItem->save();
            }
            $status = ItemStatus::where('item_id',$request->input('id'))->latest()->first()->status_id;
            if ($status != $request->input('status_id')){
                $itemStatus = new ItemStatus; //Guardar status
                $itemStatus->item_id = $request->input("id");
                $itemStatus->status_id = $request->input("status_id");
                $itemStatus->user_id = $request->input("user_id");
                $itemStatus->save();
            }
        }else{
            $input = $request->all();
            $rules = [
                'datetime_it' => 'required|date',
                'ubication_it' => 'required',
                'sub_customer_id' => 'required|integer',
                'condition_id' => 'required|integer',
                'status_id' => 'required|integer',
                'shipment_id' => 'required|integer',
                'employee_id' => 'required|integer',
                'user_id' => 'required|integer',
            ];
            $messagges = [
                'datetime_it.required' => 'The date field is required',
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
                'user_id.required' => 'The user field is required',
                'user_id.integer' => 'The user field must have numbers'
            ];

            $validator = Validator::make($input,$rules,$messagges)->validate();

            $item = Item::where('item_id',$request->input('item_id'))->first();
            if ($item){
                $item->datetime_it = $request->input('datetime_it');
                $item->ubication_it = $request->input('ubication_it');
                $item->observation_it = $request->input('observation_it');
                $item->sub_customer_id = $request->input('sub_customer_id');
                $item->shipment_id = $request->input('shipment_id');
                $item->employee_id = $request->input('employee_id');
                $item->user_id = $request->input('user_id');
                $item->save();
            }
            $condition = ConditionItem::where('item_id',$request->input('item_id'))->latest()->first()->condition_id;
            if ($condition != $request->input('condition_id')){
                $conditionItem = new ConditionItem; //Guardar condition
                $conditionItem->item_id = $request->input("item_id");
                $conditionItem->condition_id = $request->input("condition_id");
                $conditionItem->user_id = $request->input("user_id");
                $conditionItem->save();
            }
            $status = ItemStatus::where('item_id',$request->input('item_id'))->latest()->first()->status_id;
            if ($status != $request->input('status_id')){
                $itemStatus = new ItemStatus; //Guardar condition
                $itemStatus->item_id = $request->input("item_id");
                $itemStatus->status_id = $request->input("status_id");
                $itemStatus->user_id = $request->input("user_id");
                $itemStatus->save();
            }
        }
    }

    public function deleteItem($idItem){
        $conditions = Item::find($idItem)->conditions()->detach();
        $status = Item::find($idItem)->status()->detach();
        $item = Item::find($idItem);
        $item->delete();
    }

    public function closeItem(Request $request){
        $input = $request->all();
        $rules = [
            'datetime_it' => 'required|date',
            'ubication_it' => 'required',
            'sub_customer_id' => 'required|integer',
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
        $idItem = $request->input('item_id');
        $itemStatus = new ItemStatus; //Guardar status
        $itemStatus->item_id = $idItem;
        $itemStatus->status_id = $request->input("status_id");
        $itemStatus->user_id = $request->input("user_id");
        $itemStatus->save();
    }
}
