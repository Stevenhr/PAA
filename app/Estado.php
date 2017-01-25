<?php

namespace App;

class Estado {
	const Consolidacion = 0;
	const Uno = 1;
	const Dos = 2;
	const Tres = 3;
	const Subdireccion = 4;
	const Aprobado = 5;
	const Rechazado = 6;
	const Cancelado = 7;

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
		}

		return $estado;
	}
}