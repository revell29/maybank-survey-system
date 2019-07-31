<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerServiceRequest;
use DataTables;
use Auth;
use App\Models\UserBranch;
use App\Models\Branches;
use App\Models\CustomerService as MsCustomerService;
use Entrust;

class CustomerService extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.customer-service.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $options = $this->listing();
        return view('backend.customer-service.create_edit', compact('options'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerServiceRequest $request)
    {
        if ($data = MsCustomerService::create($request->all())) {
            \LogActivity::addToLog(Auth::user()->username.' create user branch');
            return response()->json(['message' => 'Customer service has been added'], 200);
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
        $data = MsCustomerService::find($id);
        if ($data) {
            return view('backend.customer-service.show_only', compact('data'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = MsCustomerService::find($id);
        if ($data) {
            $options = $this->listing();
            return view('backend.customer-service.create_edit', compact('options', 'data'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerServiceRequest $request, $id)
    {
        $data = MsCustomerService::find($id);
        if ($data) {
            $data->update($request->all());
            \LogActivity::addToLog(Auth::user()->username.' edit customer service');
            return response()->json(['message' => 'Customer service has been updated'], 200);
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
            MsCustomerService::destroy(explode(',', $id));
        } else {
            MsCustomerService::where('id', $id)->delete();
        }

        \LogActivity::addToLog(Auth::user()->username.' delete Customer service');
    }

    /**
     *  Listing Addition options
     */
    private function listing()
    {
        $branches = (new Branches)->pluck('branch_name', 'id');
        $options['branches'] = $branches;

        $role = ['cs' => 'CS', 'teller' => 'Teller'];
        $options['role'] = $role;
        return $options;
    }

    /**
     *  Listing data from storage into datatables
     *  @return \Iluminate\Http\Request
     */
    public function data()
    {
        $data = MsCustomerService::with('branch');
        $permission = Entrust::can('edit_user_branch');
        return DaTatables::of($data)
                    ->editColumn('nik', function ($item) use ($permission) {
                        if ($permission) {
                            return '<a href="'.route('customer_service.edit', $item->id).'">'.$item->nik.'</a>';
                        } else {
                            return '<a href="'.route('customer_service.show', $item->id).'">'.$item->nik.'</a>';
                        }
                    })
                    ->addColumn('branch_name', function ($item) {
                        return $item->branch->branch_name;
                    })
                    ->escapeColumns([])
                    ->make(true);
    }
}
