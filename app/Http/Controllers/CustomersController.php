<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Customers\RegisterCustomerRequest;
use App\Http\Requests\Customers\UpdateCustomerRequest;
use App\Models\Customer;
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
        return view('customers');
    }

    public function GetCustomers(){
        $customers = DB::table('customers')
                    ->get();
        $forDtt['data'] = $customers;
        return response()->json($forDtt);
    }

    public function store(RegisterCustomerRequest $request)
    {
        $saved = Customer::create($request->all());
        if ($saved){
            return redirect('/customers')->with('flash','¡The customer has been successfully registered!');
        }else{
            return redirect()->back()->withInput()->withError('¡You have not saved the customer!');
        }
    }

    public function viewCustomer($idCustomer){
        $customer = DB::table('customers')->where('id',$idCustomer)->first();
        return get_object_vars($customer);
    }

    public function updateCustomer(Request $request){
        $customer = Customer::find($request->id);
        if ($customer){
            $customer->name_cu = $request->name_cu;
            $customer->phone_cu = $request->phone_cu;
            $customer->save();
            return response()->json(1);
        }else{
            return response()->json(0);
        }
    }

    public function deleteCustomer($idCustomer){
        Customer::destroy($idCustomer);
        if (Customer::find($idCustomer) == null){
            return response()->json(1);
        }else{
            return response()->json(0);
        }
    }
}

