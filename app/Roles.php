<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $primaryKey = 'role_id';

    protected $fillable = ['libelle', 'date_creation'];

    public $timestamps = false;

    public static $colsDataGrid = array(
        'role_id' => array('label' => 'Role_id', 'visible' => false),
        'libelle' => array('label' => 'Role', 'visible' => false),
        'date_creation' => array('label' => 'Date creation', 'visible' => false)
    );
}
