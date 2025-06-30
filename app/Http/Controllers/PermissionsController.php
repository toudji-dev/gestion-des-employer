<?php

namespace App\Http\Controllers;

use App\Http\Requests\storePermitionRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class  PermissionsController extends Controller

{



    public  function __construct()
    {
        $this->middleware('permission:permission-liste')->only('index');
        $this->middleware('permission:permission-edit')->only('edit', 'update');
        $this->middleware('permission:permission-delete')->only('delete');
        //new Middleware(\Spatie\Permission\Middleware\RoleMiddleware::using('manager'), except: ['show']),
        $this->middleware('permission:permission-create')->only('create', 'store');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::simplePaginate(10);

        return view('permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storePermitionRequest $request)
    {

        Permission::create($request->only('name'));

        return redirect()->route('permissions.index')
            ->with('success_message', 'Autorisation élaborée avec succès.');
    }

    /**
     * Display the specified resource.
     */

    public function show() {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id
        ]);

        // dd($permission);

        $permission->update($request->only('name'));

        return redirect()->route('permissions.index')
            ->with('success_message', 'Autorisation mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Permission $permission)
    {
        //dd($permission);

        $permission->delete();

        return redirect()->route('permissions.index')
            ->with('success_message', 'Autorisation supprimée avec succès.');
    }

    public function search()
    {
        $search = request()->input('search');
        //dd($search);
        $permissions = Permission::where('name', 'LIKE', '%' . $search . '%')->simplePaginate(10);
        return view('permissions.index', compact('permissions'));
    }
}
