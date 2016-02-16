<?php
class PreferenciaLaboral extends AppModel
{
    var $name = 'PreferenciaLaboral';
    var $useTable = 'preferencias_laborales';
    
	/*var $hasAndBelongsToMany = array('LaboralNivelPuesto' =>
	array('className'    => 'LaboralNivelPuesto',
	'joinTable'    => 'preferencias_nivelespuestos',
	'foreignKey'   => 'nivel_id',
	'associationForeignKey'=> 'preferencia_id',
	),
	'IecsaArea' =>
	array('className'    => 'IecsaArea',
	'joinTable'    => 'preferencias_areas',
	'foreignKey'   => 'area_id',
	'associationForeignKey'=> 'preferencia_id',
	),
	'LaboralTipoTrabajo' =>
	array('className'    => 'LaboralTipoTrabajo',
	'joinTable'    => 'preferencias_tipostrabajos',
	'foreignKey'   => 'tipo_id',
	'associationForeignKey'=> 'preferencia_id',
	),

	);*/
	
	function agregar($data){
		$response = array('status'=>false,'message'=>'No se pudieron guardar los datos','errores'=>null);
		if($exists = $this->find('first',array('conditions'=>array('PreferenciaLaboral.usuario_id'=>$data['usuario_id'])))){
			$this->id = $exists['PreferenciaLaboral']['id'];
		}
		if($this->save(array('PreferenciaLaboral'=>$data))){
			$response['status'] = true;
			$response['message'] = 'Los datos se guardaron con exito';
		}else{
			$response['errores'] = $this->invalidFields();
		}
		return $response;
	}
}
?>