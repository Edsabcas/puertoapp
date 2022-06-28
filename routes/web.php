<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\AsignacionController;
use App\Http\Controllers\BoletaController;
use App\Http\Controllers\DescuentosController;
use App\Http\Controllers\ValidacionController;
use App\Http\Livewire\ImpresionComponent;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\PlatilloController;
use App\Http\Controllers\BebidaController;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\AdpedidoController;
use App\Http\Controllers\VerController;
use App\Http\Controllers\AgregarextraController;
use App\Http\Controllers\VerpedidoentregaController;
use App\Http\Controllers\EditarpedidoController;
use App\Http\Controllers\AlertacomprobanteController;
use App\Http\Controllers\ComprobantemesaordenController;
use App\Http\Controllers\TpropinaController;
use App\Http\Controllers\ReportesController;


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
    return view('home.index');
})->middleware('auth');

Route::get('/register', [RegisterController::class, 'create'])
->middleware('guest')
->name('register.create');

Route::get('impresion', function() {
    return view('cuenta.fel');
})->name('impresion');

//Rutas menu
Route::get('/EMPLEADOS', [EmpleadoController::class, 'index'])
->middleware('auth')->name('validacion.index');

Route::get('/CATEGORIAS', [CategoriaController::class, 'index'])
->middleware('auth')->name('categorias.index');

Route::get('/PLATILLOS', [PlatilloController::class, 'index'])
->middleware('auth')->name('platillos.index');

Route::get('/BEBIDAS', [BebidaController::class, 'index'])
->middleware('auth')->name('bebidas.index');

Route::get('/MESAS', [MesaController::class, 'index'])
->middleware('auth')->name('mesas.index');

Route::get('/TARIFA_PROPINAS', [TpropinaController::class, 'index'])
->middleware('auth')->name('propina.index');

Route::get('/AGREGAR_PEDIDO', [AdpedidoController::class, 'index'])
->middleware('auth')->name('add.index');

Route::get('/PENDIENTE_DE_ENTREGA', [VerController::class, 'index'])
->middleware('auth')->name('pe.index');

Route::get('/AGREGAR_EXTRA', [AgregarextraController::class, 'index'])
->middleware('auth')->name('agreg.index');

Route::get('/ENTREGADOS_EN_EL_DIA', [VerpedidoentregaController::class, 'index'])
->middleware('auth')->name('entre.index');

Route::get('/HISTORIAL_PEDIDOS', [EditarpedidoController::class, 'index'])
->middleware('auth')->name('edi.index');

Route::get('/SOLICITAR_CUENTA', [AlertacomprobanteController::class, 'index'])
->middleware('auth')->name('alerta.index');

Route::get('/IMPRIMIR_PEDIDOS', [ComprobantemesaordenController::class, 'index'])
->middleware('auth')->name('impr.index');

Route::get('/REPORTE_DIARIO', [ReportesController::class, 'index'])
->middleware('auth')->name('rep.index');




//ir a perfil
Route::get('/perfil', [SessionController::class, 'perfil'])
->middleware('auth')->name('login.perfil');

Route::post('/register', [RegisterController::class, 'store'])
->name('register.store');

Route::get('/login', [SessionController::class, 'index'])
->name('login.index');

Route::post('/login', [SessionController::class, 'store'])->name('login.store');


Route::get('/logout', [SessionController::class, 'destroy'])
->middleware('auth')->name('login.logout');


//Rutas para Empleados
Route::get('/personal', [PersonalController::class, 'index'])
->middleware('auth')->name('personal.index');

Route::get('/eliminar1/{id}', [PersonalController::class, 'destroy']);

//Ruta para AsignacionController
Route::get('/asignacion', [AsignacionController::class, 'index'])
->middleware('auth')->name('asignacion.index');

//Ruta para DescuentosController
Route::get('/descuentos', [DescuentosController::class, 'index'])
->middleware('auth')->name('descuentos.index');

//Ruta Generar PDFs
Route::get('/crearboletas', [BoletaController::class, 'index'])
->middleware('auth')->name('crearboletas.index');


Route::get('/imprimir', [ImpresionComponent::class, 'imprimir2'])->name('imprimir');