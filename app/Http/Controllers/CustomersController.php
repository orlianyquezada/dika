<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Customers\RegisterCustomerRequest;
use App\Http\Requests\Customers\UpdateCustomerRequest;
use App\Models\Customer;
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('customers.customers');
    }

    public function getCustomers(){
        $customers = Customer::all();
        $forDtt['data'] = $customers;
        return response()->json($forDtt, 200);
    }

    public function store(RegisterCustomerRequest $request){
        $saved = Customer::create($request->all());
        if ($saved){
            return redirect('/customers/customers')->with('flash','¡The customer has been successfully registered!');
        }else{
            return view('home');
        }
    }

    public function viewCustomer($idCustomer){
        $customer = Customer::find($idCustomer);
        return response()->json($customer, 200);
    }

    public function updateCustomer(Request $request){
        $verify = Customer::where('id','!=',$request->input('id'))->where('email_cu',$request->input('email_cu'))->get()->first();
        if ($verify){
            return 0;
        }else{
            $customer = Customer::find($request->id);
            if ($customer){
                $customer->name_cu = $request->input('name_cu');
                $customer->phone_cu = $request->input('phone_cu');
                $customer->email_cu = $request->input('email_cu');
                $customer->save();
            }
        }
    }

    public function deleteCustomer($idCustomer){
        $verify = Movement::where('customer_id',$idCustomer)->where('status_id','!=',2)->get()->first();
        if ($verify){
            return response()->json(1);
        }else{
            Customer::destroy($idCustomer);
            return response()->json(0);
        }
    }
}

