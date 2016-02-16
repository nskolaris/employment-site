<?php
class LaboralNivelPuesto extends AppModel
{
    var $name = 'LaboralNivelPuesto';
    var $useTable = 'laboral_nivelespuestos';
    var $displayField = 'denominacion';

	function getCombo(){
		return $this->find('list', array('order'=>'denominacion ASC'));
	}    
}    
?>