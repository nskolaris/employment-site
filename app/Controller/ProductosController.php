<?php
App::uses('AppController', 'Controller');

class ProductosController extends AppController{

	var $uses = array('Producto');
	public $components = array('Paginator');
    
	function beforeFilter(){
		parent::beforeFilter();
	}
	
	/* Sección Empresas */
	
	function empresa_index(){
		$this->Producto->Categoria->Behaviors->attach('Containable');
		$this->set('categorias', $this->Producto->Categoria->find('all',array('contain'=>array('Producto'=>array('Configuracion')))));
	}
	
	function empresa_adquirir($id = null){
		if($id != null){
			$data['EmpresaProducto']['producto_id'] = $id;
			$data['EmpresaProducto']['empresa_id'] = $this->SessionUsuarioInterno['Empresa']['id'];
			$data['EmpresaProducto']['usuario_interno_comprador_id'] = $this->SessionUsuarioInterno['UsuarioInterno']['id'];
			$result = $this->Producto->EmpresaProducto->agregar($data);
			if($result['status']){
				echo 'ok';
			}else{
				echo $result['message'];
			}
		}
		exit;
	}
	
	function empresa_exito(){
		
	}
	
	/* Sección Control */
	
	function control_compras($empresa_id = null){

		Configure::write('Debug',2);
	
		$this->Producto->EmpresaProducto->Behaviors->attach('Containable');
		
		$conditions = array();
		
		if($empresa_id != null){
			$conditions['EmpresaProducto.empresa_id'] = $empresa_id;
		}
		
		if(!empty($this->data)){
			foreach($this->data as $model => $values){
				foreach($values as $field => $value){
					if($value != ''){
						$conditions[$model.'.'.$field] = $value;
					}
				}
			}
		}
		
		if(isset($conditions['EmpresaProducto.activo'])&&$conditions['EmpresaProducto.activo'] == 1){
			$conditions['OR'] = array(
				'EmpresaProducto.usados < EmpresaProducto.cantidad',
				'DATE(NOW()) < DATE(EmpresaProducto.ffin)'
			);
		}
		
		$this->Paginator->settings = array(
			'conditions' => $conditions,
			'contain' => array('Producto'=>array('Configuracion'),'Empresa'),
			'limit' => 20
		);
		
		$empresa_productos = $this->Paginator->paginate('EmpresaProducto');
		$this->set(compact('empresa_productos'));
		
		$this->set('empresas',$this->Empresa->find('list',array('fields'=>array('id','nombre_comercial'))));
		$this->set('productos',$this->Producto->find('list',array('fields'=>array('id','denominacion'))));
		$this->set('empresa_id',$empresa_id);
	}
	
	function control_gestionar(){
		$this->Producto->Behaviors->attach('Containable');
		$this->set('productos',$this->Producto->find('all',array('contain'=>array('Categoria','Configuracion'))));
		$this->set('categorias', $this->Producto->Categoria->getCombo());
	}
	
	function control_edit(){
		if(!empty($this->data)){
			if($this->Producto->save($this->data)){
				if($this->Producto->Configuracion->save($this->data)){
					echo 'ok';
				}else{
					echo 'error';
				}
			}else{
				echo 'error';
			}
		}
		exit;
	}
	
	function control_activar($id){
		$this->Producto->EmpresaProducto->id = $id;
		if($data = $this->Producto->EmpresaProducto->Activar()){
			echo json_encode($data);
		}else{
			echo 'error';
		}
		exit;
	}
	
	function control_desactivar($id){
		$this->Producto->EmpresaProducto->id = $id;
		if($this->Producto->EmpresaProducto->Desactivar()){
			echo 'ok';
		}else{
			echo 'error';
		}
		exit;
	}
	
	function control_nueva_compra(){
		if(!empty($this->data)){
			$data['EmpresaProducto']['producto_id'] = $this->data['producto_id'];
			$data['EmpresaProducto']['empresa_id'] = $this->data['empresa_id'];
			if($this->data['importe'] != ''){
				$data['EmpresaProducto']['importe'] = $this->data['importe'];
			}
			$result = $this->Producto->EmpresaProducto->agregar($data);
			if($result['status']){
				echo 'ok';
			}else{
				echo $result['message'];
			}
		}
		exit;
	}
}
?>