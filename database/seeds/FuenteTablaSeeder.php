<?php

use Illuminate\Database\Seeder;

class FuenteTablaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
         DB::table('fuente')->insert([
        	['codigo'=>'11030201', 'nombre'=>'RECURSOS ADMINISTRADOS DESTINACIÓN ESPECIFICA	'],
			['codigo'=>'11030201', 'nombre'=>'OTRAS RENTAS CONTRACTUALES	11030201 CIGARRILLOS 	'],
			['codigo'=>'11030201', 'nombre'=>'ESPECTÁCULOS PÚBLICOS 	11030202 FONDO CUENTA PAGO COMPENSATORIO	'],
			['codigo'=>'1103021', 'nombre'=>'RECURSOS ADMINISTRADOS LIBRE DESTINACIÓN	'],
			['codigo'=>'1103021', 'nombre'=>'APROVECHAMIENTO ECONÓMICO 	'],
			['codigo'=>'1103021', 'nombre'=>'REEMBOLSOS Y REINTEGROS 	'],
			['codigo'=>'1103021', 'nombre'=>'RENDIMIENTOS FINANCIEROS PROVENIENTES DE RECURSOS DE LIBRE DESTINACIÓN	'],
			['codigo'=>'1103021', 'nombre'=>'OTROS RECURSOS DE CAPITAL	'],
			['codigo'=>'1103374', 'nombre'=>'RENDIMIENTOS FINANCIEROS DESTINACIÓN ESPECÍFICA	'],
			['codigo'=>'1103448', 'nombre'=>'VALORIZACIÓN ACUERDO 523 DE 2013	'],
			['codigo'=>'1103126', 'nombre'=>'CONTRIBUCIÓN VALORIZACIÓN	'],
			['codigo'=>'1103147', 'nombre'=>'- OTROS RECURSOS DEL BALANCE DE DESTINACIÓN ESPECÍFICA 	'],
			['codigo'=>'1101110', 'nombre'=>'RECURSOS DEL BALANCE IVA TELEFONÍA MÓVIL	'],
			['codigo'=>'1101028', 'nombre'=>'RENDIMIENTOS PROVINIENTES DE DESTINACIÓN ESPECÍFICA IVA- TELEFONÍA MÓVIL	'],
			['codigo'=>'1101182', 'nombre'=>'RECURSOS DEL BALANCE  SGP	'],
			['codigo'=>'1101039', 'nombre'=>'IVA  AL SERVICIO DE LA TELEFONÍA MÓVIL	'],
			['codigo'=>'1101268', 'nombre'=>'RECURSOS DEL BALANCE REAFORO IVA TELEFONÍA MÓVIL	'],
			['codigo'=>'1101038', 'nombre'=>'IVA - CEDIDO DE LICORES	1101286 RECURSOS DEL BALANCE REAFORO IVA CEDIDO DE LICORES	'],
			['codigo'=>'1101272', 'nombre'=>'SGP PROPÓSITO GENERAL DEPORTE	'],
			['codigo'=>'1101273', 'nombre'=>'SGP PROPÓSITO GENERAL LIBRE INVERSIÓN - DEPORTE	'],
			['codigo'=>'1101359', 'nombre'=>'RECURSOS DEL BALANCE DONACIONES 110% CON BOGOTÁ 	'],
			['codigo'=>'1101364', 'nombre'=>'RECURSOS DE BALANCE FONDO DE POBRES Y ESPECTÁCULOS PÚBLICOS	'],
			['codigo'=>'1101411', 'nombre'=>'RECURSOS DEL BALANCE SGP DEPORTE	'],
			['codigo'=>'1101431', 'nombre'=>'RECURSOS DEL BALANCE REAFORO SGP PROPÓSITO GENERAL 	'],
			['codigo'=>'1101435', 'nombre'=>'RECURSOS DEL BALANCE IVA CEDIDO DE LICORES	'],
			['codigo'=>'1101177', 'nombre'=>'RENDIMIENTOS FINANCIEROS SGP	'],
			['codigo'=>'1101491', 'nombre'=>'RECURSOS DEL BALANCE IVA CEDIDO DE LICORES	'],
			['codigo'=>'1101177', 'nombre'=>'RENDIMIENTOS FINANCIEROS SGP	'],
			['codigo'=>'1101197', 'nombre'=>'ESPECTÁCULOS PÚBLICOS Y FONDO DE POBRES	1101284 RECURSOS DEL BALANCE REAFOR ,ESPECTÁCULOS PÚBLICOS Y FONDO DE POBRES'],
			['codigo'=>'1101037', 'nombre'=>'1%  DEL RECAUDO IMPUESTO DE ICA	1101370 RECURSOS DEL BALANCE  ICA 	522 RECURSOS DE ,BALANCE REAFORO ICA	'],
			['codigo'=>'1101012', 'nombre'=>'OTROS DISTRITO	'],
			['codigo'=>'1101025', 'nombre'=>'RECURSOS  KFW	1101046  CRÉDITO  KFW	1101186 CONTRAPARTIDA KFW']
        ]);
    }
}


