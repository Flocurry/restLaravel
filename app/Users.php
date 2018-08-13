<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $primaryKey = 'user_id';

    protected $fillable = ['username','firstname','lastname','password','email','sexe','image','role_id','is_connected'];

    public $timestamps = false;
}
