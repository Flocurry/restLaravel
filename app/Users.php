<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $primaryKey = 'user_id';

    protected $fillable = ['username', 'firstname', 'lastname', 'password', 'email', 'sexe', 'image', 'role_id', 'is_connected'];

    public $timestamps = false;

    public static $colsDataGrid = array(
        'username' => array('label' => 'Username', 'visible' => false, 'resizable' => true, 'order' => true, 'sorting' => true, 'width' => 50),
        'firstname' => array('label' => 'Firstname', 'visible' => true, 'resizable' => true, 'order' => true, 'sorting' => true),
        'lastname' => array('label' => 'Lastname', 'visible' => true, 'resizable' => true, 'order' => true, 'sorting' => true),
        'password' => array('label' => 'Password', 'visible' => false, 'order' => true, 'sorting' => true),
        'email' => array('label' => 'E-mail', 'visible' => true, 'resizable' => false, 'order' => true, 'sorting' => true),
        'sexe' => array('label' => 'Sexe', 'visible' => true, 'resizable' => false, 'order' => true, 'sorting' => true),
        'image' => array('label' => 'Avatar', 'visible' => false, 'order' => true, 'sorting' => true),
        'role_id' => array('label' => 'Role_id', 'visible' => false, 'order' => true, 'sorting' => true),
        'is_connected' => array('label' => 'Connecte', 'visible' => false, 'order' => true, 'sorting' => true),
    );
}
