<?php

namespace App\Http\Controllers\Log;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog as LogModel;
use DataTables;

class Activity extends Controller
{
    public function index()
    {
        return view('backend.log.index');
    }


    public function data()
    {
        $data = LogModel::query();
        return DataTables::of($data)
                    ->editColumn('created_at',function($q){
                        return $q->created_at->format('d F Y H:i:s');
                    })
                    ->addColumn('user',function($q){
                        return $q->user->username;
                    })
                    ->make(true);
    }
}
