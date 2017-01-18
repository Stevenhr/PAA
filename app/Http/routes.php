<?php
session_start();
/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/actividad_usuario', function () {
    return view('persona_actividades');
});
Route::get('/usuario_tipo', function () {
    return view('persona_tipoPersona');
});

// Rutas paquete usuario
Route::get('/personas', '\Idrd\Usuarios\Controllers\PersonaController@index');
Route::get('/personas/service/obtener/{id}', '\Idrd\Usuarios\Controllers\PersonaController@obtener');
Route::get('/personas/service/buscar/{key}', '\Idrd\Usuarios\Controllers\PersonaController@buscar');
Route::get('/personas/service/ciudad/{id_pais}', '\Idrd\Usuarios\Controllers\LocalizacionController@buscarCiudades');
Route::post('/personas/service/procesar/', '\Idrd\Usuarios\Controllers\PersonaController@procesar');
Route::get('/permisos', 'Persona@index');

Route::get('/asignarActividad', '\Idrd\Usuarios\Controllers\AsignarActividadController@asignarActividades');
Route::get('/actividadesModulo', '\Idrd\Usuarios\Controllers\AsignarActividadController@moduloActividades');
Route::get('/actividadesPersona/{id}', '\Idrd\Usuarios\Controllers\AsignarActividadController@personaActividades');
Route::any('PersonasActividadesProceso', '\Idrd\Usuarios\Controllers\AsignarActividadController@PersonasActividadesProceso');
Route::get('/asignarTipoPersona', '\Idrd\Usuarios\Controllers\AsignarActividadController@asignarTipoPersona');
Route::get('/tipo_modulo', '\Idrd\Usuarios\Controllers\AsignarActividadController@tipoModulo');
Route::post('ProcesoTipoPersona', '\Idrd\Usuarios\Controllers\AsignarActividadController@AdicionTipoPersona');


// Rutas proyecto local
Route::any('/GestionarPaa/', 'PlanAnualAController@index'); 
Route::any('/AprobacionPaa/', 'ConsolidadoController@index'); 
Route::get('/configuracionPaa/proyecto/{id}', 'PaaController@proyecto'); 

Route::post('/configuracionPaa/validar/presupuesto/', 'PaaController@validar_presupuesto');
Route::get('/configuracionPaa/presupuesto/eliminar/{id}', 'PaaController@eliminar_presupuesto');
Route::get('/configuracionPaa/presupuesto/modificar/{id}', 'PaaController@modificar_presupuesto');

Route::post('/configuracionPaa/validar/proyecto/', 'PaaController@validar_proyecto');
Route::get('/configuracionPaa/proyecto/eliminar/{id}', 'PaaController@eliminar_proyecto');
Route::get('/configuracionPaa/proyecto/modificar/{id}', 'PaaController@modificar_proyecto2');

Route::post('/configuracionPaa/validar/meta/', 'PaaController@validar_meta');
Route::get('/configuracionPaa/meta/eliminar/{id}', 'PaaController@eliminar_meta');
Route::get('/configuracionPaa/meta/modificar/{id}', 'PaaController@modificar_meta2');

Route::post('/configuracionPaa/validar/actividad/', 'PaaController@validar_actividad');
Route::get('/configuracionPaa/actividad/eliminar/{id}', 'PaaController@eliminar_actividad');
Route::get('/configuracionPaa/actividad/modificar/{id}', 'PaaController@modificar_actividad2');

Route::post('/configuracionPaa/validar/componente/', 'PaaController@validar_componente');
Route::get('/configuracionPaa/componente/eliminar/{id}', 'PaaController@eliminar_componente');
Route::get('/configuracionPaa/componente/modificar/{id}', 'PaaController@modificar_componente2');

Route::post('/configuracionPaa/validar/componente_crear/', 'PaaController@validar_componente_Crear');
Route::get('/configuracionPaa/componente_crear/eliminar/{id}', 'PaaController@eliminar_componente_crear');
Route::get('/configuracionPaa/componente_crear/modificar/{id}', 'PaaController@modificar_componente_crear');

Route::post('/paa/validar/paa/', 'PlanAnualAController@validar_paa');

Route::get('/configuracionPaa/service/presupuesto/{id}', 'PaaController@listadoProyectos');
Route::get('/configuracionPaa/service/meta/{id}', 'PaaController@listadoMetas');
Route::get('/configuracionPaa/service/actividad/{id}', 'PaaController@listadoActividad');


Route::get('/paa/service/fuenteComponente/{id}', 'PlanAnualAController@fuenteComponente');
Route::get('/paa/service/VerFinanciamiento/{id}', 'PlanAnualAController@verFinanciacion');
Route::get('/paa/service/obtenerPaa/{id}', 'PlanAnualAController@obtenerPaa');
Route::get('/paa/service/obtenerHistorialPaa/{id}', 'PlanAnualAController@obtenerHistorialPaa');


Route::get('/paa/service/EliminarPaa/{id}', 'PlanAnualAController@EliminarPaa');
Route::get('/paa/service/HistorialEliminarPaa/{id}', 'PlanAnualAController@HistorialEliminarPaa');

Route::get('/aprobar/service/HistorialEliminarPaa/{id}', 'PlanAnualAController@HistorialEliminarPaa');
Route::get('/aprobar/service/obtenerHistorialPaa/{id}', 'PlanAnualAController@obtenerHistorialPaa');
Route::get('/aprobar/service/VerFinanciamiento/{id}', 'PlanAnualAController@verFinanciacion');
Route::post('/aprobar/service/DatosAprobacion', 'ConsolidadoController@DatosAprobacion');
Route::get('/aprobar/service/obtenerHistorialPaaTodo/{id}', 'PlanAnualAController@obtenerHistorialPaaTodo');
Route::get('/aprobar/service/aprobarSubDireccion/{id}', 'ConsolidadoController@aprobarSubDireccion');

Route::any('/PresupuestoPAA/', 'PaaController@index');
Route::any('/', 'MainController@index');
Route::any('/logout', 'MainController@logout');

Route::get('AprobacionPaaSubDireccion', 'DireccionController@index');
Route::post('/rechazar/paa', 'DireccionController@rechazar');
Route::post('/enviar/paa', 'DireccionController@enviar');

//rutas con filtro de autenticación
Route::group(['middleware' => ['web']], function () {
	Route::get('/welcome', 'MainController@welcome');
});
