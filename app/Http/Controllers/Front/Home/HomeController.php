<?php

namespace App\Http\Controllers\Front\Home;

use Illuminate\Http\Request;
use App\Http\Requests\SurveyRequest;
use App\Http\Controllers\Controller;
use App\Models\SurveiResult;
use App\Models\UserBranch;
use App\Models\CustomerService;
use Auth;
use Validator;

class HomeController extends Controller
{
    // public function __contstruct()
    // {
    //     $this->middleware('auth:user_branch');
    // }

    public function index()
    {
        $data = UserBranch::where('id', Auth::user()->id)->with('branch')->first();
        $options = $this->listing();
        return view('front.home.index', compact('data', 'options'));
    }

    public function store(Request $request)
    {
		$rule = ['teller_id' => 'required'];
		$message = ['teller_id.required' => 'Please choose the customer service / teller.'];
		$validator = Validator::make($request->all(),$rule,$message);
		if ($validator->fails()){
			return response()->json(['message' => $validator->messages()],422);
		} else {
			$user = UserBranch::find($request->user_id);
			$branch = $user->branch()->latest()->first();
			$data = (new SurveiResult);
			$data->create([
				'survei_emot' => $request->survei_emot,
				'branch_id' => $branch->id,
				'level_1' => $request->level_1,
				'level_2' => $request->level_2,
				'level_3' => $request->level_3,
				'user_id' => $request->user_id,
				'teller_id' => $request->teller_id
			]);

			if ($data) {
				return response()->json([
					'success' => true
				], 200);
			}
		}
        abort(500);
    }

    private function listing()
    {
        $user = CustomerService::where('branch_id', Auth::guard('user_branch')->user()->branch_id)->pluck('name', 'id');
        $options['user'] = $user;

        return $options;
    }
}
