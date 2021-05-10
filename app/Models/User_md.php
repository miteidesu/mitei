<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class User_md extends Model
{
    protected $table = 'users';
    protected $fillable = ['uid','name','password','mail'];

}
