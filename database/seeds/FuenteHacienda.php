<?php

use Illuminate\Database\Seeder;

class FuenteHacienda extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('fuenteHacienda')->insert([
        	['codigo'=>'0112',
			'nombre'=>'Otros Distrito'],
			['codigo'=>'0138',
			'nombre'=>'Iva Cedido Licores'],
			['codigo'=>'01197',
			'nombre'=>'Espectaculos públicos y fondo de probres'],
			['codigo'=>'01272',
			'nombre'=>'SGP Propósito General Deporte'],
			['codigo'=>'01182',
			'nombre'=>'Recursos del Balance SGP Proposito General '],
			['codigo'=>'0137',
			'nombre'=>'Ica'],
			['codigo'=>'01177',
			'nombre'=>'Recursos del balance SGP propósito gral'],
			['codigo'=>'0139',
			'nombre'=>'IVA al servicio de Telefonía. Móvil'],
			['codigo'=>'01268',
			'nombre'=>'Recursos del Balance Reaforo Iva Telefonia Movil '],
			['codigo'=>'017',
			'nombre'=>'Credito '],
			['codigo'=>'01265',
			'nombre'=>'Recursos del Balance Plusvalía'],
			['codigo'=>'0112',
			'nombre'=>'Otros Distrito'],
			['codigo'=>'01370',
			'nombre'=>'Recursos del Balance Ica '],
			['codigo'=>'0138',
			'nombre'=>'IVA cedido de licores(Ley 788 de 2002)'],
			['codigo'=>'01286',
			'nombre'=>'Recursos del Balance reaforo Iva Cedido de licores'],
			['codigo'=>'01491',
			'nombre'=>'Recursos del Balance Iva Cedido de licores'],
			['codigo'=>'01182',
			'nombre'=>'Recursos del balance SGP propósito gral'],
			['codigo'=>'01431',
			'nombre'=>'Recursos del Balance Reaforo SGP Proposito General '],
			['codigo'=>'01522',
			'nombre'=>'Recursos del Balance Reaforo ICA'],
			['codigo'=>'01284',
			'nombre'=>'Recursos del balance reaforo Espectaculos públicos'],
			['codigo'=>'01364',
			'nombre'=>'Recursos de balance Fondo de Pobres y Espectaculs públicos '],
			['codigo'=>'01415',
			'nombre'=>'Recursos Pasivos Rendimientos Financieros Sgp'],
			['codigo'=>'0321',
			'nombre'=>'Recursos Administrados de libre destinación'],
			['codigo'=>'03201',
			'nombre'=>'Adminsitrados de Destinación Especifica'],
			['codigo'=>'03202',
			'nombre'=>'Fondo Cuenta pago Compensatorio'],
			['codigo'=>'03147',
			'nombre'=>'Recursos del balance de destinación especifica Fondo Compensatorio de Cesiones  Públicas - Cargas urbanisticas'],
			['codigo'=>'03147',
			'nombre'=>'Otros Recursos del Balance de destinación Específica, recursos rendimientos fondo compensatorio vigencia 2015'],
			['codigo'=>'03147',
			'nombre'=>'Otros Recursos de Balance de destinación Específica sobre recaudo a diciembre 31 de 2016, Fondo Cuenta pago Compensatorio de Cesiones Públicas'],
			['codigo'=>'03374',
			'nombre'=>'Otros Recursos del Balance de destinación específica (Valorización) PCC'],
			['codigo'=>'03441',
			'nombre'=>'Otros Recursos del Balance de destinación específica (Fondo Compensatorio). PCC'],
			['codigo'=>'03441',
			'nombre'=>'Otros Recursos del Balance de destinación específica (Valorización)PCC'],
			['codigo'=>'03502',
			'nombre'=>'Otros Recursos del Balance de destinación específica (Rendimientos Financieros) PCC'],
			['codigo'=>'03147',
			'nombre'=>'Otros Recursos del Balance de destinación específica (Recursos rendimientos aprovechamiento económico).'],
			['codigo'=>'0385',
			'nombre'=>'Pasivo Fondo Compensatorio '],
			['codigo'=>'03329',
			'nombre'=>'Pasivo Valorización acuerdo 180 de 2005'],
			['codigo'=>'03415',
			'nombre'=>'Recursos Pasivos Rendimientos Financieros Sgp'],
			['codigo'=>'0385',
			'nombre'=>'Pasivo Fondo Compensatorio '],
			['codigo'=>'03329',
			'nombre'=>'Pasivo Valorización acuerdo 180 de 2005']

        ]);
    }
}



