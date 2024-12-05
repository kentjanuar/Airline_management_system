<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\RegisterController;
use App\Models\Flight;

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

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login_auth'])->name('login_post');

Route::get('/flights', [TicketController::class, 'index'])->name('flights.index');
Route::get('/flights/ticket/{flight:id}', [TicketController::class, 'show'])->name('flights.show');
Route::get('/flights/book/{flight:id}', [TicketController::class, 'create'])->name('flights.create');
Route::post('/flights/{flight}/insert', [TicketController::class, 'insert'])->name('ticket.insert');
Route::put('/ticket/board/{ticket:id}', [TicketController::class, 'checkin'])->name('ticket.checkin');
Route::delete('/ticket/delete/{ticket:id}', [TicketController::class, 'delete'])->name('ticket.delete');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware(['admin'])->group(function () {
    Route::get('/admin', function () {
        $flights = Flight::all();
        return view('admin.dashboard', ['flights' => $flights]);
    })->name('admin.dashboard');

    Route::get('/admin/ticket/{flight:id}', [TicketController::class, 'show'])->name('admin.tickets.show');
    
    Route::get('/admin/flights/create', function () {
        return view('admin.createflight');
    })->name('admin.flights.create');
    Route::post('/admin/flights', [TicketController::class, 'store'])->name('admin.flights.store');
});