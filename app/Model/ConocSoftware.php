<?php
class ConocSoftware extends AppModel
{
    var $name = 'ConocSoftware';
    var $useTable = 'conoc_softwares';
    var $displayField = 'denominacion';

	function getCombo(){
		return $this->find('list', array('order'=>'denominacion ASC'));
	}
}    
?>