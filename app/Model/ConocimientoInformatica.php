<?php
class ConocimientoInformatica extends AppModel
{

    var $name = 'ConocimientoInformatica';
    var $useTable = 'conocimientos_informatica';
    
    var $belongsTo = array(
		'ConocSoftware' => array(
			'className' => 'ConocSoftware',
            'foreignKey'   => 'software_id'
        ),
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
   		'software_id' => array('rule'=>'numeric'),
   		'nivel_id' => array('rule'=>'numeric'),
   	);
	
	function agregar($data){
		$response = array('status'=>false,'message'=>'No se pudieron guardar los datos','errores'=>null);
		/*if($exists = $this->find('first',array('conditions'=>array('ConocimientoInformatica.usuario_id'=>$data['usuario_id'])))){
			$this->id = $exists['ConocimientoInformatica']['id'];
		}*/
		if($this->save(array('ConocimientoInformatica'=>$data))){
			$response['status'] = true;
			$response['message'] = 'Los datos se guardaron con exito';
		}else{
			$response['errores'] = $this->invalidFields();
		}
		return $response;
	}
}    
?>