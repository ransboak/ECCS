<?php

use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\UserController;
use App\Models\Collection;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if(Auth::user()){
        return redirect()->back();
    }else{
        return view('auth.login');
    }
});

Route::get('/change-password', [PageController::class, 'changePassword'])->middleware('auth')->name('password.change');
Route::get('/dashboard', [PageController::class, 'dashboard'])->middleware(['auth', 'verified', 'force.password.change'])->name('dashboard');


Route::middleware(['auth', 'force.password.change'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin', 'force.password.change'])->group(function () {
    Route::post('/addUser', [UserController::class, 'addUser'])->name('addUser');
    Route::get('/users', [PageController::class, 'getUsers'])->name('getUsers');
    Route::post('/editUser/{id}', [UserController::class, 'editUser'])->name('editUser');
});
Route::middleware(['auth', 'collector', 'force.password.change'])->group(function () {
    Route::post('/addCollection', [CollectionController::class, 'addCollection'])->name('addCollection');
});

Route::middleware(['auth', 'collector_manager', 'force.password.change'])->group(function () {
    Route::get('/collections', [PageController::class, 'collections'])->name('collections');
    Route::get('/customer/collections/{id}', [PageController::class, 'customerCollections'])->name('customerCollections');
});

Route::middleware(['auth', 'operator_collector_manager', 'force.password.change'])->group(function () {
    Route::get('/customers', [PageController::class, 'customers'])->name('customers');
});

// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::post('/addUser', [UserController::class, 'addUser'])->name('addUser');
//     Route::get('/users', [PageController::class, 'getUsers'])->name('getUsers');
// });


Route::middleware(['auth', 'manager', 'force.password.change'])->group(function () {
    Route::get('/dashboard/generalReport', [PageController::class, 'generalReport'])->name('generalReport');
    Route::get('/dashboard/reportDate', [PageController::class, 'reportDate'])->name('reportDate');
    // Route::post('/addCustomer', [CustomerController::class, 'addCustomer'])->name('addCustomer');
    Route::post('/approveRequest/{id}', [CustomerController::class, 'approveRequest'])->name('approveRequest');
    Route::post('/declineRequest/{id}', [CustomerController::class, 'declineRequest'])->name('declineRequest');
    Route::post('/dashboard/filterReport', [ReportController::class, 'filterReport'])->name('filterReport');
    Route::post('/dashboard/getCollections', [PageController::class, 'getCollections'])->name('getCollections');
    // Route::post('/dashboard/addRequest', [PageController::class, 'addRequest'])->name('addRequest');
    Route::get('/dashboard/allCollections', [PageController::class, 'allCollections'])->name('allCollections');
    Route::post('/dashboard/allDateCollections', [PageController::class, 'allDateCollections'])->name('allDateCollections');
    Route::get('/dashboard/branchReport', [PageController::class, 'branchReport'])->name('branchReport');
    // Route::get('/dashboard/customerRequest', [PageController::class, 'customerRequest'])->name('customerRequest');
});

Route::middleware(['auth', 'operator_manager', 'force.password.change'])->group(function () {
    Route::get('/dashboard/customerRequest', [PageController::class, 'customerRequest'])->name('customerRequest');
});

Route::middleware(['auth', 'operator', 'force.password.change'])->group(function () {
    Route::post('/dashboard/addRequest', [RequestController::class, 'addRequest'])->name('addRequest');
    Route::post('/dashboard/confirmRequest', [RequestController::class, 'confirmRequest'])->name('confirmRequest');
});

require __DIR__.'/auth.php';


Route::get('/momo/lookup', [CollectionController::class, 'momolookup'])->name('look');
