<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ChamadoController;
use App\Http\Controllers\Tecnico\ChamadoTecnicoController;
use App\Http\Controllers\Tecnico\UsuarioController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ExportarDadosController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::get('/', function () {
    return redirect('/login');
});

// Todas as rotas autenticadas
Route::middleware(['auth', 'verified'])->group(function () {

    // Redirecionamento após login baseado no perfil
    Route::get('/dashboard', function () {
        if (auth()->user()->isTecnico()) {
            return redirect()->route('tecnico.chamados.index');
        }

        return redirect()->route('chamados.index');
    })->name('dashboard');

    /**
     * Rotas do COLABORADOR
     */
    Route::middleware('verifica-perfil:colaborador')->group(function () {
        Route::resource('chamados', ChamadoController::class);
    });

    /**
     * Rotas do TÉCNICO
     */
    Route::prefix('tecnico')->name('tecnico.')->middleware('verifica-perfil:tecnico')->group(function () {
        Route::get('chamados', [ChamadoTecnicoController::class, 'index'])->name('chamados.index');
        Route::get('chamados/{chamado}', [ChamadoTecnicoController::class, 'show'])->name('chamados.show');
        Route::post('chamados/{chamado}/resposta', [ChamadoTecnicoController::class, 'responder'])->name('chamados.responder');
        Route::patch('chamados/{chamado}/status', [ChamadoTecnicoController::class, 'alterarStatus'])->name('chamados.status');

        Route::get('usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
        Route::patch('usuarios/{user}/permissao', [UsuarioController::class, 'alterarPermissao'])->name('usuarios.permissao');
    });
    
    Route::prefix('categorias')->group(function () {
        Route::get('', [CategoriaController::class, 'index'])->name('categorias.index');
        Route::post('', [CategoriaController::class, 'store'])->name('categorias.store');
        Route::put('/{categoria}', [CategoriaController::class, 'update'])->name('categorias.update');
        Route::delete('/{categoria}', [CategoriaController::class, 'delete'])->name('categorias.delete');
    });

    Route::get('/exportar-chamados-pdf', [ExportarDadosController::class, 'exportarPdf'])->name('chamados.exportar.pdf');
});
