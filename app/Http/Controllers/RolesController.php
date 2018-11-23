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
        // Cette m�thode doit retourn�e un array des colonnes de la table
        $cols = $colsQuery = $colsHidden = $colsSorting = $colsFilters = $colsWidths = $colsOrder = array();
        // $resDatas = DB::table('users as u')->join('roles as r', 'u.role_id', '=', 'r.role_id')->select()->get();
        $resCols = array_merge(Roles::$colsDataGrid);
        foreach ($resCols as $key => $arrCols) {
            // if ($arrCols['visible']) {
            array_push($cols, array(
                'name' => $key,
                'title' => $arrCols['label'],
                    // 'resizable' => $arrCols['resizable'],
            ));
            array_push($colsQuery, $key);
            // Columns hidden by default
            if (isset($arrCols['visible']) && !$arrCols['visible']) {
                array_push($colsHidden, $key);
            }
            // Columns which can order
            if (isset($arrCols['order']) && $arrCols['order']) {
                array_push($colsOrder, $key);
            }
            // Columns which can sort
            if (isset($arrCols['sorting']) && !$arrCols['sorting']) {
                $direction = 'asc';
                array_push($colsSorting, array(
                    'columnName' => $key,
                    'direction' => $direction,
                ));
            }
            // Default columns size
            $size = 180;
            if (isset($arrCols['width']) && !empty($arrCols['width'])) {
                $size = $arrCols['width'];
            }
            array_push($colsWidths, array(
                'columnName' => $key,
                'width' => $size,
            ));
        }
        $resDatas = DB::table('roles as r')->select($colsQuery)->get();
        $datas = $resDatas->map(function ($obj) {
            $arr = (array)$obj;
            return $arr;
        })->toArray();

        return array(
            'columns' => $cols,
            'columnsHidden' => $colsHidden,
            'columnsSorting' => $colsSorting,
            'columnsFilters' => $colsFilters,
            'columnsOrder' => $colsOrder,
            'columnsWidths' => $colsWidths,
            'datas' => $datas
        );
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
                'date_creation' => $request->get('date_creation')
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
        try {
            $role = Roles::find($request->get('role_id'));
            $role->libelle = $request->get('libelle');
            $role->date_creation = $request->get('date_creation');
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
