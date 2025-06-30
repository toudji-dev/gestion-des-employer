<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class  RolesController extends Controller

{


    public  function __construct()
    {
        $this->middleware('permission:role-liste')->only('index');
        $this->middleware('permission:role-edit')->only('edit', 'update');
        $this->middleware('permission:role-delete')->only('delete');
        //new Middleware(\Spatie\Permission\Middleware\RoleMiddleware::using('manager'), except: ['show']),
        $this->middleware('permission:role-create')->only('create', 'store');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::latest()->simplePaginate(5);
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::get();
        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $role = Role::create(['name' => $request->get('name')]);
        $role->syncPermissions($request->get('permission'));

        return redirect()->route('roles.index')
            ->with('success_message', 'Rôle créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {

        //$role = $role;
        //dd($role);


        $rolePermissions = $role->permissions;


        return view('roles.show', compact('role', 'rolePermissions'));
    }
    public function showPermission(Role $role)
    {

        //$role = $role;
        // dd($role);


        $rolePermissions = $role->permissions;

        //dd($rolePermissions);
        return view('permissions.show-permission', compact('role', 'rolePermissions'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //$role = $role;
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        $permissions = Permission::get();

        return view('roles.edit', compact('role', 'rolePermissions', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Role $role, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'permission' => 'required',
        ]);

        $role->update($request->only('name'));

        $role->syncPermissions($request->get('permission'));

        return redirect()->route('roles.index')
            ->with('success_message', 'Rôle mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function delete(Role $role)
    {
        // dd($role);
        $role->delete();

        return redirect()->route('roles.index')
            ->with('success_message', 'Rôle supprimé avec succès.');
    }
    public function search()
    {
        $search = request()->input('search');
        //dd($search);
        $roles = Role::where('name', 'LIKE', '%' . $search . '%')->paginate(10);
        return view('roles.index', compact('roles'));
    }
}
