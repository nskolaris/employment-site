<?php
class LaboralArea extends AppModel
{
    var $name = 'LaboralArea';
    var $useTable = 'laboral_areas';
    var $displayField = 'denominacion';

	function getCombo(){
		return $this->find('list', array('order'=>'denominacion ASC'));
	}
}    
?>