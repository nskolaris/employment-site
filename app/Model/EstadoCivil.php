<?php
class EstadoCivil extends AppModel
{
    var $name = 'EstadoCivil';
    var $useTable = 'estadosciviles';
    var $displayField = 'denominacion';

    function getCombo() {
		return $this->find('list', array('order'=>'denominacion ASC'));
	}
}    
?>