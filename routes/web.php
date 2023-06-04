<?php


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

/*
INDEX CONTROLLER
*/
Route::get('/', [\App\Http\Controllers\IndexController::class,'inicio'])->name('dashboard');
Route::get('/dashboard', [\App\Http\Controllers\IndexController::class,'inicio']);
Route::get('/getAllProductos/{nombre}', [\App\Http\Controllers\IndexController::class,'getAllProductos']);
Route::get('/inicio', [\App\Http\Controllers\IndexController::class,'verPagina']);
Route::get('/enviarConsulta', [\App\Http\Controllers\IndexController::class,'enviarConsulta']);
Route::get('/enviarPublicidad', [\App\Http\Controllers\IndexController::class,'enviarPublicidad']);
Route::get('/verPolitica', [\App\Http\Controllers\IndexController::class,'verPolitica']);

Route::post('/enviarMensajeConsulta', [\App\Http\Controllers\IndexController::class,'enviarMensajeConsulta']);
Route::get('/buscarCategorias', [\App\Http\Controllers\IndexController::class,'buscarCategorias']);
Route::get('/buscarColores', [\App\Http\Controllers\IndexController::class,'buscarColores']);
Route::get('/buscarCategoriasHijos', [\App\Http\Controllers\IndexController::class,'buscarCategoriasHijos']);
Route::get('/buscarCantOfetasTotal', [\App\Http\Controllers\IndexController::class,'buscarCantOfetasTotal']);
Route::get('/buscar', [\App\Http\Controllers\IndexController::class,'buscar']);
Route::get('/buscarTexto', [\App\Http\Controllers\IndexController::class,'buscarTexto']);
Route::get('/buscarBanner', [\App\Http\Controllers\IndexController::class,'buscarBanner']);
Route::get('/filtrar', [\App\Http\Controllers\IndexController::class,'filtrar']);


/*
USUARIOS CONTROLLER
*/
Route::middleware(['auth:sanctum', 'verified'])->get('/verUsuarios', [\App\Http\Controllers\UsersController::class,'verUsuarios']);
Route::middleware(['auth:sanctum', 'verified'])->post('/habilitarUsuario/{id}', [\App\Http\Controllers\UsersController::class,'habilitarUsuario']);

Route::middleware(['auth:sanctum', 'verified'])->post('/eliminarUsuario/{id}', [\App\Http\Controllers\UsersController::class,'eliminarUsuario']);
Route::middleware(['auth:sanctum', 'verified'])->post('/eliminarConsulta/{id}', [\App\Http\Controllers\UsersController::class,'eliminarConsulta']);
Route::middleware(['auth:sanctum', 'verified'])->get('/verVentas', [\App\Http\Controllers\UsersController::class,'verVentas']);
Route::middleware(['auth:sanctum', 'verified'])->get('/verConsultas', [\App\Http\Controllers\UsersController::class,'verConsultas']);


/*
NEGOCIOS CONTROLLER
*/

Route::middleware(['auth:sanctum', 'verified'])->get('/verNegocios', [\App\Http\Controllers\VendedoresController::class,'verNegocios']);
Route::middleware(['auth:sanctum', 'verified'])->get('/verNegocioDueno', [\App\Http\Controllers\VendedoresController::class,'verNegocioDueno']);
Route::get('/verProductosVendedor', [\App\Http\Controllers\VendedoresController::class,'verProductosVendedor']);


Route::middleware(['auth:sanctum', 'verified'])->post('/guardarNegocio', [\App\Http\Controllers\VendedoresController::class,'guardarNegocio']);
Route::middleware(['auth:sanctum', 'verified'])->post('/borrarNegocio/{id}', [\App\Http\Controllers\VendedoresController::class,'borrarNegocio']);
Route::middleware(['auth:sanctum', 'verified'])->get('/verNegocioDetalle/{id}', [\App\Http\Controllers\VendedoresController::class,'verNegocioDetalle']);
Route::middleware(['auth:sanctum', 'verified'])->get('/verOfertas/{id}', [\App\Http\Controllers\VendedoresController::class,'verOfertas']);
Route::post('/comprarProducto', [\App\Http\Controllers\VendedoresController::class,'comprarProducto']);
Route::middleware(['auth:sanctum', 'verified'])->post('/aceptarOferta/{id}', [\App\Http\Controllers\VendedoresController::class,'aceptarOferta']);
Route::middleware(['auth:sanctum', 'verified'])->post('/rechazarOferta/{id}', [\App\Http\Controllers\VendedoresController::class,'rechazarOferta']);

Route::middleware(['auth:sanctum', 'verified'])->post('/actualizarDueno', [\App\Http\Controllers\VendedoresController::class,'actualizarDueno']);
Route::middleware(['auth:sanctum', 'verified'])->post('/borrarDueno/{id}', [\App\Http\Controllers\VendedoresController::class,'borrarDueno']);

