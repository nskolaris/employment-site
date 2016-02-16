<?php
class LaboralTipoTrabajo extends AppModel
{
    var $name = 'LaboralTipoTrabajo';
    var $useTable = 'laboral_tipostrabajos';
    var $displayField = 'denominacion';

	function getCombo() {
		return $this->find('list', array('order'=>'denominacion ASC'));
	}    
}    
?>