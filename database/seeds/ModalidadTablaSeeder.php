<?php

use Illuminate\Database\Seeder;

class ModalidadTablaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('modalidadseleccion')->insert([
        	["Nombre":"Solicitud de información a los Proveedores ", "Codigo":"CCE-01"],
            ["Nombre":"Licitación pública ", "Codigo":"CCE-02"],
            ["Nombre":"Concurso de méritos con precalificación", "Codigo":"CCE-03"],
            ["Nombre":"Concurso de méritos abierto", "Codigo":"CCE-04"],
            ["Nombre":"Contratación directa   ", "Codigo":"CCE-05"],
            ["Nombre":"Selección abreviada menor cuantía  ", "Codigo":"CCE-06"],
            ["Nombre":"Selección abreviada subasta inversa", "Codigo":"CCE-07"],
            ["Nombre":"Mínima cuantía ", "Codigo":"CCE-10"],
            ["Nombre":"Publicación contratación régimen especial - Selección de comisionista"  , "Codigo":"CCE-11||01"],
            ["Nombre":"Publicación contratación régimen especial - Enajenación de bienes para intermediarios idóneos", "Codigo":"CCE-11||02"],
            ["Nombre":"Publicación contratación régimen especial - Régimen especial"   , "Codigo":"CCE-11||03"],
            ["Nombre":"Publicación contratación régimen especial - Banco multilateral y organismos multilaterales" , "Codigo":"CCE-11||04"],
            ["Nombre":"Seléccion abreviada - acuerdo marco", "Codigo":"CCE-99"]
        ]);
    }
}






