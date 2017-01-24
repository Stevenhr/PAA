<?php

return array( 
 
  'conexion' => 'db_principal', 
   
  'modulo' => '35', 
  'prefijo_ruta' => 'personas', 
 
  'modelo_persona' => 'App\Persona', 
  'modelo_documento' => 'App\Documento', 
  'modelo_pais' => 'App\Pais', 
  'modelo_ciudad' => 'App\Ciudad', 
  'modelo_departamento' => 'App\Departamento', 
  'modelo_genero' => 'App\Genero', 
  'modelo_etnia' => 'App\Etnia', 
  'modelo_tipo' => 'App\Tipo',
  'modelo_acceso' => 'App\Acceso',
  'modelo_datos' => 'App\Datos',
  'modelo_asim' => 'App\ActividadesSim',
   
  //vistas que carga las vistas 
  'vista_lista' => 'list', 
 
  //lista 
  'lista'  => 'idrd.usuarios.lista', 
);