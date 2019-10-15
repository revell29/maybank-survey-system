<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Requests\UserBranchRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Controllers\Controller;
use DataTables;
use Auth;
use App\Models\UserBranch;
use App\Models\Branches;
use Entrust;

class UserBranchController extends Controller
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
        return view('backend.user-branch.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ID = (new UserBranch)->max('id') + 1;
        $prefix = 'USR' . $ID;
        $options = $this->listing();
        return view('backend.user-branch.create_edit_branch', compact('prefix', 'options'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserBranchRequest $request)
    {
        $data = (new UserBranch);
        $data->create([
            'user_id' => $request->user_id,
            'ip_address' => $request->ip_address,
            'username' => $request->username,
            'branch_id' => $request->branch_id,
            'created_by' => Auth::user()->id
        ]);
        if ($data) {
            \LogActivity::addToLog(Auth::user()->username . ' create user branch');
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
        $data = (new UserBranch)->find($id);

        $ID = (new UserBranch)->max('id') + 1;
        $prefix = 'USR' . $ID;
        $options = $this->listing();
        return view('backend.user-branch.show_only', compact('data', 'prefix', 'options'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = (new UserBranch)->find($id);
        if ($data) {
            $ID = (new UserBranch)->max('id') + 1;
            $prefix = 'USR' . $ID;
            $options = $this->listing();
            return view('backend.user-branch.create_edit_branch', compact('data', 'prefix', 'options'));
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
    public function update(UpdateUserRequest $request, $id)
    {
        $data = (new UserBranch)->find($id);
        if ($data) {
            $array = array($request->ip_address, $data->token);
            $verify = join($array);
            $data->update([
                'user_id' => $data->user_id,
                'username' => $request->username,
                'branch_id' => $request->branch_id,
                'created_by' => Auth::user()->id

            ]);

            \LogActivity::addToLog(Auth::user()->username . ' update user branch');

            /* if(!empty($request->input('password'))){
                $data->update([
                    'password' => bcrypt($request->input('password'))
                ]);
            } else {
                $data->update([
                    'password' => $data->password
                ]);
            } */

            if (!empty($request->input('ip_address'))) {
                $data->update([
                    'ip_address' => empty($request->ip_address) ? null : null,
                    'ip_address2' => empty($request->ip_address) ? null : null,
                    'token' => null
                ]);
            } else {
                $data->update([
                    'ip_address' => empty($request->ip_address) ? null : null,
                    'ip_address2' => empty($request->ip_address) ? null : null,
                    'token' => null
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
            UserBranch::destroy(explode(',', $id));
        } else {
            UserBranch::where('id', $id)->delete();
        }

        \LogActivity::addToLog(Auth::user()->username . ' delete user branch');
    }

    public function data()
    {
        $data = UserBranch::with('branch')->orderBy('id', 'DESC')->get();
        $permission = Entrust::can('edit_user_branch');
        return DaTatables::of($data)
            ->editColumn('user_id', function ($item) use ($permission) {
                if ($permission) {
                    return '<a href="' . route('user_branch.edit', $item->id) . '">' . $item->user_id . '</a>';
                } else {
                    return '<a href="' . route('user_branch.show', $item->id) . '">' . $item->user_id . '</a>';
                }
            })
            ->addColumn('branch_name', function ($item) {
                if ($item->branch) {
                    return $item->branch ? $item->branch->branch_name : '';
                }
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     *  Listing item wiht pluck
     * 
     * @param int @id
     */

    private function listing()
    {
        $branches = (new Branches)->pluck('branch_name', 'id');
        $options['branches'] = $branches;

        return $options;
    }
}
