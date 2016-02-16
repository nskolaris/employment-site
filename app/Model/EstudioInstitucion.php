<?php
class EstudioInstitucion extends AppModel
{
    var $name = 'EstudioInstitucion';
    var $useTable = 'estudio_instituciones';
    var $displayField = 'denominacion';

    var $belongsTo = array(
		'Pais' => array(
			'className'  => 'Pais',
            'foreignKey' => 'pais_id'
		)
    );	
    
    function getCombo($idpais=null){
		if(!is_null($idpais)){
			return $this->find('list', array('conditions'=>array('pais_id'=>$idpais),'order'=>'denominacion ASC'));
		}else{
			return $this->find('list', array('order'=>'denominacion ASC'));
		}
	}
}    
?>