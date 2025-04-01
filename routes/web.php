<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\AgenteController;

use App\Http\Middleware\ClienteMiddleware;
use App\Http\Middleware\AgenteMiddleware;
use App\Http\Middleware\AdminMiddleware;




Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', ClienteMiddleware::class])->group(function () {
    Route::get('/cliente/dashboard', [ClienteController::class, 'dashboard'])->name('cliente.dashboard');
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
});

Route::middleware(['auth', AgenteMiddleware::class])->group(function () {
    Route::get('/agente/dashboard', [AgenteController::class, 'dashboard'])->name('agente.dashboard');
    Route::get('/agente/tickets', [AgenteController::class, 'misTickets'])->name('agente.tickets');
    Route::get('/agente/tickets/{ticket}', [AgenteController::class, 'show'])->name('agente.tickets.show');
    
});

Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');
    Route::get('/admin/dashboard', [TicketController::class, 'estadisticasGlobales'])->name('admin.dashboard');
    Route::get('/admin/tickets/{ticket}', [TicketController::class, 'showDesdeAdmin'])->name('admin.tickets.show');
    Route::get('/admin/tickets', [TicketController::class, 'todosLosTickets'])->name('admin.tickets.index');
    Route::post('/admin/tickets/asignar-agente', [TicketController::class, 'asignarAgente'])->name('admin.tickets.asignar-agente');
    Route::post('/admin/usuarios', [UsuariosController::class, 'store'])->name('admin.usuarios.store');
    Route::put('/admin/usuarios/{id}', [UsuariosController::class, 'update'])->name('admin.usuarios.update');

    Route::prefix('admin/usuarios')->name('admin.usuarios.')->group(function () {   
        Route::get('/', [UsuariosController::class, 'index'])->name('index');
        Route::delete('/{id}', [UsuariosController::class, 'destroy'])->name('destroy');
    });
    
    Route::prefix('admin/categorias')->name('admin.categorias.')->group(function () {
        Route::get('/', [CategoriaController::class, 'index'])->name('index');
        Route::post('/', [CategoriaController::class, 'store'])->name('store');
        Route::put('/{id}', [CategoriaController::class, 'update'])->name('update');
        Route::delete('/{id}', [CategoriaController::class, 'destroy'])->name('destroy');
    });
    

});
