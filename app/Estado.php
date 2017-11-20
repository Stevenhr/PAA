<?php

namespace App;

class Estado {
	const Consolidacion = 0;
	const Uno = 1;
	const Dos = 2;
	const Tres = 3;//Eliminado
	const Subdireccion = 4;
	const Aprobado = 5;
	const Rechazado = 6;
	const Cancelado = 7;
	const EstudioConveniencia = 8;
	const EstudioAprobado = 9;
	const EstudioCorregido = 10;
	const EstudioCancelado = 11;

	const VIGENCIA = 2018;

	static function toString($codigo)
	{
		$estado = '';
		switch ($codigo) {
			case 0:
				$estado = 'En consolidación';
			break;
			case 3:
				$estado = 'Eliminado';
			break;
			case 4:
				$estado = 'En subdirección';
			break;
			case 5:
				$estado = 'Aprobado por subdirección';
			break;
			case 6:
				$estado = 'Denegado por subdirección';
			break;
			case 7:
				$estado = 'Cancelado por subdirección';
			break;
			case 8:
				$estado = 'Aprobado por subdirección, con estudio de conveniencia.';
			break;
			case 9:
				$estado = 'Aprobado Subdireción. (Estudio  aprobado)';
			break;
			case 10:
				$estado = 'Aprobado Subdireción. (Correciones pendientes del estudio)';
			break;
			case 11:
				$estado = 'Aprobado Subdireción. (Cancelado el estudio)';
			break;
		}

		return $estado;
	}
}