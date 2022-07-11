<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Customers\RegisterCustomerRequest;
use App\Http\Requests\Customers\UpdateCustomerRequest;
use App\Models\Customer;
use App\Models\SubCustomer;
use DB;

class CustomersController extends Controller
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

    //Customers

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        return view('customers.view-customers');
    }

    public function getCustomers(){
        $customers = Customer::all();
        $forDtt['data'] = $customers;
        return response()->json($forDtt,200);
    }

    public function store(RegisterCustomerRequest $request){
        $verify = Customer::where('phone_cu',$request->input('phone_cu'))->where('email_cu',$request->input('email_cu'))
            ->where('name_cu',$request->input('name_cu'))
            ->first();

        if ($verify){
            return response()->json(0);
        }else{
            $customer = Customer::create($request->all());
            $customer->subCustomer()->attach($customer->id);
            return response()->json(1);
        }
    }

    public function viewCustomer($idCustomer){
        $customer = Customer::find($idCustomer);
        return response()->json($customer, 200);
    }

    public function updateCustomer(UpdateCustomerRequest $request){
        $verify = Customer::where('phone_cu',$request->input('phone_cu'))
                ->where('email_cu',$request->input('email_cu'))
                ->where('name_cu',$request->input('name_cu'))
                ->where('id','!=',$request->input('id'))
                ->first();
        if ($verify){
            return response()->json(0);
        }else{
            $customer = Customer::find($request->input('id'));
            if ($customer){
                $customer->name_cu = $request->input('name_cu');
                $customer->phone_cu = $request->input('phone_cu');
                $customer->email_cu = $request->input('email_cu');
                $customer->save();
                return response()->json(1);
            }
        }
    }

    public function deleteCustomer($idCustomer){
        Customer::find($idCustomer)->delete();
        return response()->json(0);
    }

    //Sub customers

    public function viewSubCustomers($idCustomer){
        $customer = Customer::find($idCustomer);
        return view('customers.view-sub-customers',compact('customer'));
    }

    public function getSubCustomerOfCustomer($idCustomer){
        $subCustomers = Customer::where('id', '<>', $idCustomer)->get();
        return response()->json($subCustomers,200);
    }

    public function getSubCustomers($idCustomer){
        $subCustomers = Customer::find($idCustomer)->subCustomer()->where('sub_customer_id', '<>', $idCustomer)->get();
        $forDtt['data'] = $subCustomers;
        return response()->json($forDtt,200);
    }

    public function registerSubCustomer(Request $request){
        $input = $request->all();
        $rules = [
            'customer_id' => 'required|integer',
            'sub_customer_id' => 'required|integer',
        ];
        $messagges = [
            'customer_id.required' => 'The customer ID field is required',
            'customer_id.integer' => 'The customer ID field must have numbers',
            'sub_customer_id.required' => 'The sub customer field is required',
            'sub_customer_id.integer' => 'The sub customer field must have numbers'
        ];

        $validator = Validator::make($input,$rules,$messagges)->validate();

        $verify = SubCustomer::where('sub_customer_id',$request->input('sub_customer_id'))
                            ->where('customer_id',$request->input('customer_id'))
                            ->first();
        if ($verify){
            return response()->json(0);
        }else{
            $saved = SubCustomer::create($input);
            return response()->json(1);
        }
    }

    public function deleteSubCustomer(Request $request){
        $subCustomer = Customer::find($request->input('customer_id'))->subCustomer()->detach($request->input('sub_customer_id'));
        return response()->json(1,200);
    }
}
