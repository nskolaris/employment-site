<?php
class Estudio extends AppModel
{
    var $name = 'Estudio';
    var $useTable = 'estudios';
    
    var $belongsTo = array(
		'Pais' => array(
			'className' => 'Pais',
			'foreignKey'	=> 'pais_id'
		),
		'EstudioArea' => array(
			'className'    => 'EstudioArea',
			'foreignKey'   => 'area_id'
		),
		'EstudioNivel' => array(
			'className'    => 'EstudioNivel',
			'foreignKey'   => 'nivel_id'
		),
		'EstudioInstitucion' => array(
			'className'    => 'EstudioInstitucion',
			'foreignKey'   => 'institucion_id'
		),
		'EstudioEscala' => array(
			'className'    => 'EstudioEscala',
			'foreignKey'   => 'escala_id'
		)
	);	
   	
   	var $validate = array(
   		'area_id' => array('rule'=>'numeric'),
		'finicio' => array('rule'=>'notEmpty'),
   		'nivel_id' => array('rule'=>'numeric'),
		'pais_id' => array('rule'=>'numeric'),
		'titulo' => array('rule'=>'notEmpty'),
   		'usuario_id' => array('rule'=>'numeric'),
   	);
	
	function beforeSave($options = Array())
	{
	    $this->data['Estudio']['finicio'] = $this->_getDate('finicio');
	    if($this->data['Estudio']['ffin-presente'] == 'on'){
			$this->data['Estudio']['ffin'] = '0000-00-00';
		}else{
			$this->data['Estudio']['ffin'] = $this->_getDate('ffin');
		}
    	return true;
	}	

	function afterFind($results, $primary = false){
		foreach ($results as $key => $val) {
			if(isset($val['Estudio']['finicio'])){
				$fecha = explode("-", $val['Estudio']['finicio']);
				if(isset($fecha[2])){
					$results[$key]['Estudio']['finicio-mes'] = intval($fecha[1]);
					$results[$key]['Estudio']['finicio-ano'] = $fecha[0];
				}
				$results[$key]['Estudio']['finicio'] = $fecha[1].'/'.$fecha[0];
			}
			if(isset($val['Estudio']['ffin'])){
				if($val['Estudio']['ffin'] == '0000-00-00'){
					$results[$key]['Estudio']['ffin'] = 'Presente';
					$results[$key]['Estudio']['ffin-presente'] = true;
				}else{
					$fecha = explode("-", $val['Estudio']['ffin']);
					if(isset($fecha[2])){
						$results[$key]['Estudio']['ffin-mes'] = intval($fecha[1]);
						$results[$key]['Estudio']['ffin-ano'] = $fecha[0];
					}
					$results[$key]['Estudio']['ffin'] = $fecha[1].'/'.$fecha[0];
				}
			}
		}
		return $results;
	}
	
	function _getDate($campo)
	{
		$dia  = isset($this->data['Estudio'][$campo . '-dia']) ? intval($this->data['Estudio'][$campo . '-dia']) : 1; 
		$mes  = isset($this->data['Estudio'][$campo . '-mes']) ? intval($this->data['Estudio'][$campo . '-mes']) : 0; 
		$anio = isset($this->data['Estudio'][$campo . '-ano']) ? intval($this->data['Estudio'][$campo . '-ano']) : 0;
		if( $dia != 0 && $mes != 0 && $anio != 0 ) {
		    return date('Y-m-d', mktime(null,null,null,$mes,$dia,$anio));
		} else {
			return null;
		}
	}
	
	function agregar($data){
		$response = array('status'=>false,'message'=>'No se pudieron guardar los datos','errores'=>null);
		/*if($exists = $this->find('first',array('conditions'=>array('Estudio.usuario_id'=>$data['usuario_id'])))){
			$this->id = $exists['Estudio']['id'];
		}*/
		if($this->save(array('Estudio'=>$data))){
			$response['status'] = true;
			$response['message'] = 'Los datos se guardaron con exito';
		}else{
			$response['errores'] = $this->invalidFields();
		}
		return $response;
	}
}    
?>