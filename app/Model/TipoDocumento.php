<?php
class TipoDocumento extends AppModel
{
    var $name = 'TipoDocumento';
    var $useTable = 'tiposdocumentos';
    var $displayField = 'denominacion';

	function getCombo(){
		return array(0=>'') + $this->find('list', array('order'=>'denominacion ASC'));
	}
}    
?>