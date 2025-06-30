<?php

namespace App\Http\Controllers;

use App\Http\Requests\saveDepartementRequest;
use App\Models\Departement;
use Exception;
use Illuminate\Http\Request;
//use app\http\Middleware\PermissionMiddleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DepartementController extends Controller

{



    public  function __construct()
    {
        $this->middleware('permission:departement-liste')->only('index');
        $this->middleware('permission:departement-edit')->only('edit', 'update');
        $this->middleware('permission:departement-delete')->only('delete');
        //new Middleware(\Spatie\Permission\Middleware\RoleMiddleware::using('manager'), except: ['show']),
        $this->middleware('permission:departement-create')->only('create', 'store');
        $this->middleware('permission:departement-search')->only('search');
    }






    public function index()
    {
        $departements = Departement::simplePaginate(10);
        return view('departements.index', compact('departements'));
    }


    public function create()
    {
        return view('departements.create');
    }


    public function edit(Departement $departement)
    {
        return view('departements.edit', compact('departement'));
    }


    //Interraction avec la BD

    public function store(Departement $departement, saveDepartementRequest $request)
    {
        //Enregistrer un nouveau département
        try {



            $departement->name = $request->name;

            $departement->save();

            return redirect()->route('departement.index')->with('success_message', 'Departement enregistré.');
        } catch (Exception $e) {
            dd($e);
        }
    }
    public function update(Departement $departement, saveDepartementRequest $request)
    {
        //Enregistrer un nouveau département
        try {
            $departement->name = $request->name;

            $departement->update();

            return redirect()->route('departement.index')->with('success_message', 'Departement mis à jour.');
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function delete(Departement $departement)
    {
        //Enregistrer un nouveau département
        try {
            $departement->delete();

            return redirect()->route('departement.index')->with('success_message', 'Departement supprimé.');
        } catch (Exception $e) {
            dd($e);
        }
    }


    public function search()
    {

        $search = request()->input('search');
        //dd($search);
        $departements = Departement::where('name', 'LIKE', '%' . $search . '%')->paginate(10);
        return view('departements.index', compact('departements'));
    }
}
