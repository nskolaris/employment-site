<?php
App::uses('AppController', 'Controller');

class DatosPersonalesController extends AppController{

	public $uses = array('DatosPersonales');
	
	function save(){
		if(!empty($this->data)){
			$response = $this->DatosPersonales->agregar($this->data);
			if($response['status']){
				//$this->DatosPersonales->recursive = -1;
				$response['data'] = $this->DatosPersonales->read();
			}
			echo json_encode($response);
		}
		exit;
	}
	
	function get_provincias($pais_id){
		echo json_encode($this->DatosPersonales->Provincia->getCombo($pais_id));
		exit;
	}
}
