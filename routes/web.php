<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolesController;

Route::get('/', [AuthController::class, 'login'])->name('login');

Route::post('/', [AuthController::class, 'handleLogin'])->name('handleLogin');

Route::get('/reset/password', [AuthController::class, 'reset'])->name('reset.password');
Route::post('/reset/password', [AuthController::class, 'submitResetPassword'])->name('submitResetPassword');

Route::get('/reset-code-password/{email}', [AuthController::class, 'ResetCodePassword']);
Route::post('/store-reset-password/{email}', [AuthController::class, 'storeResetPassword'])->name('storeResetCodePassword');



Route::get('/validate-account/{email}', [AdminController::class, 'defineAccess']);
Route::post('/validate-account/{email}', [AdminController::class, 'submitDefineAccess'])->name('submitDefineAccess');

Route::get('dashboard', [AppController::class, 'index'])->name('dashboard');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');




Route::prefix('departements')->group(function () {
    Route::get('/', [DepartementController::class, 'index'])->name('departement.index');
    Route::get('/create', [DepartementController::class, 'create'])->name('departement.create');
    Route::post('/create', [DepartementController::class, 'store'])->name('departement.store');
    Route::get('/edit/{departement}', [DepartementController::class, 'edit'])->name('departement.edit');
    Route::put('/update/{departement}', [DepartementController::class, 'update'])->name('departement.update');

    Route::get('/{departement}', [DepartementController::class, 'delete'])->name('departement.delete');
});


Route::prefix('employers')->group(function () {
    Route::get('/', [EmployerController::class, 'index'])->name('employer.index');
    Route::get('/create', [EmployerController::class, 'create'])->name('employer.create');
    Route::get('/edit/{employer}', [EmployerController::class, 'edit'])->name('employer.edit');

    //Route d'actions

    Route::post('/store', [EmployerController::class, 'store'])->name('employe.store');
    Route::put('/update/{employer}', [EmployerController::class, 'update'])->name('employe.update');
    Route::get('/delete/{employer}', [EmployerController::class, 'delete'])->name('employer.delete');
    Route::get('/recherche', [EmployerController::class, 'search'])->name('employer.search');
});



Route::prefix('configurations')->group(function () {

    Route::get('/', [ConfigurationController::class, 'index'])->name('configurations');
    Route::get('/create', [ConfigurationController::class, 'create'])->name('configurations.create');


    //Route d'actions
    Route::post('/store', [ConfigurationController::class, 'store'])->name('configurations.store');

    Route::get('/delete/{configuration}', [ConfigurationController::class, 'delete'])->name('configurations.delete');
});

Route::prefix('administrateurs')->group(function () {

    Route::get('/', [AdminController::class, 'index'])->name('administrateurs');

    Route::get('/create', [AdminController::class, 'create'])->name('administrateurs.create');

    Route::post('/create', [AdminController::class, 'store'])->name('administrateurs.store');


    Route::get('/edit/{administrateur}', [AdminController::class, 'edit'])->name('administrateurs.edit');

    Route::put('/edit/{administrateur}', [AdminController::class, 'update'])->name('administrateurs.update');


    Route::get('/delete/{user}', [AdminController::class, 'delete'])->name('administrateurs.delete');
    Route::get('/recherche', [AdminController::class, 'search'])->name('administrateurs.search');
});

Route::prefix('payment')->group(function () {
    Route::get('/', [PaymentController::class, 'index'])->name('payments');
    Route::get('/make', [PaymentController::class, 'initPayment'])->name('payment.init');
    Route::get('/print/{payment}', [PaymentController::class, 'download'])->name('payment.download');
});


Route::prefix('profile')->group(function () {
    Route::get('/', [ProfileController::class, 'settings'])->name('settings');
    Route::post('/edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('account', [ProfileController::class, 'account'])->name('profile.account');
});



Route::resource('roles', RolesController::class);
Route::resource('permissions', PermissionsController::class);

Route::get('/show/{role}', [RolesController::class, 'showPermission'])->name('role.permissions');
Route::get('/recherche1', [RolesController::class, 'search'])->name('role.search');
Route::get('/delete/{role}', [RolesController::class, 'delete'])->name('roles.delete');


Route::get('permission/delete/{permission}', [PermissionsController::class, 'delete'])->name('permissions.delete');
Route::get('/recherche', [PermissionsController::class, 'search'])->name('permission.search');
