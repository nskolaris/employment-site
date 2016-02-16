<?php
class EstudioArea extends AppModel
{
    var $name = 'EstudioArea';
    var $useTable = 'estudio_areas';
    var $displayField = 'denominacion';

	function getCombo(){
		return $this->find('list', array('order'=>'denominacion ASC'));
	}
}    
?>