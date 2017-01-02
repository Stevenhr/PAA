<?php 

namespace App\Utilidades;

class Comparador {

	public function __construct(){}

	static function comparar($obj1, $obj2)
	{
		$cambios = [];
		if(count($obj1) == count($obj2))
		{
			foreach ($obj1 as $key => $value) 
			{
				if (array_key_exists($key, $obj2)) {
					if(is_array($obj1[$key]))
					{
						self::comparar($obj1, $obj2[$key]);
					}

					if(!(is_array($obj1[$key]) && is_array($obj2[$key])))
					echo $key.': '.$obj1[$key].' != '.$obj2[$key].'<br>';

					if($obj1[$key] != $obj2[$key])
					{
						$cambios[] = $key;
					}
				}
				else 
				{ 
	 				$cambios[$key] = $value; 
	 			} 
			}
			echo '<br><br>';
			return $cambios;
		} 
		return false;
	}

}




