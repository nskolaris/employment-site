<?php
App::uses('AppController', 'Controller');

class ConocimientoInformaticasController extends AppController{

	public $uses = array('ConocimientoInformatica');
	
	function save(){
		if($this->CheckLogin()){
			if(!empty($this->data)){
				$response = $this->ConocimientoInformatica->agregar($this->data);
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
			if($this->ConocimientoInformatica->delete($id)){
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
				'contain'=>array('ConocimientoInformatica'=>array('ConocSoftware','ConocNivel'))
			));
		}
	}
}
