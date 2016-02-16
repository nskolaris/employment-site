<?php
class CurriculumavisoNota extends AppModel
{
    var $name = 'CurriculumavisoNota';
    var $useTable = 'curriculumaviso_notas';
	
	var $belongsTo = array(
		'CurriculumAviso' => array(
			'className' => 'CurriculumAviso',
			'foreignKey' => 'curriculumaviso_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'UsuarioInterno' => array(
			'className' => 'UsuarioInterno',
			'foreignKey' => 'usuario_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	function afterFind($results, $primary = false){
		foreach ($results as $key => $val) {
			if(isset($val['CurriculumavisoNota']['created'])){
				$date = date_create($val['CurriculumavisoNota']['created']);
				$results[$key]['CurriculumavisoNota']['created'] = date_format($date,'d/m/Y');
			}
		}
		return $results;
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
		$avisos = $this->find('all',array('conditions'=>array('Aviso.deleted'=>null, 'CurriculumAviso.usuario_id'=>$data['Usuario']['id']),'contain'=>array('Aviso')));
		return $avisos;
	}
}
?>
