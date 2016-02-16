<?php
App::uses('AppController', 'Controller');

class PreferenciasLaboralesController extends AppController{

	public $uses = array('PreferenciaLaboral');
	
	function save(){
		if(!empty($this->data)){
			$response = $this->PreferenciaLaboral->agregar($this->data);
			if($response['status']){
				$response['data'] = $this->PreferenciaLaboral->read();
			}
			echo json_encode($response);
		}
		exit;
	}
}
