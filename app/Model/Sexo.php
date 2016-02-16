<?php
class Sexo extends AppModel
{
    var $name = 'Sexo';
    var $useTable = 'sexos';
    var $displayField = 'denominacion';

	function getCombo() {
		return $this->find('list', array('order'=>'denominacion ASC'));
	}
}    
?>