<?php

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



Route::any('/', 'MainController@index');
Route::any('/logout', 'MainController@logout');

	// Rutas paquete usuario

//Route::get('/personas/service/obtener/{id}', '\Idrd\Usuarios\Controllers\PersonaController@obtener');
Route::get('/personas/service/buscar/{key}', '\Idrd\Usuarios\Controllers\PersonaController@buscar');
Route::get('/personas/service/ciudad/{id_pais}', '\Idrd\Usuarios\Controllers\LocalizacionController@buscarCiudades');
//Route::post('/personas/service/procesar/', '\Idrd\Usuarios\Controllers\PersonaController@procesar');
Route::get('/permisos', 'Persona@index');

Route::get('/asignarActividad', '\Idrd\Usuarios\Controllers\AsignarActividadController@asignarActividades');
Route::get('/actividadesModulo', '\Idrd\Usuarios\Controllers\AsignarActividadController@moduloActividades');
Route::get('/actividadesPersona/{id}', '\Idrd\Usuarios\Controllers\AsignarActividadController@personaActividades');
Route::any('PersonasActividadesProceso', '\Idrd\Usuarios\Controllers\AsignarActividadController@PersonasActividadesProceso');

Route::get('/tipo_modulo', '\Idrd\Usuarios\Controllers\AsignarActividadController@tipoModulo');
Route::post('ProcesoTipoPersona', '\Idrd\Usuarios\Controllers\AsignarActividadController@AdicionTipoPersona');

//rutas con filtro de autenticación
Route::any('/welcome', 'MainController@welcome');
Route::any('/', 'MainController@index');


