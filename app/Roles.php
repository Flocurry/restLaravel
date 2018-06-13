<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $primaryKey = 'role_id';

    protected $fillable = ['libelle', 'date_creation'];

    public $timestamps = false;
}
