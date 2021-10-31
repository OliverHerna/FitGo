<?php

use App\Http\Controllers\PaqueteUserController;
use App\Order;
use App\PaqueteUser;
use App\User;
use Illuminate\Support\Facades\Route;
//I import this to solve a error in line
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['register' => false]);

Route::get('/', 'HomeController@index')->name('home');

// Control panel section routes
Route::prefix('panel_de_control')->group(function () {
    // Users
    Route::put('usuarios/{user}/restablecer', 'UserController@restore')->name('usuarios.restore');
    Route::put('usuarios/{user}/borrar', 'UserController@forceDelete')->name('usuarios.forceDelete');
    Route::get('usuarios/bitacora', 'UserController@log')->name('usuarios.log');
    Route::resource('usuarios', 'UserController')->parameters([
        'usuarios' => 'user'
    ]);

    // Roles
    Route::put('roles/{role}/restablecer', 'RoleController@restore')->name('roles.restore');
    Route::put('roles/{role}/borrar', 'RoleController@forceDelete')->name('roles.forceDelete');
    Route::resource('roles', 'RoleController')->parameters([
        'roles' => 'role'
    ]);

    // Paquetes
    Route::resource('paquetes', 'PaqueteController')->parameters([
        'paquetes' => 'paquete'
    ]);

    // Bnenefits
    Route::resource('benefits', 'BenefitController')->parameters([
        'benefits' => 'benefit'
    ]);

    //Clients
    Route::resource('clients', 'ClientController')->parameters([
        'clients' => 'client'
    ]);

    Route::get('/{user}/{paquete}', 'PaqueteUserController@store')->name('storePaqueteUser');
    Route::post('packageClient/store', 'PaqueteUserController@storePackageClient')->name('packageClient');
});

Route::resource('orders', 'OrderController')->parameters([
    'orders' => 'order'
]);

Route::resource('reports', 'ReportController')->parameters([
    'reports' => 'report'
]);
Route::get('download/reports', 'ClientController@reports')->name('clients.reports');

/*
Route::resource('paquete_users', 'PaqueteUserController')->parameters([
    'paquete_users' => 'paquete_user'
]);*/

Route::get('paquete_users/{user}', 'PaqueteUserController@profile')->name('paquete_users.profile');
Route::get('paquete_users/description_modal', 'PaqueteUserController@description_modal');


Route::get('order/{id}', function ($id) {
    $order = Order::find($id);

    dd($order->userName);
});