/*
PRODUCTOS CONTROLLER
*/
Route::middleware(['auth:sanctum', 'verified'])->get('/verProductos', [\App\Http\Controllers\ProductosController::class,'verProductos']);
Route::middleware(['auth:sanctum', 'verified'])->post('/guardarProducto', [\App\Http\Controllers\ProductosController::class,'guardarProducto']);
Route::middleware(['auth:sanctum', 'verified'])->post('/borrarProducto/{id}', [\App\Http\Controllers\ProductosController::class,'borrarProducto']);
Route::middleware(['auth:sanctum', 'verified'])->post('/habilitarProducto/{id}', [\App\Http\Controllers\ProductosController::class,'habilitarProducto']);
Route::get('/verProductoDetalle/{nomCat}/{producto}', [\App\Http\Controllers\ProductosController::class,'verProductoDetalle']);
Route::get('/verProductosCategoria/{nombre}', [\App\Http\Controllers\ProductosController::class,'verProductosCategoria']);
Route::middleware(['auth:sanctum', 'verified'])->get('/verPerfilProducto/{id}', [\App\Http\Controllers\ProductosController::class,'verPerfilProducto']);
Route::middleware(['auth:sanctum', 'verified'])->post('/editarProducto', [\App\Http\Controllers\ProductosController::class,'editarProducto']);
Route::middleware(['auth:sanctum', 'verified'])->get('/verEstadoProducto', [\App\Http\Controllers\ProductosController::class,'verEstadoProducto']);
Route::middleware(['auth:sanctum', 'verified'])->get('/verColoresProducto', [\App\Http\Controllers\ProductosController::class,'verColoresProducto']);
Route::middleware(['auth:sanctum', 'verified'])->post('/guardarEstadoProducto', [\App\Http\Controllers\ProductosController::class,'guardarEstadoProducto']);
Route::middleware(['auth:sanctum', 'verified'])->post('/guardarColorProducto', [\App\Http\Controllers\ProductosController::class,'guardarColorProducto']);
Route::middleware(['auth:sanctum', 'verified'])->post('/borrarEstadoProducto/{id}', [\App\Http\Controllers\ProductosController::class,'borrarEstadoProducto']);
Route::middleware(['auth:sanctum', 'verified'])->get('/verPrecios', [\App\Http\Controllers\ProductosController::class,'verPrecios']);
Route::middleware(['auth:sanctum', 'verified'])->post('/guardarPrecioProducto', [\App\Http\Controllers\ProductosController::class,'guardarPrecioProducto']);
Route::middleware(['auth:sanctum', 'verified'])->post('/actualizarTodosPrecios/{cantidad}', [\App\Http\Controllers\ProductosController::class,'actualizarTodosPrecios']);
Route::middleware(['auth:sanctum', 'verified'])->post('/editarCategoria', [\App\Http\Controllers\ProductosController::class , 'editarCategoria']);
Route::middleware(['auth:sanctum', 'verified'])->post('/editarProvincia', [\App\Http\Controllers\ProductosController::class , 'editarProvincia']);
Route::middleware(['auth:sanctum', 'verified'])->post('/editarEstado', [\App\Http\Controllers\ProductosController::class , 'editarEstado']);
Route::middleware(['auth:sanctum', 'verified'])->post('/editarPrecio', [\App\Http\Controllers\ProductosController::class , 'editarPrecio']);
Route::middleware(['auth:sanctum', 'verified'])->post('/editarColor', [\App\Http\Controllers\ProductosController::class , 'editarColor']);
Route::middleware(['auth:sanctum', 'verified'])->post('/eliminarFotoProducto/{id}', [\App\Http\Controllers\ProductosController::class , 'eliminarFotoProducto']);
Route::middleware(['auth:sanctum', 'verified'])->post('/agregarFotos', [\App\Http\Controllers\ProductosController::class , 'agregarFotos']);

/*
CATEGORIA CONTROLLER
*/
Route::middleware(['auth:sanctum', 'verified'])->get('/verCategoria', [\App\Http\Controllers\CategoriasController::class,'verCategoria']);
Route::middleware(['auth:sanctum', 'verified'])->post('/guardarCategoria', [\App\Http\Controllers\CategoriasController::class,'guardarCategoria']);
Route::middleware(['auth:sanctum', 'verified'])->post('/borrarCategoria/{id}', [\App\Http\Controllers\CategoriasController::class,'borrarCategoria']);
Route::middleware(['auth:sanctum', 'verified'])->get('/verProvincias', [\App\Http\Controllers\CategoriasController::class,'verProvincias']);
Route::middleware(['auth:sanctum', 'verified'])->post('/guardarProvincia', [\App\Http\Controllers\CategoriasController::class,'guardarProvincia']);
Route::middleware(['auth:sanctum', 'verified'])->post('/borrarProvincia/{id}', [\App\Http\Controllers\CategoriasController::class,'borrarProvincia']);
Route::middleware(['auth:sanctum', 'verified'])->get('/verBanner', [\App\Http\Controllers\CategoriasController::class,'verBanner']);
Route::middleware(['auth:sanctum', 'verified'])->post('/guardarBanner', [\App\Http\Controllers\CategoriasController::class,'guardarBanner']);
Route::middleware(['auth:sanctum', 'verified'])->post('/activarBanner/{id}', [\App\Http\Controllers\CategoriasController::class,'activarBanner']);
Route::middleware(['auth:sanctum', 'verified'])->post('/desactivarBanner/{id}', [\App\Http\Controllers\CategoriasController::class,'desactivarBanner']);
Route::middleware(['auth:sanctum', 'verified'])->post('/borrarBanner/{id}', [\App\Http\Controllers\ProductosController::class,'borrarBanner']);
