<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Adldap\Laravel\Traits\HasLdapUser;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class UserBranch extends Authenticatable
{
    use HasLdapUser;

    protected $guard = 'user_branch';
    protected $table = 'user_branchs';
    protected $guarded = [];
    protected $appends = ['full_name'];

    protected $casts = [
        'user_id' => 'array',
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function branch()
    {
        return $this->belongsTo(Branches::class, 'branch_id');
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
