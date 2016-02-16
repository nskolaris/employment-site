<?php
App::uses('AppController', 'Controller');

class ReferenciasController extends AppController{

	public $uses = array('Referencia');
	
	function save(){
		if($this->CheckLogin()){
			if(!empty($this->data)){
				$response = $this->Referencia->agregar($this->data);
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
			if($this->Referencia->delete($id)){
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
				'contain'=>array('Referencia')
			));
		}
	}
}
