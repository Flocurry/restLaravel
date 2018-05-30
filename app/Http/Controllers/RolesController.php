<?php

namespace App\Http\Controllers;

use App\Roles;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Roles::all();
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
        // \print_r('test');die;
        try{
            $user = Roles::create([
                'libelle' => $request->get('libelle')
            ]);
            return array('successAdd' => true);
        }catch(\Illuminate\Database\QueryException $e){
            return array('successAdd' => false);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function show(Roles $roles)
    {
        return $roles::all();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function edit(Roles $roles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Roles $roles)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function destroy(Roles $roles)
    {
        //
    }

    public function delete($id)
    {
        //Get the role
        $role = Roles::find($id);
        // On test si le rôle est rattaché à un user
        // (auquel cas on ne peut pas le supprimer)
        $user = DB::table('users as u')->where('role_id', $id)->get();
        if (!$user->isEmpty()) {    
            return array('successDelete' => false, 'message' => 'Ce rôle est rattaché à un user');
        }
        else{
            // Suppression du rôle
            if($role->delete()) {
                return array('successDelete' => true);
            } else {
                return array('successDelete' => false);
            }
        }
        
    }
}
