<?php
App::uses('AppController', 'Controller');

class PresentacionesController extends AppController{

	public $uses = array('Presentacion');
	
	function save(){
		if(!empty($this->data)){
			$response = $this->Presentacion->agregar($this->data);
			if($response['status']){
				$response['data'] = $this->Presentacion->read();
			}
			echo json_encode($response);
		}
		exit;
	}
}
