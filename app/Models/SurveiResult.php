<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SurveiResult extends Model
{
    protected $guarded = [];
    protected $dates = ['created_at'];
    protected $dateFormat = 'Y-m-d H:i:s.000';

    public function branch()
    {
        return $this->belongsTo(Branches::class, 'branch_id');
    }

    public function user()
    {
        return $this->belongsTo(CustomerService::class, 'teller_id', 'id');
    }
}
