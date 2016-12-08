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
        	['Nombre'=>'LICITACION PÚBLICA'],
			['Nombre'=>'CONCURSO DE MERITOS'],
			['Nombre'=>'SELECCIÓN ABREVIADA DE MENOR CUANTIA'],
			['Nombre'=>'SELECCIÓN ABREVIADA POR SUBASTA'],
			['Nombre'=>'INVITACIÓN PÚBLICA'],
			['Nombre'=>'CONTRATACION DIRECTA'],
			['Nombre'=>'ADICIÓN'],
			['Nombre'=>'RESOLUCIÓN'],
			['Nombre'=>'OTROS (PLANTA TEMPORAL ... etc)']
        ]);
    }
}



