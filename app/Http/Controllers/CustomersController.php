<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Customers\RegisterCustomerRequest;
use App\Http\Requests\Customers\UpdateCustomerRequest;
use App\Models\Customer;
use App\Models\SubCustomer;
use App\Models\Movement;
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
    public function index()
    {
        return view('customers.view-customers');
    }

    public function getCustomers(){
        $customers = Customer::all();
        $forDtt['data'] = $customers;
        return response()->json($forDtt, 200);
    }

    public function store(RegisterCustomerRequest $request){
        $saved = Customer::create($request->all());
        if ($saved){
            return redirect()->route('customers')->with('flash','¡The customer has been successfully registered!');
        }else{
            return view('home');
        }
    }

    public function viewCustomer($idCustomer){
        $customer = Customer::find($idCustomer);
        return response()->json($customer, 200);
    }

    public function updateCustomer(UpdateCustomerRequest $request){
        $verify = Customer::where('email_cu',$request->input('email_cu'))->where('id','!=',$request->input('id'))->get()->first();
        if ($verify){
            return 0;
        }else{
            $customer = Customer::find($request->input('id'));
            if ($customer){
                $customer->name_cu = $request->input('name_cu');
                $customer->phone_cu = $request->input('phone_cu');
                $customer->email_cu = $request->input('email_cu');
                $customer->save();
            }
            return 1;
        }
    }

    public function deleteCustomer($idCustomer){
        $verify = Movement::where('customer_id',$idCustomer)->where('status_id','!=',2)->get()->first();
        if ($verify){
            return response()->json(1);
        }else{
            $customer = Customer::find($idCustomer);
            $customer->delete();
            //Customer::destroy($idCustomer);
            return response()->json(0);
        }
    }

    //Sub customers

    public function viewSubCustomers($idCustomer)
    {
        $customers = Customer::where('id','!=',$idCustomer)->get();
        $customer = Customer::find($idCustomer);
        return view('customers.view-sub-customers',compact('customer','customers'));
    }

    public function insertSubCustomer(Request $request){
        $saved = SubCustomer::create($request->all());
        if ($saved){
            return redirect()->route('sub-customers')->with('flash','¡The sub customer has been successfully registered!');
        }else{
            return view('home');
        }
    }
}

