<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ilast_md extends Model
{
    protected $table = 'ilast';
    protected $fillable = ['uid','path','title','tag','text'];
}
