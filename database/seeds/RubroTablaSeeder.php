<?php

use Illuminate\Database\Seeder;

class RubroTablaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
          DB::table('rubro')->insert([
        	['Codigo'=>'1076',
			 'Nombre'=>'RENDIMIENTO DEPORTIVO AL  100X100'],
			['Codigo'=>'1077',
			 'Nombre'=>'TIEMPO ESCOLAR COMPLEMENTARIO'],
			['Codigo'=>'1082',
			 'Nombre'=>'CONSTRUCCIÓN Y ADECUACIÓN DE PARQUES Y EQUIPAMIENTOS PARA TODOS'],
			['Codigo'=>'1145',
			 'Nombre'=>'SOSTENIBILIDAD Y MEJORAMIENTO DE PARQUES, ESPACIOS DE VIDA'],
			['Codigo'=>'1146',
			 'Nombre'=>'RECREACIÓN ACTIVA 365'],
			['Codigo'=>'1147',
			 'Nombre'=>'DEPORTE MEJOR PARA TODOS'],
			['Codigo'=>'1148',
			 'Nombre'=>'FORTALECIMIENTO DE LA GESTIÓN INSTITUCIONAL DE CARA A LA CIUDADANÍA'],
			['Codigo'=>'1155',
			 'Nombre'=>'MODERNIZACIÓN INSTITUCIONAL'],
			['Codigo'=>'1200',
			 'Nombre'=>'MEJORAMIENTO DE LAS TECNOLOGÍAS DE LA INFORMACIÓN ORIENTADO A LA EFICIENCIA'],
			['Codigo'=>'3110204',
			 'Nombre'=>'REMUNERACIÓN SERVICIOS '],
			['Codigo'=>'3120101',
			 'Nombre'=>'DOTACIÓN'],
			['Codigo'=>'3120102',
			 'Nombre'=>'GASTOS DE COMPUTADOR '],
			['Codigo'=>'3120103',
			 'Nombre'=>'COMBUSTIBLE, LUBRICANTES Y LLANTAS'],
			['Codigo'=>'3120104',
			 'Nombre'=>'MATERIALES Y SUMINISTRO'],
			['Codigo'=>'3120105',
			 'Nombre'=>'COMPRA DE EQUIPO'],
			['Codigo'=>'3120203',
			 'Nombre'=>'GASTOS DE TRANSPORTE  Y COMUNICACIÓN '],
			['Codigo'=>'3120204',
			 'Nombre'=>'IMPRESOS Y PUBLICACIÓN'],
			['Codigo'=>'3120210',
			 'Nombre'=>'BIENESTAR E INCENTIVOS '],
			['Codigo'=>'3120211',
			 'Nombre'=>'PROMOCIÓN INSTITUCIONAL '],
			['Codigo'=>'3120212',
			 'Nombre'=>'SALUD OCUPACIONAL '],
			['Codigo'=>'3120302',
			 'Nombre'=>'IMPUESTOS, TASAS , CONTRIBUCIONES '],
			['Codigo'=>'311012501',
			 'Nombre'=>'PERSONAL ADMINISTRATIVO'],
			['Codigo'=>'3110125',
			 'Nombre'=>'CONVENCIONES COLECTIVAS'],
			['Codigo'=>'311020301',
			 'Nombre'=>'HONORARIOS ENTIDAD '],
			['Codigo'=>'312020501',
			 'Nombre'=>'MANTENIMIENTO ENTIDAD '],
			['Codigo'=>'312020601',
			 'Nombre'=>'SEGUROS ENTIDAD'],
			['Codigo'=>'312020901',
			 'Nombre'=>'CAPACITACIÓN INTERNA '],
			['Codigo'=>'312021399',
			 'Nombre'=>'OTROS PROGRAMAS Y CONVENIOS INSTITUCIONALES'],
			['Codigo'=>'312021400',
			 'Nombre'=>'OTROS PROGRAMAS Y CONVENIOS INSTITUCIONALES'],
			['Codigo'=>'312021401',
			 'Nombre'=>'OTROS PROGRAMAS Y CONVENIOS INSTITUCIONALES'],
			['Codigo'=>'312030102',
			 'Nombre'=>'OTRAS SENTENCIAS ']
        ]);
    }
}




