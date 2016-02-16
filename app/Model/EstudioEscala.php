<?php
class EstudioEscala extends AppModel
{
    var $name = 'EstudioEscala';
    var $useTable = 'estudio_escalas';
    var $displayField = 'denominacion';

	function getCombo(){
		return array(0=>'') + $this->find('list', array('order'=>'denominacion ASC'));
	}
}    
?>