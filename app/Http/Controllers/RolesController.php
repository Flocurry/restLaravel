<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Roles;
use DB;
use Illuminate\Http\Request;

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
        try {
            $user = Roles::create([
                'libelle' => $request->get('libelle'),
            ]);
            return array('successAdd' => true);
        } catch (\Illuminate\Database\QueryException $e) {
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
        $datas = array('role_id' => $request->get('role_id'), 'libelle' => $request->get('libelle'));
        try {
            $role = Roles::find($request->get('role_id'));
            $role->libelle = $request->get('libelle');
            $role->save();
            return array('successEdit' => true);
        } catch (\Illuminate\Database\QueryException $e) {
            return array('successEdit' => false);
        }
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
        } else {
            // Suppression du rôle
            if ($role->delete()) {
                return array('successDelete' => true);
            } else {
                return array('successDelete' => false);
            }
        }

    }
}
