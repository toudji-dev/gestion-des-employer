<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeRequest;
use App\Http\Requests\UpdateEmployerRequest;
use App\Models\Departement;
use App\Models\Employer;
use Exception;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class EmployerController extends Controller

{


    public  function __construct()
    {
        $this->middleware('permission:employer-liste')->only('index');
        $this->middleware('permission:employer-edit')->only('edit', 'update');
        $this->middleware('permission:employer-delete')->only('delete');
        //new Middleware(\Spatie\Permission\Middleware\RoleMiddleware::using('manager'), except: ['show']),
        $this->middleware('permission:employer-create')->only('create', 'store');
    }


    public function index()
    {
        $employers = Employer::with('departement')->simplePaginate(10);
        return view('employers.index', compact('employers'));
    }


    public function create()
    {
        $departements = Departement::all();
        return view('employers.create', compact('departements'));
    }


    public function edit(Employer $employer)
    {
        $departements = Departement::all();
        return view('employers.edit', compact('employer', 'departements'));
    }


    public function store(StoreEmployeRequest $request)
    {
        try {
            $query = Employer::create($request->all());
            if ($query) {
                return redirect()->route('employer.index')->with('success_message', 'Employer ajouté');
            }
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function update(UpdateEmployerRequest $request, Employer $employer)
    {
        try {
            $employer->nom = $request->nom;
            $employer->prenom = $request->prenom;
            $employer->email = $request->email;
            $employer->contact = $request->contact;
            $employer->departement_id = $request->departement_id;
            $employer->montant_journalier = $request->montant_journalier;


            $employer->update();


            return redirect()->route('employer.index')->with('success_message', 'Les informations de l\'employer ont été mise à jour');
        } catch (Exception $e) {
            dd($e);
        }
    }


    public function delete(Employer $employer)
    {
        try {
            $employer->delete();

            return redirect()->route('employer.index')->with('success_message', 'Employer retirer');
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function search()
    {
        $search = request()->input('search');
        //dd($search);
        $employers = Employer::where('nom', 'LIKE', '%' . $search . '%')->paginate(10);
        return view('employers.index', compact('employers'));
    }
}
