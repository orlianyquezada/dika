<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Movements\RegisterMovementRequest;
use App\Models\Movement;
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
    public function index()
    {
        $customers =  DB::table('customers')->get();
        $conditions =  DB::table('conditions')->get();
        $status =  DB::table('status')->get();
        return view('movements', compact('customers','conditions','status'));
    }

    public function store(RegisterMovementRequest $request){
        return redirect('home');
        // $saved = Movement::create($request->all());
        // if ($saved){
        //     return redirect('/movements')->with('flash','¡The movement has been successfully registered!');
        // }else{
        //     return redirect()->back()->withInput()->withError('¡You have not saved the movement!');
        // }
    }
}
