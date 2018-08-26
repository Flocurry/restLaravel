<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Users;
use DB;
use File;
use Hash;
use Illuminate\Http\Request;
use Image;
use Response;
use Storage;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $res = DB::table('users as u')->join('roles as r', 'u.role_id', '=', 'r.role_id')->get();
        $datas = $res->map(function ($obj) {
            $arr = (array) $obj;
            $arr['image'] = 'http://localhost/users/image/' . $arr['image'];
            return $arr;
        })->toArray();

        return $datas;
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

    public function getUsersImage($filename)
    {
        $path = Storage::disk('images')->getAdapter()->getPathPrefix() . $filename;
        if (!File::exists($path)) {
            return response()->json(['message' => 'Image not found.'], 404);
        }

        $file = File::get($path);

        return Image::make($file)->resize(90, 100)->response('png');
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
            $filename = 'noimage.txt';
            // On store l'image sur le serveur
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = $file->getClientOriginalName();
                Storage::disk('images')->put($filename, File::get($file));
            }
            // On upload le fichier
            $user = Users::create([
                'username' => $request->get('username'),
                'firstname' => $request->get('firstname'),
                'lastname' => $request->get('lastname'),
                'sexe' => $request->get('sexe'),
                'password' => Hash::make($request->get('password')),
                'email' => $request->get('email'),
                'image' => $filename,
                'role_id' => $request->get('role_id'),
            ]);
            return array('successAdd' => true);
        } catch (\Illuminate\Database\QueryException $e) {
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
     * Update the specified resource in storage when logout.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        try {
            $user = Users::find($request->get('user_id'));
            // Update du champ is_connected
            $user->is_connected = false;
            $user->save();
            return array('successEdit' => true);
        } catch (\Illuminate\Database\QueryException $e) {
            return array('successEdit' => false);
        }
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

        if ($task->delete()) {
            return $this->response->withItem($task, new TaskTransformer());
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
        if ($user->delete()) {
            return array('successDelete' => true);
        } else {
            return array('successDelete' => false);
        }
    }

    /**
     * Récupère le user qui se logge
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $username = $request->get('username');
        $password = $request->get('password');
        $user = DB::table('users as u')->join('roles as r', 'u.role_id', '=', 'r.role_id')->where('username', $username)->get();
        $ret = array();
        foreach ($user as $datasUser) {
            if (Hash::check($password, $datasUser->password)) {
                // On flag que le user est connecté
                DB::table('users')->where('username', $username)
                // ->where('password', Hash::make($password))
                ->update(['is_connected' => 1]);
                $ret = $user;
            }
        }
        return $ret;
    }
}
