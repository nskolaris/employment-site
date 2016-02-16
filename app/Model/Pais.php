<?php
class Pais extends AppModel
{
    var $name = 'Pais';
    var $useTable = 'paises';
    var $displayField = 'denominacion';

    function getCombo(){
    	return $this->find('list', array('order'=>'denominacion ASC'));
	}
}    
?>