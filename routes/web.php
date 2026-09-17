<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProveedorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Proveedores: todos los roles pueden ver, solo Administrador crea/edita/borra
    Route::get('/proveedores', [ProveedorController::class, 'index'])->name('proveedores.index');

    Route::middleware('role:Administrador')->group(function () {
        Route::get('/proveedores/nuevo', [ProveedorController::class, 'create'])->name('proveedores.create');
        Route::post('/proveedores', [ProveedorController::class, 'store'])->name('proveedores.store');
        Route::get('/proveedores/{proveedor}/editar', [ProveedorController::class, 'edit'])->name('proveedores.edit');
        Route::put('/proveedores/{proveedor}', [ProveedorController::class, 'update'])->name('proveedores.update');
        Route::delete('/proveedores/{proveedor}', [ProveedorController::class, 'destroy'])->name('proveedores.destroy');
        Route::post('/proveedores/{proveedor}/productos', [ProveedorController::class, 'agregarProducto'])->name('proveedores.productos.store');
        Route::post('/proveedores/{proveedor}/productos/{producto}/precios', [ProveedorController::class, 'registrarNuevoPrecio'])->name('proveedores.productos.precios.store');
        Route::delete('/proveedores/{proveedor}/productos/{producto}', [ProveedorController::class, 'eliminarProducto'])->name('proveedores.productos.destroy');
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