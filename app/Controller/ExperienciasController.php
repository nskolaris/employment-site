<?php
App::uses('AppController', 'Controller');

class ExperienciasController extends AppController{

	public $uses = array('Experiencia');
	
	function save(){
		if($this->CheckLogin()){
			if(!empty($this->data)){
				$response = $this->Experiencia->agregar($this->data);
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
			if($this->Experiencia->delete($id)){
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
				'contain'=>array('Experiencia'=>array('Pais','LaboralArea','LaboralIndustria','LaboralNivelPuesto'))
			));
		}
	}
}

