<?php

namespace App\Http\Controllers;

use App\User;
use DataTables;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $password = Hash::make($request->input('password'));
        $request->merge(['password' => $password]);

        $user = User::create($request->all());
        $user->assignRole($request->input('rol'));

        return redirect()
            ->route('user.edit', ['user' => $user->id])
            ->with('message', 'User created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::find($id);

        if($request->input('password')){
            $password = Hash::make($request->input('password'));
            $request->merge(['password' => $password]);
            $user->update($request->all());
        }else{
            $user->update($request->except('password'));
        }

        $user->syncRoles([$request->input('rol')]);
        return back()->with('message', 'Updated client');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return response()->json([], 200);
    }

    public function getList()
    {
        return DataTables::of(User::query())
        ->addColumn('actions', function($user) {
            return '<a href="'.route('user.edit', ['user' => $user->id]).'" class="btn btn-sm btn-primary rounded-pill" title="Edit user"><i class="far fa-edit"></i></a><button class="btn btn-sm btn-danger rounded-pill" onclick="modalDestroyUser('.$user->id.')" title="Delete user"><i class="far fa-trash-alt"></i></button>';
        })
        ->rawColumns(['actions'])
        ->make(true);
    }
}
