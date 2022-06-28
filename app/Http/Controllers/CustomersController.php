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
        $customers = Customer::where('customer_id','=',NULL)->get();
        $forDtt['data'] = $customers;
        return response()->json($forDtt,200);
    }

    public function store(RegisterCustomerRequest $request){
        if (empty($request->input('customer_id'))){
            $verify = Customer::where('phone_cu',$request->input('phone_cu'))->where('email_cu',$request->input('email_cu'))->where('name_cu',$request->input('name_cu'))->where('customer_id','=',NULL)->get()->first();
            if ($verify){
                return redirect()->route('customers')->withErrors('¡That number and email has another customer!');
            }else{
                $saved = Customer::create($request->all());
                if ($saved){
                    return redirect()->route('customers')->with('flash','¡The customer has been successfully registered!');
                }else{
                    return view('home');
                }
            }
        }else{
            $verify = Customer::where('phone_cu',$request->input('phone_cu'))->where('email_cu',$request->input('email_cu'))->where('name_cu',$request->input('name_cu'))->where('customer_id',$request->input('customer_id'))->get()->first();
            if ($verify){
                return redirect()->route('sub-customers',['idCustomer' => $request->customer_id])->withErrors('¡That name,number and email has another sub customer!');
            }else{
                $saved = Customer::create($request->all());
                if ($saved){
                    return redirect()->route('sub-customers',['idCustomer' => $request->customer_id])->with('flash','¡The sub customer has been successfully registered!');
                }else{
                    return view('home');
                }
            }
        }
    }

    public function viewCustomer($idCustomer){
        $customer = Customer::find($idCustomer);
        return response()->json($customer, 200);
    }

    public function updateCustomer(UpdateCustomerRequest $request){
        if (empty($request->input('customer_id'))){
            $verify = Customer::where('phone_cu',$request->input('phone_cu'))->where('email_cu',$request->input('email_cu'))->where('name_cu',$request->input('name_cu'))->where('customer_id','=',NULL)->where('id','!=',$request->input('id'))->get()->first();
            if ($verify){
                return response()->json(0);
            }else{
                $customer = Customer::find($request->input('id'));
                if ($customer){
                    $customer->name_cu = $request->input('name_cu');
                    $customer->phone_cu = $request->input('phone_cu');
                    $customer->email_cu = $request->input('email_cu');
                    $customer->save();
                }
                return response()->json(1);
            }
        }else{
            $verify = Customer::where('phone_cu',$request->input('phone_cu'))->where('email_cu',$request->input('email_cu'))->where('name_cu',$request->input('name_cu'))->where('customer_id',$request->input('customer_id'))->where('id','!=',$request->input('id'))->get()->first();
            if ($verify){
                return response()->json(0);
            }else{
                $customer = Customer::find($request->input('id'));
                if ($customer){
                    $customer->name_cu = $request->input('name_cu');
                    $customer->phone_cu = $request->input('phone_cu');
                    $customer->email_cu = $request->input('email_cu');
                    $customer->save();
                }
                return response()->json(1);
            }
        }
    }

    public function deleteCustomer($idCustomer){
        $customer = Customer::find($idCustomer);
        $customer->delete();
        return response()->json(0);
    }

    //Sub customers

    public function viewSubCustomers($idCustomer){
        $customer = Customer::find($idCustomer);
        return view('customers.view-sub-customers',compact('customer'));
    }

    public function getSubCustomers($idCustomer){
        $customers = Customer::where('customer_id',$idCustomer)->get();
        $forDtt['data'] = $customers;
        return response()->json($forDtt,200);
    }
}

