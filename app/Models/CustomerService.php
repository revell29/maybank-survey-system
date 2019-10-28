<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class CustomerService extends Model
{
    protected $guarded = [];

    public function branch()
    {
        return $this->belongsTo(Branches::class, 'branch_id', 'id');
    }

    public function survey_branch()
    {
        return $this->hasMany(SurveiResult::class, 'teller_id', 'id')
            ->select(
                'teller_id',
                DB::raw('COUNT(level_1) as lv1'),
                DB::raw('COUNT(level_2) as lv2'),
                DB::raw('COUNT(level_3) as lv3'),
                DB::raw('COUNT(level_1)+COUNT(level_2)+COUNT(level_3) as total')
            )
            ->whereNotNull('teller_id')
            ->groupBy('teller_id');
    }
}
