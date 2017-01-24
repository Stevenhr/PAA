<?php

namespace App;

class Estado {
	const Eliminado = 3;
	const Subdireccion = 4;
	const Aprobado = 5;
	const Rechazado = 6;
	const Cancelado = 7;

	static function toString($codigo)
	{
		$estado = '';
		switch ($codigo) {
			case 3:
				$estado = 'Eliminado';
			break;
			case 4:
				$estado = 'Subdireccion';
			break;
			case 5:
				$estado = 'Aprobado';
			break;
			case 6:
				$estado = 'Rechazado';
			break;
			case 7:
				$estado = 'Cancelado';
			break;
		}

		return $estado;
	}
}