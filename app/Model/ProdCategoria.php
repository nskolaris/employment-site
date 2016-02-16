<?php
class ProdCategoria extends AppModel {
	var $name = 'ProdCategoria';
	var $useTable = 'prod_categorias';
	
	public $hasMany = array(
        'Producto' => array(
            'className' => 'Producto',
            'foreignKey' => 'prod_categoria_id',
            'order' => 'Producto.id ASC'
        )
    );
	
	function getCombo(){
		return $this->find('list', array('fields'=>array('id','denominacion'),'order'=>'denominacion ASC'));
	}
}
?>