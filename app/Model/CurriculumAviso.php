<?php
class CurriculumAviso extends AppModel
{
    var $name = 'CurriculumAviso';
    var $useTable = 'curriculum_aviso';
	
	var $belongsTo = array(
		'Usuario' => array(
			'className' => 'Usuario',
			'foreignKey' => 'usuario_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Aviso' => array(
			'className' => 'Aviso',
			'foreignKey' => 'aviso_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public $hasMany = array(
        'CurriculumavisoNota' => array(
            'className' => 'CurriculumavisoNota',
            'foreignKey' => 'curriculumaviso_id',
            'order' => 'CurriculumavisoNota.id DESC'
        )
    );
	
	function beforeFind($query) {
        parent::beforeFind($query);
		
		/*$this->Behaviors->attach('Containable');
		$defaultContain = array('Usuario.datos_minimos' => true);
        $query['contain'] = array_merge((isset($query['contain'])?$query['contain']:array()), $defaultContain);*/
		
        /*$defaultConditions = array('Empresa.activa' => 1);
        $query['conditions'] = array_merge((isset($query['conditions'])?$query['conditions']:array()), $defaultConditions);*/
		
		$defaultJoins = array(
			/*array(
				'table' => 'usuarios',
				'alias' => 'UsuarioCompleto',
				'type' => 'inner',
				'conditions' => array(
					'UsuarioCompleto.id = CurriculumAviso.usuario_id',
					'UsuarioCompleto.datos_minimos = 1',
				)
			)*/
		);
        $query['joins'] = array_merge((isset($query['joins'])?$query['joins']:array()), $defaultJoins);
        return $query;
    }
	
	function agregar($data){
		$response = array('status'=>false,'message'=>'No se pudo postular','errores'=>null);
		if($exists = $this->find('first',array('conditions'=>array('CurriculumAviso.aviso_id'=>$data['CurriculumAviso']['aviso_id'],'CurriculumAviso.usuario_id'=>$data['CurriculumAviso']['usuario_id'])))){
			$this->id = $exists['CurriculumAviso']['id'];
		}
		if($this->save($data)){
			$response['status'] = true;
			$response['message'] = 'Se postulo con exito';
		}else{
			$response['errores'] = $this->invalidFields();
		}
		return $response;
	}
	
	function TraerPorUsuario($data){
		$this->Behaviors->attach('Containable');
		$avisos = $this->find('all');
		return $avisos;
	}
}
?>
