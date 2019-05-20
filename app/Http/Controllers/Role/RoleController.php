<?php

namespace App\Http\Controllers\Role;

use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use DataTables;
use Auth;
use Entrust;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = Permission::all();
        return view('backend.role.create_edit',compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $role = new Role();
        $role->name = $request->input('name');
        $role->display_name = $request->input('name');
        $role->description = $request->input('description');
        $role->save();
        $role->perms()->sync($request->input('permissions'));
        \LogActivity::addToLog(Auth::user()->username.' add user role');

        return response()->json([
            'message' => 'Role successfully created'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Role::find($id);
        if($data){
            $permission = Permission::all();
            return view('backend.role.show_only',compact('permission','data'));
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
        $data = Role::find($id);
        if($data){
            $permission = Permission::all();
            return view('backend.role.create_edit',compact('permission','data'));
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
        $role = Role::find($id);
        if($role){
            $role->update([
                'name' => $request->name,
                'display_name' => $request->name,
                'description' => $request->description,
            ]);
            $role->perms()->sync($request->input('permissions'));
            \LogActivity::addToLog(Auth::user()->username.' update user role');

            return response()->json([
                'message' => 'Role successfully updated'
            ]);
        }

        abort(404);
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
            Role::whereIn('id',explode(',', $id))->delete();
        } else {
            Role::where('id',$id)->delete();
        }

        \LogActivity::addToLog(Auth::user()->username.' delete user role');

    }

    public function data()
    {
        $data = Role::select('*');
        $permission = Entrust::can('edit_role');
        return DataTables::of($data)
                ->addIndexColumn()
                ->setRowId('id')
                ->editColumn('name',function($item) use($permission){
                    if($permission){
                        return '<a href="'.route('role.edit',$item->id).'">'.$item->name.'</a>';
                    } else {
                        return '<a href="'.route('role.show',$item->id).'">'.$item->name.'</a>';

                    }
                })
                ->escapeColumns([])
                ->make(true);
    }
}
