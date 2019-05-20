<?php

namespace App\Http\Controllers\Front\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SurveiResult;
use App\Models\UserBranch;
use Auth;

class HomeController extends Controller
{
    // public function __contstruct()
    // {
    //     $this->middleware('auth:user_branch');
    // }

    public function index()
    {   
        $data = UserBranch::where('id',Auth::user()->id)->with('branch')->first();
        return view('front.home.index',compact('data'));
    }

    public function store(Request $request)
    {   
        $user = UserBranch::find($request->user_id);
        $branch = $user->branch()->latest()->first();
        $data = (new SurveiResult);
        $data->create([
            'survei_emot' => $request->survei_emot,
            'branch_id' => $branch->id,
            'level_1' => $request->level_1,
            'level_2' => $request->level_2,
            'level_3' => $request->level_3,
            'user_id' => $request->user_id
        ]);

        if($data){
            return response()->json([
                'success' => true
            ],200);
        }

        abort(500);
    }
}
