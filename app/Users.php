<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $primaryKey = 'user_id';

    protected $fillable = ['username','firstname','lastname','password','email','sexe','image','role_id','is_connected'];

    public $timestamps = false;

    public static $colsDataGrid = array(
        'username' => array('label' => 'Username', 'visible' => true, 'resizable' => true),
        'firstname' => array('label' => 'Firstname', 'visible' => true, 'resizable' => true),
        'lastname' => array('label' => 'Lastname', 'visible' => true, 'resizable' => true),
        'password' => array('label' => 'Password', 'visible' => false),
        'email' => array('label' => 'E-mail', 'visible' => true, 'resizable' => false),
        'sexe' => array('label' => 'Sexe', 'visible' => true, 'resizable' => false),
        'image' => array('label' => 'Avatar', 'visible' => false),
        'role_id' => array('label' => 'Role_id', 'visible' => false),
        'is_connected' => array('label' => 'Connecte', 'visible' => false),
    );
}
