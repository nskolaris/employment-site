<?php
class Experiencia extends AppModel
{
    var $name = 'Experiencia';
    var $useTable = 'experiencias';
    
    var $belongsTo = array(
		'Pais' =>
		array('className' => 'Pais',
			'foreignKey'	=> 'pais_id'
		),
		'LaboralArea' =>
		array('className'    => 'LaboralArea',
			'foreignKey'   => 'area_id'
		),
		'LaboralIndustria' =>
		array('className'    => 'LaboralIndustria',
			'foreignKey'   => 'industria_id'
		),
		'LaboralNivelPuesto' =>
		array('className'    => 'LaboralNivelPuesto',
			'foreignKey'   => 'nivelpuesto_id'
		),
	);	

   	var $validate = array(
   		'area_id' => array('rule'=>'numeric'),
		'descripcion' => array('rule'=>'notEmpty'),
		'empresa' => array('rule'=>'notEmpty'),
		'finicio' => array('rule'=>'notEmpty'),
   		'industria_id' => array('rule'=>'numeric'),
   		'nivelpuesto_id' => array('rule'=>'numeric'),
   		'pais_id' => array('rule'=>'numeric'),
		'puesto' => array('rule'=>'notEmpty'),
   		'usuario_id' => array('rule'=>'numeric'),
   	
   	);

	function beforeSave($options = Array())
	{
	    $this->data['Experiencia']['finicio'] = $this->_getDate('finicio');
		if($this->data['Experiencia']['ffin-presente'] == 'on'){
			$this->data['Experiencia']['ffin'] = '0000-00-00';
		}else{
			$this->data['Experiencia']['ffin'] = $this->_getDate('ffin');
		}
    	return true;
	}	

	function afterFind($results, $primary = false){
		foreach ($results as $key => $val) {
			if(isset($val['Experiencia']['finicio'])){
				$fecha = explode("-", $val['Experiencia']['finicio']);
				if(isset($fecha[2])){
					$results[$key]['Experiencia']['finicio-mes'] = intval($fecha[1]);
					$results[$key]['Experiencia']['finicio-ano'] = $fecha[0];
				}
				$results[$key]['Experiencia']['finicio'] = $fecha[1].'/'.$fecha[0];
			}
			if(isset($val['Experiencia']['ffin'])){
				if($val['Experiencia']['ffin'] == '0000-00-00'){
					$results[$key]['Experiencia']['ffin'] = 'Presente';
					$results[$key]['Experiencia']['ffin-presente'] = true;
				}else{
					$fecha = explode("-", $val['Experiencia']['ffin']);
					if(isset($fecha[2])){
						$results[$key]['Experiencia']['ffin-mes'] = intval($fecha[1]);
						$results[$key]['Experiencia']['ffin-ano'] = $fecha[0];
					}
					$results[$key]['Experiencia']['ffin'] = $fecha[1].'/'.$fecha[0];
				}
			}
		}
		return $results;
	}
	
	function _getDate($campo)
	{
		$dia  = isset($this->data['Experiencia'][$campo . '-dia']) ? intval($this->data['Experiencia'][$campo . '-dia']) : 1; 
		$mes  = isset($this->data['Experiencia'][$campo . '-mes']) ? intval($this->data['Experiencia'][$campo . '-mes']) : 0; 
		$anio = isset($this->data['Experiencia'][$campo . '-ano']) ? intval($this->data['Experiencia'][$campo . '-ano']) : 0;
		if( $dia != 0 && $mes != 0 && $anio != 0 ) {
		    return date('Y-m-d', mktime(null,null,null,$mes,$dia,$anio));
		} else {
			return null;
		}
	}
	
	function agregar($data){
		$response = array('status'=>false,'message'=>'No se pudieron guardar los datos','errores'=>null);
		/*if($exists = $this->find('first',array('conditions'=>array('Experiencia.usuario_id'=>$data['usuario_id'])))){
			$this->id = $exists['Experiencia']['id'];
		}*/
		if($this->save(array('Experiencia'=>$data))){
			$response['status'] = true;
			$response['message'] = 'Los datos se guardaron con exito';
		}else{
			$response['errores'] = $this->invalidFields();
		}
		return $response;
	}
}    
?>