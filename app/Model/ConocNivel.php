<?php
class ConocNivel extends AppModel
{
	var $name = 'ConocNivel';
    var $useTable = 'conoc_niveles';
    var $displayField = 'denominacion';

	function getCombo(){
		return $this->find('list', array('order'=>'orden ASC'));
	}
}    
?>