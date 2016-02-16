<?php
class Referencia extends AppModel
{
    var $name = 'Referencia';
	
	public $belongsTo = array(
        'Usuario' => array(
            'className' => 'Usuario',
            'foreignKey' => 'usuario_id'
        )
    );
	
	public $validate = array(
		'nombre' => array(
			'rule' => 'notEmpty',
			'message' => 'El nombre no puede estar vacio'
		),
		'apellido' => array(
			'rule' => 'notEmpty',
			'message' => 'El apellido no puede estar vacio'
		),
		'telefono' => array(
			'rule' => 'notEmpty',
			'message' => 'El telefono no puede estar vacio'
		),
		'email' => array(
			'rule' => 'notEmpty',
			'message' => 'El email no puede estar vacio'
		)
    );
	
	function agregar($data){
		$response = array('status'=>false,'message'=>'No se pudieron guardar los datos','errores'=>null);
		if($exists = $this->find('first',array('conditions'=>array('Referencia.email'=>$data['email'])))){
			$this->id = $exists['Referencia']['id'];
		}
		if($this->save(array('Referencia'=>$data))){
			$response['status'] = true;
			$response['message'] = 'Los datos se guardaron con exito';
		}else{
			$response['errores'] = $this->invalidFields();
		}
		return $response;
	}
}