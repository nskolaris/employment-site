<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

	function humanTiming($time)
	{
		$time = time() - $time; // to get the time since that moment

		$tokens = array (
			31536000 => 'año',
			2592000 => 'mes',
			604800 => 'semana',
			86400 => 'dia',
			3600 => 'hora',
			60 => 'minuto',
			1 => 'segundo'
		);

		foreach ($tokens as $unit => $text) {
			if ($time < $unit) continue;
			$numberOfUnits = floor($time / $unit);
			return $numberOfUnits.' '.$text.(($numberOfUnits>1)?($text=='mes'?'es':'s'):'');
		}
	}
	
	function calcular_edad($value, $inverso = false){
		if(!$inverso){
			$dob = strtotime(str_replace("/","-",$value));       
			$tdate = time();

			$age = 0;
			while( $tdate > $dob = strtotime('+1 year', $dob))
			{
				++$age;
			}
			return $age;
		}else{
			$fnacimiento = date('Y-m-d', strtotime('-'.$value.' years'));
			return $fnacimiento;
		}
	}
	
	function formatoFecha($fecha){
		$date = new DateTime($fecha);
		$date_format = $date->format('d/m/Y');
		$date_format_exploded = explode('/',$date_format);
		$dia = intval($date_format_exploded[0]);
		switch(intval($date_format_exploded[1])){
			case 1:
			$mes = 'enero';
			break;
			
			case 2:
			$mes = 'febrero';
			break;
			
			case 3:
			$mes = 'marzo';
			break;
			
			case 4:
			$mes = 'abril';
			break;
			
			case 5:
			$mes = 'mayo';
			break;
			
			case 6:
			$mes = 'junio';
			break;
			
			case 7:
			$mes = 'julio';
			break;
			
			case 8:
			$mes = 'agosto';
			break;
			
			case 9:
			$mes = 'septiembre';
			break;
			
			case 10:
			$mes = 'octubre';
			break;
			
			case 11:
			$mes = 'noviembre';
			break;
			
			case 12:
			$mes = 'diciembre';
			break;
		}
		$ano = $date_format_exploded[2];
		return $dia.' de '.$mes.' de '.$ano;
	}
	
	function GetMeses(){
		return array(
			1 => 'Enero',
			2 => 'Febrero',
			3 => 'Marzo',
			4 => 'Abril',
			5 => 'Mayo',
			6 => 'Junio',
			7 => 'Julio',
			8 => 'Agosto',
			9 => 'Septiembre',
			10 => 'Octubre',
			11 => 'Noviembre',
			12 => 'Diciembre'
		);
	}
}
