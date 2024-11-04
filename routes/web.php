<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Models\Flight;
use App\Models\Ticket;


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
    return view('welcome');
});

Route::get('/base', function () {
    return view('base.base');
});

Route::get('/login',function(){
    return view('logins');
});


Route::get('/flights', function () {
    return view('flights', ['flight' => Flight::all()]);
});

Route::get('/flights', [TicketController::class, 'index'])->name('flights.index');

Route::get('/flights/ticket/{flight:id}', [TicketController::class, 'show'])->name('flights.show');

Route::get('/flights/book/{flight:id}', [TicketController::class, 'create'])->name('flights.create');

Route::post('/flights/{flight}/insert', [TicketController::class, 'insert'])->name('ticket.insert');

Route::put('/ticket/board/{ticket:id}', [TicketController::class, 'checkin'])->name('ticket.checkin');

Route::delete('/ticket/delete/{ticket:id}', [TicketController::class, 'delete'])->name('ticket.delete');

