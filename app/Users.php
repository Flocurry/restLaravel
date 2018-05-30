<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $primaryKey = 'user_id';

    protected $fillable = ['username','firstname','lastname','password','email','role_id'];

    public $timestamps = false;
}
