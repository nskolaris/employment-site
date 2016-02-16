<?php
class ConocimientoIdioma extends AppModel
{

    var $name = 'ConocimientoIdioma';
    var $useTable = 'conocimientos_idioma';
   	
	var $belongsTo = array(
		'ConocIdioma' => array(
			'className' => 'ConocIdioma',
            'foreignKey'   => 'idioma_id'
        ),
		'ConocNivelOral' => array(
			'className' => 'ConocNivelIdioma',
			'foreignKey' => 'nivel_oral_id'
		),
		'ConocNivelEscrito' => array(
			'className' => 'ConocNivelIdioma',
			'foreignKey' => 'nivel_escrito_id'
		),
		'Usuario' => array(
            'className' => 'Usuario',
            'foreignKey' => 'usuario_id'
        )
    );

   	var $validate = array(
   		'idioma_id' => array('rule'=>'numeric'),
   		'nivel_escrito_id' => array('rule'=>'numeric'),
   		'nivel_oral_id' => array('rule'=>'numeric'),
   		'usuario_id' => array('rule'=>'numeric'),
   	);
	
	function agregar($data){
		$response = array('status'=>false,'message'=>'No se pudieron guardar los datos','errores'=>null);
		/*if($exists = $this->find('first',array('conditions'=>array('ConocimientoIdioma.usuario_id'=>$data['usuario_id'])))){
			$this->id = $exists['ConocimientoIdioma']['id'];
		}*/
		if($this->save(array('ConocimientoIdioma'=>$data))){
			$response['status'] = true;
			$response['message'] = 'Los datos se guardaron con exito';
		}else{
			$response['errores'] = $this->invalidFields();
		}
		return $response;
	}
}    
?>