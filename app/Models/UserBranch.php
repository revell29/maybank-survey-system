<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Adldap\Laravel\Traits\HasLdapUser;
use Illuminate\Foundation\Auth\User as Authenticatable;


class UserBranch extends Authenticatable
{   
    use HasLdapUser;
    
    protected $guard = 'user_branch';
    protected $table = 'user_branchs';
    protected $guarded = [];
    protected $appends = ['full_name'];

    public function getFullNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function branch()
    {
        return $this->belongsTo(Branches::class,'branch_id');
    }
}
