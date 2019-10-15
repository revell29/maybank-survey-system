<?php

namespace App\Models;

use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustRole;

class RoleUser extends Model
{
    protected $table = 'role_user';
}
