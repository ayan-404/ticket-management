<?php

use App\Http\Controllers\TicketController;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});



Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [TicketController::class, 'index'])->name('dashboard');


Route::get('/dashboard/create', [TicketController::class, 'create'])->name('dashboard.create');
Route::get('/dashboard/{id}/edit', [TicketController::class, 'edit'])->name('dashboard.edit');
Route::get('/dashboard/{id}/checkout', [TicketController::class, 'checkoutPage'])->name('dashboard.checkoutPage');
Route::get('/dashboard/{id}/checkoutfinal', [TicketController::class, 'checkout'])->name('dashboard.checkout');
Route::get('/dashboard/{id}', [TicketController::class, 'update'])->name('dashboard.update');
Route::post('/dashboard/store', [TicketController::class, 'store'])->name('dashboard.store');
