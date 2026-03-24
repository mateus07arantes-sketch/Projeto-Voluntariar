<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OngController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoluntaryActionController;
use Illuminate\Support\Facades\Route;

// Rotas públicas
Route::get('/', function () {
    return view('welcome');
})->name('welcome')->middleware('guest');

// Rotas públicas de ONGs
Route::get('/ongs/waiting', [OngController::class, 'waiting'])->name('ongs.waiting');
Route::get('/ongs/create', [OngController::class, 'create'])->name('ongs.create');
Route::post('/ongs', [OngController::class, 'store'])->name('ongs.store');

// Rotas de usuário (públicas)
Route::get('/profile', [UserController::class, 'create'])->name('user.create');
Route::post('/profile', [UserController::class, 'store'])->name('user.store');

// Login
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');

// Rotas protegidas
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Voluntary Actions
    // Route::get('/voluntary-actions', [VoluntaryActionController::class, 'index'])->name('voluntary_actions.index');
    // Route::get('/voluntary-actions/{id}', [VoluntaryActionController::class, 'show'])->name('voluntary_actions.show');
    Route::resource('actions', VoluntaryActionController::class);

    // User Profile
    Route::get('/profile/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/profile', [UserController::class, 'update'])->name('user.update');

    // ONG Profile (CORRIGIDO)
    Route::get('/profile/ong/edit', [OngController::class, 'edit'])->name('profile.ong.edit');
    Route::put('/profile/ong', [OngController::class, 'update'])->name('profile.ong.update');

    // Admin ONG Management (mantenha o resource separado)
    Route::resource('ongs', OngController::class)->except(['create', 'store']);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Registrations
    Route::resource('registrations', RegistrationController::class)->only(['index', 'store', 'destroy']);
    Route::post('registrations/{registration}/mark-participation', [RegistrationController::class, 'markParticipation'])->name('registrations.markParticipation');

    // Admin Routes
    Route::get('/admin/ongs/pending', [OngController::class, 'pending'])->name('ongs.pending');
    Route::post('/admin/ongs/{ong}/approve', [OngController::class, 'approve'])->name('ongs.approve');
    Route::post('/admin/ongs/{ong}/reject', [OngController::class, 'reject'])->name('ongs.reject');
    // Detalhes da ONG para admin
    Route::get('/admin/ongs/{ong}/details', [OngController::class, 'showDetails'])->name('ongs.details');

    // Users Management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    // Editar um usuário específico
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');

    // Atualizar o usuário
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

    // Excluir o usuário
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/ong/actions/history', [VoluntaryActionController::class, 'ongHistory'])
        ->name('actions.ong.history');
});