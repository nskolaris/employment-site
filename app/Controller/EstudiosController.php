<?php
App::uses('AppController', 'Controller');

class EstudiosController extends AppController{

	public $uses = array('Estudio');
	
	function save(){
		if($this->CheckLogin()){
			if(!empty($this->data)){
				$response = $this->Estudio->agregar($this->data);
				if($response['status']){
					$response['data'] = $this->ReturnData();
				}
				echo json_encode($response);
			}
		}
		exit;
	}
	
	function delete($id=null){
		if($id!=null){
			if($this->Estudio->delete($id)){
				echo 'ok';
			}else{
				echo 'error';
			}
		}
		exit;
	}
	
	function ReturnData(){
		if($this->CheckLogin()){
			$this->Usuario->Behaviors->attach('Containable');
			return $this->Usuario->find('first',array(
				'conditions'=>array('Usuario.id'=>$this->SessionUsuario['Usuario']['id']),
				'contain'=>array('Estudio'=>array('Pais','EstudioArea','EstudioNivel','EstudioInstitucion','EstudioEscala'))
			));
		}
	}
	
	function get_instituciones($pais_id){
		echo json_encode($this->Estudio->EstudioInstitucion->getCombo($pais_id));
		exit;
	}
}
