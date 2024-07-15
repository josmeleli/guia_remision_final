<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransportistaController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\AgricultorController;
use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\ChoferController;
use App\Http\Controllers\CargaController;
use App\Http\Controllers\CampoController;
use App\Http\Controllers\FiltrosAvanzadosController;
use App\Http\Controllers\GuiaController;
use App\Http\Controllers\PagoController;


use App\Models\Pago;

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
    return view('menu');
});

// Ruta protegida por un Middleware
Route::middleware('auth')->group(function () {
    // Ruta para mostrar el menú (GET)
    Route::get('/', [VehiculoController::class, 'mostrarMenu'])->name('mostrar.menu')->middleware('can:mostrar.menu');

    // Ruta para almacenar un nuevo transportista (POST)
    Route::post('/transportista', [TransportistaController::class, 'store'])->name('transportista.store')->middleware('can:transportista.store');

    // Ruta para almacenar un nuevo vehículo (POST)
    Route::post('/vehiculo', [VehiculoController::class, 'store'])->name('vehiculo.store')->middleware('can:vehiculo.store');

    // Agricultores
    
    Route::post('agricultor/store', [AgricultorController::class, 'store'])->name('agricultor.store')->middleware('can:agricultor.store');
    Route::get('/agricultores', [AgricultorController::class, 'index'])->name('agricultor.index')->middleware('can:agricultor.index');
    Route::put('/agricultores/{agricultor}', [AgricultorController::class, 'update'])->name('agricultor.update')->middleware('can:agricultor.update');
    Route::delete('/agricultores/{agricultor}', [AgricultorController::class, 'destroy'])->name('agricultor.destroy')->middleware('can:agricultor.destroy');
    Route::delete('borrar-agricultores-seleccionados', [AgricultorController::class, 'borrarSeleccionados'])->name('agricultor.borrar_seleccionados')->middleware('can:agricultor.borrar_seleccionados');
    Route::get('/agricultor/buscar', [AgricultorController::class, 'buscarAgricultor'])->name('agricultor.buscar')->middleware('can:agricultor.buscar');

    // Campos
    Route::post('campo/store', [CampoController::class, 'store'])->name('campo.store')->middleware('can:campo.store');
    Route::get('/campos', [CampoController::class, 'index'])->name('campo.index')->middleware('can:campo.index');
    Route::put('/campos/{campo}', [CampoController::class, 'update'])->name('campo.update')->middleware('can:campo.update');
    Route::delete('/campos/{campo}', [CampoController::class, 'destroy'])->name('campo.destroy')->middleware('can:campo.destroy');
    Route::delete('borrar-campos-seleccionados', [CampoController::class, 'borrarSeleccionados'])->name('campo.borrar_seleccionados')->middleware('can:campo.borrar_seleccionados');
    Route::get('/campo/buscar', [CampoController::class, 'buscarCampo'])->name('campo.buscar')->middleware('can:campo.buscar');

    // Cargas
    Route::post('carga/store', [CargaController::class, 'store'])->name('carga.store')->middleware('can:carga.store');
    Route::get('/cargas', [CargaController::class, 'index'])->name('carga.index')->middleware('can:carga.index');
    Route::put('/cargas/{carga}', [CargaController::class, 'update'])->name('carga.update')->middleware('can:carga.update');
    Route::delete('/cargas/{carga}', [CargaController::class, 'destroy'])->name('carga.destroy')->middleware('can:carga.destroy');
    Route::delete('borrar-cargas-seleccionados', [CargaController::class, 'borrarSeleccionados'])->name('carga.borrar_seleccionados')->middleware('can:carga.borrar_seleccionados');
    Route::get('/cargas/buscar', [CargaController::class, 'buscarCarga'])->name('carga.buscar')->middleware('can:carga.buscar');

    // Conductores
    Route::post('conductor/store', [ChoferController::class, 'store'])->name('conductor.store')->middleware('can:conductores.store');
    Route::get('/conductores', [ChoferController::class, 'index'])->name('conductor.index')->middleware('can:conductores.index');
    
    Route::put('/conductores/{conductor}', [ChoferController::class, 'update'])->name('conductor.update')->middleware('can:conductores.update');
    Route::delete('/conductores/{conductor}', [ChoferController::class, 'destroy'])->name('conductor.destroy')->middleware('can:conductores.destroy');
    Route::delete('borrar-conductores-seleccionados', [ChoferController::class, 'borrarSeleccionados'])->name('chofer.borrar_seleccionados')->middleware('can:conductores.borrar_seleccionados');
    Route::get('/conductor/buscar', [ChoferController::class, 'buscarConductor'])->name('conductor.buscar')->middleware('can:conductores.buscar');

    // Guias de Remisión
    Route::post('/guia_remision/store', [GuiaController::class, 'store'])->name('guia_remision.store')->middleware('can:guia_remision.store');
    Route::get('/guia-remision', [GuiaController::class, 'index'])->name('guia-remision.index')->middleware('can:guia-remision.index');
    Route::put('/guias/{guia}', [GuiaController::class, 'update'])->name('guias.update')->middleware('can:guias.update');
    Route::delete('/guias/{guia}', [GuiaController::class, 'destroy'])->name('guias.destroy')->middleware('can:guias.destroy');
    Route::delete('borrar-guias-seleccionadas', [GuiaController::class, 'borrarSeleccionados'])->name('guia_remision.borrar_seleccionados')->middleware('can:guia_remision.borrar_seleccionados');
    Route::post('/verificar-ruc-agricultor', [GuiaController::class, 'verificarRuc'])->name('ruc.agricultor')->middleware('can:verificar-ruc-agricultor');
    Route::post('/verificar-ruc-transportista', [GuiaController::class, 'verificarRucTransportista'])->name('ruc.transportista')->middleware('can:verificar-ruc-transportista');
    Route::get('/reporte-guias', [GuiaController::class, 'reporteGuias'])->name('reporte.guias')->middleware('can:reporte.guias');
    Route::get('/crear-guia-remision', [GuiaController::class, 'create'])->name('crear_guia_remision')->middleware('can:crear_guia_remision');
    Route::get('/guia-remision/mostrar', [GuiaController::class, 'mostrarGuia'])->name('guia-remision.mostrar'); //falta poner en roles y permisos

    // Pagos
    Route::post('/crear-pago', [PagoController::class, 'store'])->name('pagos.store')->middleware('can:pagos.store');
    Route::get('/pagos', [PagoController::class, 'index'])->name('pago.index')->middleware('can:pago.index');
    Route::put('/pagos/{pago}', [PagoController::class, 'update'])->name('pago.update')->middleware('can:pago.update');
    Route::delete('/pagos/{pago}', [PagoController::class, 'destroy'])->name('pago.destroy')->middleware('can:pago.destroy');
    Route::delete('borrar-pagos-seleccionados', [PagoController::class, 'borrarSeleccionados'])->name('pago.borrar_seleccionados')->middleware('can:pago.borrar_seleccionados');
    Route::get('/pago/buscar', [PagoController::class, 'buscarPago'])->name('pago.buscar')->middleware('can:pago.buscar');

    // Transportistas
    Route::get('/transportistas', [TransportistaController::class, 'index'])->name('transportista.index')->middleware('can:transportista.index');
    Route::put('/transportistas/{transportista}', [TransportistaController::class, 'update'])->name('transportista.update')->middleware('can:transportista.update');
    Route::delete('/transportistas/{transportista}', [TransportistaController::class, 'destroy'])->name('transportista.destroy')->middleware('can:transportista.destroy');
    Route::delete('borrar-transportistas-seleccionados', [TransportistaController::class, 'borrarSeleccionados'])->name('transportista.borrar_seleccionados')->middleware('can:transportista.borrar_seleccionados');
    Route::get('/transportista/buscar', [TransportistaController::class, 'buscarTransportista'])->name('transportista.buscar')->middleware('can:transportista.buscar');
    

    // Vehículos
    Route::get('/vehiculos', [VehiculoController::class, 'index'])->name('vehiculo.index')->middleware('can:vehiculo.index');
    Route::put('/vehiculos/{vehiculo}', [VehiculoController::class, 'update'])->name('vehiculo.update')->middleware('can:vehiculo.update');
    Route::delete('/vehiculos/{vehiculo}', [VehiculoController::class, 'destroy'])->name('vehiculo.destroy')->middleware('can:vehiculo.destroy');
    Route::delete('borrar-vehiculos-seleccionados', [VehiculoController::class, 'borrarSeleccionados'])->name('vehiculo.borrar_seleccionados')->middleware('can:vehiculo.borrar_seleccionados');
    Route::get('/vehiculo/buscar', [VehiculoController::class, 'buscarVehiculo'])->name('vehiculo.buscar')->middleware('can:vehiculo.buscar');

    

    // Usuarios
    Route::get('/users', [UserController::class, 'index'])->middleware('can:users.index')->name('users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->middleware('can:users.edit')->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->middleware('can:users.update')->name('users.update');
    Route::post('/users', [UserController::class, 'store'])->middleware('can:users.store')->name('users.store');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->middleware('can:users.destroy')->name('users.destroy');

    // Sistema de Mensajes
    Route::post('/enviar-mensaje', [UserController::class, 'enviarMensaje'])->name('enviarMensaje.store');
    Route::delete('/eliminar-mensaje/{mensaje}', [UserController::class, 'eliminarMensaje'])->name('eliminarMensaje.destroy');
    Route::delete('/eliminar-todos-mensajes', [UserController::class, 'eliminarTodosMensajes'])->name('eliminarTodosMensajes.destroy');

    //Auditorias
    Route::get('/auditorias', [AuditoriaController::class, 'index'])->name('auditorias.index');//falta poner en roles y permisos
    Route::delete('/auditorias/{auditoria}', [AuditoriaController::class, 'destroy'])->name('auditorias.destroy');//falta poner en roles y permisos
    Route::delete('borrar-auditorias-seleccionadas', [AuditoriaController::class, 'borrarSeleccionados'])->name('auditorias.borrar_seleccionados');//falta poner en roles y permisos
    Route::get('/auditorias/buscar', [AuditoriaController::class, 'buscarAuditoria'])->name('auditorias.buscar'); //falta poner en roles y permisos
    
});







