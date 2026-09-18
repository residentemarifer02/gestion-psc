<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
    Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');

    Route::get('/movimientos', [MovimientoController::class, 'index'])->name('movimientos.index');
    Route::get('/movimientos/nuevo', [MovimientoController::class, 'create'])->name('movimientos.create');
    Route::post('/movimientos', [MovimientoController::class, 'store'])->name('movimientos.store');

    Route::middleware('role:Administrador')->group(function () {
        Route::get('/movimientos/{movimiento}/editar', [MovimientoController::class, 'edit'])->name('movimientos.edit');
        Route::put('/movimientos/{movimiento}', [MovimientoController::class, 'update'])->name('movimientos.update');

        Route::middleware('password.confirm')->group(function () {
            Route::delete('/movimientos/{movimiento}', [MovimientoController::class, 'destroy'])->name('movimientos.destroy');
        });
    });

    // Proveedores
    Route::get('/proveedores', [ProveedorController::class, 'index'])->name('proveedores.index');

    Route::middleware('role:Administrador')->group(function () {
        Route::get('/proveedores/nuevo', [ProveedorController::class, 'create'])->name('proveedores.create');
        Route::post('/proveedores', [ProveedorController::class, 'store'])->name('proveedores.store');
        Route::get('/proveedores/{proveedor}/editar', [ProveedorController::class, 'edit'])->name('proveedores.edit');
        Route::put('/proveedores/{proveedor}', [ProveedorController::class, 'update'])->name('proveedores.update');
        Route::post('/proveedores/{proveedor}/productos', [ProveedorController::class, 'agregarProducto'])->name('proveedores.productos.store');
        Route::delete('/proveedores/{proveedor}/productos/{producto}', [ProveedorController::class, 'eliminarProducto'])->name('proveedores.productos.destroy');
        Route::post('/proveedores/{proveedor}/productos/{producto}/precios', [ProveedorController::class, 'registrarNuevoPrecio'])->name('proveedores.productos.precios.store');

        Route::middleware('password.confirm')->group(function () {
            Route::delete('/proveedores/{proveedor}', [ProveedorController::class, 'destroy'])->name('proveedores.destroy');
        });

        // Usuarios
        Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
        Route::get('/usuarios/nuevo', [UsuarioController::class, 'create'])->name('usuarios.create');
        Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
        Route::delete('/usuarios/{usuario}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
    });

    // Clientes
    Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
    Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');

    // Movimientos
    Route::get('/movimientos', [MovimientoController::class, 'index'])->name('movimientos.index');
    Route::get('/movimientos/nuevo', [MovimientoController::class, 'create'])->name('movimientos.create');
    Route::post('/movimientos', [MovimientoController::class, 'store'])->name('movimientos.store');

    Route::middleware('role:Administrador')->group(function () {
        Route::get('/movimientos/{movimiento}/editar', [MovimientoController::class, 'edit'])->name('movimientos.edit');
        Route::put('/movimientos/{movimiento}', [MovimientoController::class, 'update'])->name('movimientos.update');

        Route::middleware('password.confirm')->group(function () {
            Route::delete('/movimientos/{movimiento}', [MovimientoController::class, 'destroy'])->name('movimientos.destroy');
        });
    });

    Route::middleware('role:Administrador')->prefix('admin')->group(function () {
        Route::get('/', fn () => view('admin.panel'))->name('admin.panel');
    });

    Route::middleware('role:Gerente General')->prefix('gerencia')->group(function () {
        Route::get('/', fn () => view('gerencia.panel'))->name('gerencia.panel');
    });

    Route::middleware('role:Gerente')->prefix('gerente')->group(function () {
        Route::get('/', fn () => view('gerente.panel'))->name('gerente.panel');
    });
});

require __DIR__.'/auth.php';