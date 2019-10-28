<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Adldap\Contracts\AdldapInterface;
use Adldap\Laravel\Traits\ImportsUsers;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use DataTables;
use Auth;
use Entrust;


class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $code     = 'USR';
        $lastCode   = collect(User::all())->last();
        $prefix       = $code . (substr($lastCode['user_id'], strlen($code)) + 1);
        $role = Role::pluck('display_name', 'id');
        return view('backend.user.create_edit_user', compact('prefix', 'role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $data = (new User);
        $data->create([
            'user_id' => $request->user_id,
            'username' => $request->username,
            'role_id' => $request->role_id,
            'created_by' => Auth::user()->id,
        ]);

        $roles = (new Role)->where('id', $request->input('role_id'))->get();


        if ($data) {
            $data1 = (new User)->where('username', $request->username)->first();
            $data1->roles()->attach($request->role_id);
            \LogActivity::addToLog(Auth::user()->username . ' add user');
            return response()->json(['message' => 'User has been added'], 200);
        } else {
            return response()->json(['message' => 'Oops!! something went wrong error'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = (new User)->find($id);
        if ($data) {
            $ID = (new User)->max('id') + 1;
            $prefix = 'USR' . $ID;
            $role = Role::pluck('display_name', 'id');
            return view('backend.user.show_only', compact('data', 'prefix', 'role'));
        }
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = (new User)->find($id);
        if ($data) {
            $ID = (new User)->max('id') + 1;
            $prefix = 'USR' . $ID;
            $role = Role::pluck('display_name', 'id');
            return view('backend.user.create_edit_user', compact('data', 'prefix', 'role'));
        }
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = (new User)->find($id);
        if ($data) {
            $data->update([
                'user_id' => $request->user_id,
                'role_id' => $request->role_id,
                'username' => $request->username,
                'created_by' => Auth::user()->id,
            ]);

            $roles = (new Role)->where('id', $request->input('role_id'))->pluck('id', 'id');
            $data->roles()->sync($roles);
            \LogActivity::addToLog(Auth::user()->username . ' update user');

            if ($request->has('password')) {
                $data->update([
                    'password' => bcrypt($request->input('password'))
                ]);
            }
            return response()->json(['message' => 'User has been added'], 200);
        } else {
            return response()->json(['message' => 'Oops!! something went wrong error'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (is_array(explode(',', $id))) {
            User::destroy(explode(',', $id));
        } else {
            User::where('id', $id)->delete();
        }
        \LogActivity::addToLog(Auth::user()->username . ' delete user');
    }

    public function data()
    {
        $data = user::with('role')->select('users.*');
        $permission = Entrust::can('edit_user');
        return DaTatables::of($data)
            ->setRowId('id')
            ->editColumn('user_id', function ($item) use ($permission) {
                if ($permission) {
                    return '<a href="' . route('user.edit', $item->id) . '">' . $item->user_id . '</a>';
                } else {
                    return '<a href="' . route('user.show', $item->id) . '">' . $item->user_id . '</a>';
                }
            })
            ->escapeColumns([])
            ->make(true);
    }
}
