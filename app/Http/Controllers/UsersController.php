<?php

namespace App\Http\Controllers;

use App\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Jointure avec la table rôle pour récupérer (pour afficher) le libellé
        return DB::table('users as u')->join('roles as r', 'u.role_id', '=', 'r.role_id')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $user = Users::create([
                'username' => $request->get('username'),
                'firstname' => $request->get('firstname'),
                'lastname' => $request->get('lastname'),
                'password' => $request->get('password'),
                'email' => $request->get('email'),
                'role_id' => $request->get('role_id'), 
            ]);
            return array('successAdd' => true);
        }catch(\Illuminate\Database\QueryException $e){
            return array('successAdd' => false);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function show(Users $users)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function edit(Users $users)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Users $users)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        //Get the task
        $task = Users::find($id);
        if (!$task) {
            return $this->response->errorNotFound('Task Not Found');
        }
 
        if($task->delete()) {
             return $this->response->withItem($task, new  TaskTransformer());
        } else {
            return $this->response->errorInternalError('Could not delete a task');
        }
    }

    public function delete($id)
    {
        //Get the user
        $user = Users::find($id);
        if (!$user) {
            return $this->response->errorNotFound('Task Not Found');
        }
        
        // Suppression du user
        if($user->delete()) {
            return array('successDelete' => true);
        } else {
            return array('successDelete' => false);
        }
    }

    /**
     * Récupère le userqui se logge
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getUserLogin(Request $request){
        $isUserAdmin = false;
        $ret = array('successLogin' => false, 'username' => '', 'sexe' => '', 'isuserisadmin' => $isUserAdmin);
        $username = $request->get('username');
        $password = $request->get('password');
        $user = DB::table('users as u')->join('roles as r', 'u.role_id', '=', 'r.role_id')->where('username', $username)->get();
        foreach ($user as $datasUser) {
            if($datasUser->libelle == 'admin'){
                $isUserAdmin = true;
            }
            if(Hash::check($password, $datasUser->password)){
                $ret = array('successLogin' => true, 'username' => $datasUser->username, 'sexe' => $datasUser->sexe, 'isuserisadmin' => $isUserAdmin);
            }
        }
        return $ret;
    }
}
