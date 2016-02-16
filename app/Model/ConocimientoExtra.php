<?php
class ConocimientoExtra extends AppModel
{
    var $name = 'ConocimientoExtra';
    var $useTable = 'conocimientos_extra';
    
    var $belongsTo = array(
		'ConocNivel' => array(
			'className' => 'ConocNivel',
            'foreignKey'   => 'nivel_id'
        ),
		'Usuario' => array(
            'className' => 'Usuario',
            'foreignKey' => 'usuario_id'
        )
	);	
    
    var $validate = array(
   		'nombre' => array('rule'=>'notEmpty'),
   		'descripcion' => array('rule'=>'notEmpty'),
   	);
	
	function agregar($data){
		$response = array('status'=>false,'message'=>'No se pudieron guardar los datos','errores'=>null);
		/*if($exists = $this->find('first',array('conditions'=>array('ConocimientoExtra.usuario_id'=>$data['usuario_id'])))){
			$this->id = $exists['ConocimientoExtra']['id'];
		}*/
		if($this->save(array('ConocimientoExtra'=>$data))){
			$response['status'] = true;
			$response['message'] = 'Los datos se guardaron con exito';
		}else{
			$response['errores'] = $this->invalidFields();
		}
		return $response;
	}
}    
?>