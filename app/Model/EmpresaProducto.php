<?php
class EmpresaProducto extends AppModel {
	var $name = 'EmpresaProducto';
	var $useTable = 'empresas_productos';
	
	var $belongsTo = array(
		'Producto' => array(
			'className' => 'Producto',
			'foreignKey' => 'producto_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Empresa' => array(
			'className' => 'Empresa',
			'foreignKey' => 'empresa_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'UsuarioInterno' => array(
			'className' => 'UsuarioInterno',
			'foreignKey' => 'usuario_interno_comprador_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	function afterFind($results, $primary = false){
		foreach ($results as $key => $val) {
			if(isset($val['EmpresaProducto']['cantidad'])){
				$results[$key]['EmpresaProducto']['avisos_restantes'] = $val['EmpresaProducto']['cantidad'] - $val['EmpresaProducto']['usados'];
			}
			if(isset($val['EmpresaProducto']['ffin'])){
				$now = strtotime(date('Y-m-d'));
				$your_date = strtotime($val['EmpresaProducto']['ffin']);
				$datediff = $your_date - $now;
				$results[$key]['EmpresaProducto']['dias_restantes'] = floor($datediff/(60*60*24));
			}
		}
		return $results;
	}
	
	function agregar($data){
		$retorno = array('status'=>false, 'message'=>'Error');
		//var_dump($data);exit;
		if($this->save($data)){
			$retorno['status'] = true;
		}
		return $retorno;
	}
	
	function GetByEmpresa($empresa_id){
		$this->recursive = -1;
	
		$productos = $this->find('all',array(
			'conditions'=>array(
				'EmpresaProducto.empresa_id'=>$empresa_id,
				'EmpresaProducto.deleted'=>null,
				'EmpresaProducto.finicio !='=>null,
				'EmpresaProducto.activo'=>1
			),
			'order'=>'EmpresaProducto.created DESC'
		));
		
		$dias_restantes = 0;
		$avisos_restantes = 0;
		$use_product_index = 0;
		
		foreach($productos as $index => $producto){
			if(isset($producto['EmpresaProducto']['dias_restantes']) && $producto['EmpresaProducto']['dias_restantes'] > $dias_restantes){
				$dias_restantes = $producto['EmpresaProducto']['dias_restantes'];
				$use_product_index = $index+1;
			}
			if(isset($producto['EmpresaProducto']['avisos_restantes']) && $producto['EmpresaProducto']['avisos_restantes'] > $avisos_restantes){
				$avisos_restantes += $producto['EmpresaProducto']['avisos_restantes'];
				if($dias_restantes==0){$use_product_index = $index+1;}
			}
		}
		
		return ($use_product_index>0?array('dias_restantes'=>$dias_restantes,'avisos_restantes'=>$avisos_restantes,'producto'=>$productos[$use_product_index-1]):false);
	}
	
	function AddAvisoByEmpresa($empresa_id){
		if($producto = $this->GetByEmpresa($empresa_id)){
		
			$producto = $producto['producto'];
			
			$this->id = $producto['EmpresaProducto']['id'];
			
			$producto['EmpresaProducto']['fultimouso'] = date('Y-m-d');
			if($producto['EmpresaProducto']['usados'] == null){$producto['EmpresaProducto']['usados'] == 0;}
			$producto['EmpresaProducto']['usados']++;
			
			if($this->save($producto)){
				return $producto['EmpresaProducto']['id'];
			}else{
				return false;
			}
		}
	}
	
	function Activar(){
	
		$this->recursive = -1;
		$empresa_producto = $this->read();
	
		$this->Producto->Behaviors->attach('Containable');
		$producto = $this->Producto->find('first',array('conditions'=>array('Producto.id'=>$empresa_producto['EmpresaProducto']['producto_id']),'contain'=>array('Configuracion')));
		
		$data['EmpresaProducto']['finicio'] = date('Y-m-d');
		$data['EmpresaProducto']['activo'] = 1;
		
		$data['EmpresaProducto']['importe'] = $producto['Configuracion']['importe'];
		$data['EmpresaProducto']['fpagado'] = date('Y-m-d');
		
		if($producto['Configuracion']['cantidad'] != null){
			$data['EmpresaProducto']['cantidad'] = $producto['Configuracion']['cantidad'];
		}
		
		if($producto['Configuracion']['dias_vigencia'] != null){
			$data['EmpresaProducto']['ffin'] = date('Y-m-d', strtotime($data['EmpresaProducto']['finicio']. ' + '.$producto['Configuracion']['dias_vigencia'].' days'));
		}else{
			$data['EmpresaProducto']['ffin'] = date('Y-m-d', strtotime($data['EmpresaProducto']['finicio']. ' + 6 months'));
		}
		
		if($this->save($data)){
			return $data;
		}else{
			return false;
		}
	}
	
	function Desactivar(){
		$data['EmpresaProducto']['activo'] = 0;
		if($this->save($data)){
			return true;
		}else{
			return false;
		}
	}
}
?>