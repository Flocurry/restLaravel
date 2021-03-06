<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Roles
Route::get('/roles', [
    'as' => 'roles.index',
    'uses' => 'RolesController@index'
    ]);

Route::post('/roles/save','RolesController@store');
Route::put('/roles/edit','RolesController@update');
Route::delete('/roles/delete/{id}','RolesController@delete');
    
// Users
Route::get('/users', [
    'as' => 'users.index',
    'uses' => 'UsersController@index'
]);

Route::delete('/users/delete/{id}','UsersController@delete');

Route::post('/users/save','UsersController@store');

Route::get('/login/user', 'UsersController@login');

Route::get('/users/image/{id}', 'UsersController@getUsersImage');

Route::post('/users/upload','UsersController@uploadFile');
Route::put('/users/logout','UsersController@logout');