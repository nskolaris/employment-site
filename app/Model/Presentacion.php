<?php
class Presentacion extends AppModel
{
    var $name = 'Presentacion';
    var $useTable = 'presentaciones';
    
   	var $validate = array(
   		'descripcion' => array('rule'=>'notEmpty'),
   	);
	
	function agregar($data){
		$response = array('status'=>false,'message'=>'No se pudieron guardar los datos','errores'=>null);
		if($exists = $this->find('first',array('conditions'=>array('Presentacion.usuario_id'=>$data['usuario_id'])))){
			$this->id = $exists['Presentacion']['id'];
		}
		if($this->save(array('Presentacion'=>$data))){
			$response['status'] = true;
			$response['message'] = 'Los datos se guardaron con exito';
		}else{
			$response['errores'] = $this->invalidFields();
		}
		return $response;
	}
}    
?>