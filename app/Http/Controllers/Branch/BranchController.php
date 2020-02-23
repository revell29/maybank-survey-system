<?php

namespace App\Http\Controllers\Branch;

use Illuminate\Http\Request;
use App\Http\Requests\BranchRequest;
use App\Http\Requests\BranchUpdateRequest;
use App\Http\Controllers\Controller;
use App\Models\Branches;
use Illuminate\Database\QueryException;
use Auth;
use Entrust;
use DataTables;

class BranchController extends Controller
{
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
        return view('backend.branches.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = (new Branches)->max('id') + 1;
        $prefix = 'BRC' . $id;
        return view('backend.branches.create_edit_branch', compact('prefix'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BranchRequest $request)
    {
        try {
            $data = (new Branches);
            $data->create([
                'branch_id' => $request->branch_id,
                'branch_name' => $request->branch_name,
                'branch_address' => $request->branch_address,
                'status' => 1
            ]);
            \LogActivity::addToLog(Auth::user()->username . ' add branch');
            return response()->json([
                'message' => 'Data successfully added'
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'type' => 1
            ], 500);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'type' => '3',
                'file' => $exception->getFile(),
                'code' => $exception->getCode(),
                'line' => $exception->getLine(),
                'array' => $exception->getPrevious()
            ]);
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
        $data = (new Branches)->find($id);
        $id = (new Branches)->max('id') + 1;
        $prefix = 'BRC' . $id;
        return view('backend.branches.show_only', compact('prefix', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = (new Branches)->find($id);
        if ($data) {
            $id = (new Branches)->max('id') + 1;
            $prefix = 'BRC' . $id;
            return view('backend.branches.create_edit_branch', compact('prefix', 'data'));
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
    public function update(BranchUpdateRequest $request, $id)
    {
        $data = Branches::find($id);
        if ($data) {
            $data->update([
                'branch_id' => $request->branch_id,
                'branch_name' => $request->branch_name,
                'branch_address' => $request->branch_address,
                'status' => 1
            ]);

            if ($request->has('branch_name')) {
                $data->update([
                    'branch_name' => $request->branch_name
                ]);
            }

            \LogActivity::addToLog(Auth::user()->username . ' update branch');

            return response()->json([
                'message' => 'Data successfully update'
            ], 200);
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
            Branches::destroy(explode(',', $id));
        } else {
            Branches::where('id', $id)->delete();
        }
        \LogActivity::addToLog(Auth::user()->username . ' delete branch');
    }

    public function data()
    {
        $data = Branches::orderBy('id', 'DESC')->get();
        $permission = Entrust::can('edit_branch');
        return DaTatables::of($data)
            ->editColumn('branch_id', function ($item) use ($permission) {
                if ($permission) {
                    return '<a href="' . route('branch.edit', $item->id) . '">' . $item->branch_id . '</a>';
                } else {
                    return '<a href="' . route('branch.show', $item->id) . '">' . $item->branch_id . '</a>';
                }
            })
            ->editColumn('status', function ($item) {
                if ($item->status == 0) {
                    return "<span class='badge badge-pill badge-danger'>Deactive</span>";
                } else {
                    return "<span class='badge badge-pill badge-success'>Active</span>";
                }
            })
            ->escapeColumns([])
            ->make(true);
    }
}
