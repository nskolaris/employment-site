<?php
class ConocNivelIdioma extends AppModel
{
	var $name = 'ConocNivelIdioma';
    var $useTable = 'conoc_nivelesidiomas';
    var $displayField = 'denominacion';

	function getCombo(){
		return $this->find('list', array('order'=>'orden ASC'));
	}
}    
?>