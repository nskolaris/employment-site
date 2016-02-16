<?php
class AvisoPermiso extends AppModel{
	var $name = 'AvisoPermiso';
	var $useTable = 'avisos_permisos';
	
	var $belongsTo = array(
		'Aviso' => array(
			'className' => 'Aviso',
			'foreignKey' => 'aviso_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'UsuarioInterno' => array(
			'className' => 'UsuarioInterno',
			'foreignKey' => 'usuario_interno_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>