<?php
class EstudioNivel extends AppModel
{
    var $name = 'EstudioNivel';
    var $useTable = 'estudio_niveles';
    var $displayField = 'denominacion';

	function getCombo(){
		return $this->find('list', array('order'=>'denominacion ASC'));
	}
}    
?>