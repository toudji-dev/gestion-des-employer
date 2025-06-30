<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeAdminRequest;
use App\Http\Requests\submitDefineAccessRequest;
use App\Http\Requests\updateAdminRequest;
use App\Models\ResetCodePassword;
use App\Models\User;
use App\Notifications\SendEmailToAdminAfterRegistrationNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class AdminController extends Controller

{

    public  function __construct()
    {
        $this->middleware('permission:administrateur-liste')->only('index');
        $this->middleware('permission:administrateur-edit')->only('edit', 'update');
        $this->middleware('permission:administrateur-delete')->only('delete');
        //new Middleware(\Spatie\Permission\Middleware\RoleMiddleware::using('manager'), except: ['show']),
        $this->middleware('permission:administrateur-create')->only('create', 'store');
    }

    public function index()
    {

        $admins = User::simplePaginate(10);
        return view('admins/index', compact('admins'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admins/create', compact('roles'));
    }

    public function edit(User $user)
    {
        return view('admins/edit', compact('user'));
    }

    //Enregistrer un Admin en BD et envoyer un mail

    public function store(storeAdminRequest $request)
    {

        //dd($request);

        try {

            $role = Role::find($request->role);

            //dd($role);

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;

            $user->assignRole($role->name);

            $user->password = Hash::make('default');
            $user->save();

            //Envoyer un mail pour que l'utilisateur puisse confirmer son compte

            //Envoyer un code par email pour vérification
            if ($user) {

                try {
                    ResetCodePassword::where('email', $user->email)->delete();
                    $code = rand(1000, 4000);

                    $data = [
                        'code' => $code,
                        'email' => $user->email
                    ];
                    ResetCodePassword::create($data);

                    Notification::route('mail', $user->email)->notify(new SendEmailToAdminAfterRegistrationNotification($code, $user->email));

                    //Rediriger l'utilisateur vers une URL

                    return redirect()->route('administrateurs')->with('success_message', 'Administrateur ajouté');
                } catch (Exception $e) {
                    //dd($e);
                    throw new Exception('Une erreur est survenue lors de l\'envoie du mail');
                }
            }
        } catch (Exception $e) {
            //dd($e);
            throw new Exception('Une erreur est survenue lors de la création de cet administrateur');
        }
    }

    public function update(updateAdminRequest $request, User $user)
    {
        try {
            //Logique de mise a jour de compte
        } catch (Exception $e) {
            //dd($e);
            throw new Exception('Une erreur est survenue lors de la mise a jour des informations de l\'utilisateur');
        }
    }

    public function delete(User $user)
    {
        try {
            //Logique de suppression

            $connectedAdminId = Auth::user()->id;

            if ($connectedAdminId !== $user->id) {
                $user->delete();
                return redirect()->back()->with('success_message', 'L\'administrateur a été rétiré');
            } else {
                return redirect()->back()->with('error_message', 'Vous ne pouvez pas supprimer votre compte administrateur');
            }

            //L'admin connecté ne puisse pas supprimé son compte


        } catch (Exception $e) {
            //dd($e);
            throw new Exception('Une erreur est survenue lors de la suppression du compte de l\'admin');
        }
    }


    public function defineAccess($email)
    {

        $checkUserExist = User::where('email', $email)->first();

        if ($checkUserExist) {
            return view('auth.validate-account', compact('email'));
        } else {
            //Rediriger sur une route 404.
            // return redirect()->route('login');
        };
    }

    public function submitDefineAccess(submitDefineAccessRequest $request)
    {

        try {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                $user->password = Hash::make($request->password);
                $user->email_verified_at = Carbon::now();
                $user->update();

                //SI la maj s'est fait correctement
                $existingCode = ResetCodePassword::where('email', $user->email)->count();

                if ($existingCode >= 1) {
                    ResetCodePassword::where('email', $user->email)->delete();
                }
                //return redirect()->route('login')->with('success_message', 'Vos accès ont été correctement défini');

                return redirect()->route('login');
            }
        } catch (Exception $e) {
            //dd($e);
        }
    }

    public function search()
    {
        $search = request()->input('search');
        //dd($search);
        $admins = User::where('name', 'LIKE', '%' . $search . '%')->paginate(10);
        return view('admins.index', compact('admins'));
    }
}
