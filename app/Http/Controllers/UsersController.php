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
        $path = public_path() . '/images/' . $filename;

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
            // On récupère le nom du fichier
            $filename = 'florian.png';
            // On upload le fichier
            $user = Users::create([
                'username' => $request->get('username'),
                'firstname' => $request->get('firstname'),
                'lastname' => $request->get('lastname'),
                'password' => $request->get('password'),
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
     * RÃ©cupÃ¨re le userqui se logge
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getUserLogin(Request $request)
    {
        $isUserAdmin = false;
        $ret = array('successLogin' => false, 'username' => '', 'sexe' => '', 'isuserisadmin' => $isUserAdmin);
        $username = $request->get('username');
        $password = $request->get('password');
        $user = DB::table('users as u')->join('roles as r', 'u.role_id', '=', 'r.role_id')->where('username', $username)->get();
        foreach ($user as $datasUser) {
            if ($datasUser->libelle == 'admin') {
                $isUserAdmin = true;
            }
            if (Hash::check($password, $datasUser->password)) {
                $ret = array('successLogin' => true, 'username' => $datasUser->username, 'sexe' => $datasUser->sexe, 'isuserisadmin' => $isUserAdmin);
            }
        }
        return $ret;
    }

    public function uploadFile(Request $request)
    {
        // print_r($request->file('image'));die;
        // $file = $request->file('image');
        // $filename = 'test.jpeg';
        // if ($file) {
        //     Storage::disk('local')->put($filename, File::get($file));
        // }
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            Storage::disk('images')->put($filename, File::get($file));
        } 
    }
}
