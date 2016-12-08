<?php

use Illuminate\Database\Seeder;

class TipoContratoTablaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
         DB::table('tipocontrato')->insert([
        	['Nombre'=>'ADICIÓN'],
			['Nombre'=>'ADICIÓN Y PRORROGA'],
			['Nombre'=>'CONTRATO DE ACEPTACIÓN DE OFERTA '],
			['Nombre'=>'CONTRATO DE APROVECHAMIENTO ECONOMICO'],
			['Nombre'=>'CONTRATO DE ARRENDAMIENTO'],
			['Nombre'=>'CONTRATO DE COMISIÓN '],
			['Nombre'=>'CONTRATO DE COMPRAVENTA'],
			['Nombre'=>'CONTRATO DE CONSULTORIA '],
			['Nombre'=>'CONTRATO DE CORRETAJE DE SEGUROS'],
			['Nombre'=>'CONTRATO DE INTERVENTORÍA'],
			['Nombre'=>'CONTRATO DE LICENCIAMIENTO DE PAGO DE DERECHOS DE AUTOR '],
			['Nombre'=>'CONTRATO DE MANTENIMIENTO'],
			['Nombre'=>'CONTRATO DE PAGO DE DERECHOS CONEXOS'],
			['Nombre'=>'CONTRATO DE PRESTACIÓN DE SERVICIOS CON PROVEEDOR EXCLUSIVO'],
			['Nombre'=>'CONTRATO DE PRESTACIÓN DE SERVICIOS'],
			['Nombre'=>'CONTRATO DE PRESTACIÓN DE SERVICIOS ARTISTICOS'],
			['Nombre'=>'CONTRATO DE PRESTACIÓN DE SERVICIOS DE APOYO'],
			['Nombre'=>'CONTRATO DE PRESTACIÓN DE SERVICIOS DE APOYO A LA GESTION'],
			['Nombre'=>'CONTRATO DE PRESTACIÓN DE SERVICIOS PROFESIONALES'],
			['Nombre'=>'CONTRATO DE PRESTACIÓN DE SERVICIOS PROFESIONALES '],
			['Nombre'=>'CONTRATO DE SUMINISTRO'],
			['Nombre'=>'CONTRATO INTERADMINISTRATIVO'],
			['Nombre'=>'CONTRATO OBRA PÚBLICA'],
			['Nombre'=>'CONVENIO'],
			['Nombre'=>'CONVENIO COMERCIAL'],
			['Nombre'=>'CONVENIO DE ASOCIACIÓN '],
			['Nombre'=>'CONVENIO DE COOPERACIÓN'],
			['Nombre'=>'CONVENIO DE COOPERACIÓN EMPRESARIAL'],
			['Nombre'=>'CONVENIO DE COOPERACIÓN CORRESPONSABILIDAD '],
			['Nombre'=>'CONVENIO INTERADMINISTRATIVO'],
			['Nombre'=>'ORDEN DE COMPRA '],
			['Nombre'=>'OTROS'],
			['Nombre'=>'POR COMUNICACIONES PÚBLICA DE FONOGRAMAS'],
			['Nombre'=>'PRESTACIÓN DE SERVICIO (SONIDO, TRANSPORTE, ENTRE OTROS)'],
			['Nombre'=>'PRESTACIÓN DE SERVICIO DE APOYO A LA GESTIÓN O PROFESIONAL']
        ]);
    }
}



