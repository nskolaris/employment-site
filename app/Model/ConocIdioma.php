<?php
class ConocIdioma extends AppModel
{
    var $name = 'ConocIdioma';
    var $useTable = 'conoc_idiomas';
    var $displayField = 'denominacion';

	function getCombo(){
		return $this->find('list', array('order'=>'denominacion ASC'));
	}
}    
?>