//rutas con filtro de autenticación
Route::group(['middleware' => ['web']], function () {
	//Route::get('/welcome', 'MainController@welcome');

Route::get('/personas', '\Idrd\Usuarios\Controllers\PersonaController@index');
// Rutas proyecto local

Route::post('/personas/service/procesar/', 'PaaController@procesar');
Route::get('/personas/service/obtener/{id}', 'PaaController@obtener');

Route::any('/obtener_area/', 'PaaController@obtener_area'); 
Route::any('/GestionarPaa/', 'PlanAnualAController@index'); 
Route::any('/AprobacionPaa/', 'ConsolidadoController@index'); 
Route::any('/Componente/', 'ConsolidadoController@componenteConsolidador'); 
Route::get('/configuracionPaa/proyecto/{id}', 'PaaController@proyecto'); 
Route::any('/asignarTipoPersona', 'PaaController@asignarTipoPersona');
Route::post('/configuracionPaa/validar/presupuesto/', 'PaaController@validar_presupuesto');
Route::post('/configuracionPaa/validar/plan_dearrollo/', 'PaaController@plan_dearrollo');
Route::post('/configuracionPaa/validar/fuente/', 'PaaController@validar_fuente');
Route::get('/configuracionPaa/plandesarrollo/eliminar/{id}', 'PaaController@eliminar_plandesarrollo');
Route::get('/configuracionPaa/plandesarrollo/modificar/{id}', 'PaaController@modificar_plan_datos');
Route::get('/configuracionPaa/presupuesto/eliminar/{id}', 'PaaController@eliminar_presupuesto');
Route::get('/configuracionPaa/presupuesto/modificar/{id}', 'PaaController@modificar_presupuesto');
Route::get('/configuracionPaa/fuente/modificarFuente/{id}', 'PaaController@modificarFuente');
Route::get('/configuracionPaa/fuente/eliminar/{id}', 'PaaController@eliminar_fuente');
Route::post('/configuracionPaa/validar/proyectoFinanza/', 'PaaController@validar_proyectoFinanza');
Route::get('/configuracionPaa/validar/consultaproyectoFinanza/{id}', 'PaaController@consultaproyectoFinanza');
Route::get('/configuracionPaa/validar/consultacomponenteFinanza/{id}', 'PaaController@consultacomponenteFinanza');
Route::post('/configuracionPaa/fuente/modificarFuenteProyecto/', 'PaaController@modificarFuenteProyecto');
Route::post('/configuracionPaa/fuente/modificarFuenteProyectoCompoente/', 'PaaController@modificarFuenteProyectoCompoente');
Route::post('/configuracionPaa/validar/proyectoFinanzaFuente/', 'PaaController@validar_proyectoFinanza_fuente');
Route::post('/configuracionPaa/validar/proyectoFinanzaFuenteCompoente/', 'PaaController@validar_proyectoFinanza_fuenteComponente');
Route::post('/configuracionPaa/validar/eliminarproyectoFinanza/', 'PaaController@eliminarproyectoFinanza');
Route::post('/configuracionPaa/validar/eliminarpresupestado/', 'PaaController@eliminarpresupestado');

Route::post('/configuracionPaa/validar/proyecto/', 'PaaController@validar_proyecto');
Route::get('/configuracionPaa/proyecto/eliminar/{id}', 'PaaController@eliminar_proyecto');
Route::get('/configuracionPaa/proyecto/modificar/{id}', 'PaaController@modificar_proyecto2');
Route::post('/configuracionPaa/validar/rubro_funcionamiento/', 'PaaController@rubro_funcionamiento');
Route::get('/configuracionPaa/rubrofuncionamiento/eliminar/{id}', 'PaaController@eliminarrubrofuncionamiento');
Route::get('/configuracionPaa/rubrofuncionamiento/modificar/{id}', 'PaaController@modificarrubrofuncionamiento');
Route::post('/configuracionPaa/validar/act_rubro_funcionamiento/', 'PaaController@act_rubro_funcionamiento');
Route::get('/configuracionPaa/Actividarubrofuncionamiento/eliminar/{id}', 'PaaController@ElimActividarubrofuncionamiento');
Route::get('/configuracionPaa/Actrubrofuncionamiento/modificar/{id}', 'PaaController@modificarActrubrofuncionamiento');

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

Route::get('/configuracionPaa/service/vigencia/{id}', 'PaaController@listadoVigencia');
Route::get('/configuracionPaa/service/presupuesto/{id}', 'PaaController@listadoProyectos');
Route::get('/configuracionPaa/service/meta/{id}', 'PaaController@listadoMetas');
Route::get('/configuracionPaa/service/actividad/{id}', 'PaaController@listadoActividad');

Route::get('/paa/service/select_area/{id}', 'PlanAnualAController@select_area');
Route::get('/paa/service/selectActividadesRubro/{id}', 'PlanAnualAController@selectActividadesRubro');
Route::post('/paa/service/selecActivMeta', 'PlanAnualAController@selecActivMeta');
Route::post('/paa/service/selectRubrosIngresados', 'PlanAnualAController@selectRubrosIngresados');
Route::post('/paa/service/selectMetasProyecto', 'PlanAnualAController@selectMetasProyecto');
Route::get('/paa/service/select_paVinculada/{id}', 'PlanAnualAController@select_paVinculada');
Route::post('/paa/service/fuenteComponente', 'PlanAnualAController@fuenteComponente');
Route::post('/paa/service/PresupuestoComponente', 'PlanAnualAController@PresupuestoComponente');
Route::get('/paa/service/select_meta/{id}', 'PlanAnualAController@select_meta');
Route::get('/paa/service/select_rubro/{id}', 'PlanAnualAController@select_rubro');
Route::get('/paa/service/select_meta_fuente/{id}', 'PlanAnualAController@select_meta_fuente');
Route::get('/paa/service/select_ProyectOrubro/{id}', 'PlanAnualAController@select_ProyectOrubro');
Route::get('/paa/service/VerFinanciamiento/{id}', 'PlanAnualAController@verFinanciacion');
Route::post('/paa/service/EliminarFinanciamiento/', 'PlanAnualAController@EliminarFinanciamiento');
Route::post('/paa/service/EliminarFinanciamientoRubro/', 'PlanAnualAController@EliminarFinanciamientoRubro');
Route::post('/paa/service/agregar_rubro/', 'PlanAnualAController@agregar_rubro');
Route::post('/paa/service/agregar_finza/', 'PlanAnualAController@agregar_finza');
Route::post('/paa/service/agregar_estudio/', 'PlanAnualAController@agregar_estudio');
Route::post('/paa/service/datos_vincular/', 'PlanAnualAController@datos_vincular');
Route::get('/paa/service/obtenerEstidioConveniencia/{id}', 'PlanAnualAController@obtenerEstidioConveniencia');
Route::get('/paa/service/obtenerPaa/{id}', 'PlanAnualAController@obtenerPaa');
Route::get('/paa/service/verificarCompartPaa/{id}', 'PlanAnualAController@verificarCompartPaa');
Route::get('/paa/service/siCompartirPaa/{id}', 'PlanAnualAController@siCompartirPaa');
Route::get('/paa/service/noCompartirPaa/{id}', 'PlanAnualAController@noCompartirPaa');
Route::get('/paa/service/obtenerHistorialPaa/{id}', 'PlanAnualAController@obtenerHistorialPaa');

Route::get('/paa/service/historialObservaciones/{id}', 'PlanAnualAController@historialObservaciones');
Route::post('/paa/service/RegistrarObservacion', 'PlanAnualAController@RegistrarObservacion');
Route::get('/paa/service/EliminarPaa/{id}', 'PlanAnualAController@EliminarPaa');
Route::get('/paa/service/HistorialEliminarPaa/{id}', 'PlanAnualAController@HistorialEliminarPaa');

Route::get('/aprobar/service/HistorialEliminarPaa/{id}', 'PlanAnualAController@HistorialEliminarPaa');
Route::get('/aprobar/service/obtenerHistorialPaa/{id}', 'PlanAnualAController@obtenerHistorialPaa');
Route::get('/aprobar/service/VerFinanciamiento/{id}', 'PlanAnualAController@verFinanciacion');
Route::post('/aprobar/service/DatosAprobacion', 'ConsolidadoController@DatosAprobacion');
Route::get('/aprobar/service/obtenerHistorialPaaTodo/{id}', 'PlanAnualAController@obtenerHistorialPaaTodo');
Route::get('/aprobar/service/aprobarSubDireccion/{id}', 'ConsolidadoController@aprobarSubDireccion');
Route::get('/aprobar/imprimir/{id}', 'ConsolidadoController@imprimir');
Route::get('/aprobar/service/historialObservaciones/{id}', 'ConsolidadoController@historialObservaciones');
Route::post('/aprobar/service/RegistrarObservacion', 'ConsolidadoController@RegistrarObservacion');

Route::post('/aprobar/service/AprobarEstudio', 'ConsolidadoController@AprobarEstudio');

Route::any('/PresupuestoPAA/', 'PaaController@index');
Route::get('AprobacionPaaSubDireccion', 'DireccionController@index');
Route::post('/rechazar/paa', 'DireccionController@rechazar');
Route::post('/cancelar/paa', 'DireccionController@cancelar');
Route::post('/enviar/paa', 'DireccionController@enviar');
Route::post('/aprobar/service/AprobarEstudioSub', 'DireccionController@AprobarEstudio');
Route::get('estudiopdf', 'DireccionController@descargarEstudio');
Route::get('/aprobar/service/validarEstudio/{id}', 'DireccionController@validarEstudio');
Route::post('/aprobar/service/RegistrarObservacionSubD', 'DireccionController@RegistrarObservacion');
Route::get('/aprobar/service/historialObservacionessubD/{id}', 'DireccionController@historialObservaciones');
Route::get('AprobacionPlaneacion', 'PlaneacionController@index');

Route::any('/GestionarPaaCompartida/', 'PaaCompartidoController@index'); 
Route::get('/paacompartida/service/historialObservaciones/{id}', 'PlanAnualAController@historialObservaciones');
Route::post('/paacompartida/service/RegistrarObservacion', 'PlanAnualAController@RegistrarObservacion');
Route::get('/paacompartida/service/VerFinanciamiento/{id}', 'PaaCompartidoController@verFinanciacion');

Route::get('AprobacionDireccion', 'DireccionGeneralController@index');
Route::get('/direccion/service/historialObservaciones/{id}', 'DireccionGeneralController@historialObservaciones');
Route::get('/direccion/service/obtenerHistorialPaaTodo/{id}', 'DireccionGeneralController@obtenerHistorialPaaTodo');
Route::get('/direccion/service/VerFinanciamiento/{id}', 'DireccionGeneralController@verFinanciacion');
Route::post('/direccion/service/RegistrarObservacion', 'DireccionGeneralController@RegistrarObservacion');

Route::any('/Generalpaa/', 'GeneralController@index'); 
Route::any('/GestionCecop/', 'CecopController@index'); 
Route::get('informececop', 'CecopController@descargarInformeCecop');

Route::get('reporteProyecto', 'ControllerReporteProyecto@index');
Route::get('/reporteProyecto/service/vigencias/{id}', 'ControllerReporteProyecto@select_vigencia');
Route::get('/reporteProyecto/service/proyecto/{id}', 'ControllerReporteProyecto@select_proyecto');
Route::post('/reporteProyecto/service/proyecto_finanza', 'ControllerReporteProyecto@proyecto_finanza');
Route::get('/reporteProyecto/service/obtenerPaaAprobado/{id}', 'ControllerReporteProyecto@obtenerPaaAprobado');
Route::get('/reporteProyecto/service/obtenerPaaReservado/{id}', 'ControllerReporteProyecto@obtenerPaaReservado');

Route::get('reporteGeneral', 'ControllerReporteGeneral@index');
Route::get('reporteGeneralOperario', 'ControllerReporteGeneral@index_operario');
Route::post('/reporteProyectoGeneral/validar_form', 'ControllerReporteGeneral@validar_form');
});
