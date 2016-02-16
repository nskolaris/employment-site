<?php
class Provincia extends AppModel
{
    var $name = 'Provincia';
    var $useTable = 'provincias';
    var $displayField = 'denominacion';

    var $belongsTo = array(
		'Pais' => array(
			'className' => 'Pais',
			'foreignKey' => 'pais_id'
		)
	 );	

	function getCombo($idpais = null){
		if($idpais != null){
			return $this->find('list', array('conditions'=>array('pais_id'=>$idpais), 'order'=>'denominacion ASC'));
		}else{
			return $this->find('list', array('order'=>'denominacion ASC'));
		}
	}
	
	function getPais($provincia_id = null){
		if($provincia_id != null){
			$this->id = $provincia_id;
			if($provincia = $this->read()){
				return $provincia['Pais']['id'];
			}
			return false;
		}
		return false;
	}
}    
?>