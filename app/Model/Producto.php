<?php
class Producto extends AppModel {
	var $name = 'Producto';
	
	var $belongsTo = array(
		'Categoria' => array(
			'className' => 'ProdCategoria',
			'foreignKey' => 'prod_categoria_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	var $hasOne = array(
        'Configuracion' => array(
            'className' => 'ProdConfig',
			'foreignKey' => 'producto_id'
        )
    );
	
	public $hasMany = array(
        'EmpresaProducto' => array(
            'className' => 'EmpresaProducto',
            'foreignKey' => 'producto_id',
            'order' => 'EmpresaProducto.id ASC'
        )
    );
}
?>