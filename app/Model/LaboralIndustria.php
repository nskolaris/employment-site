<?php
class LaboralIndustria extends AppModel
{
    var $name = 'LaboralIndustria';
    var $useTable = 'laboral_industrias';
    var $displayField = 'denominacion';

	function getCombo(){
		return $this->find('list', array('order'=>'denominacion ASC'));
	}  
}    
?>