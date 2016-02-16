<?php
class Rol extends AppModel
{
    var $name = 'Rol';
    var $useTable = 'roles';
	var $displayField = 'denominacion';
	
	function getCombo(){
		return $this->find('list', array('order'=>'denominacion ASC'));
	}
}    
?>