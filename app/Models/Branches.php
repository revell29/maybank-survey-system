<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class Branches extends Model
{   
    
    protected $guarded = [];

    public function survey_branch()
    {
        return $this->hasMany(SurveiResult::class,'branch_id','id')
                        ->select('branch_id',
                            DB::raw('COUNT(level_1) as lv1'),
                            DB::raw('COUNT(level_2) as lv2'),
                            DB::raw('COUNT(level_3) as lv3'),
                            DB::raw('COUNT(level_1)+COUNT(level_2)+COUNT(level_3) as total'))
                            ->whereNotNull('branch_id')
                            ->groupBy('branch_id');
    }
}
