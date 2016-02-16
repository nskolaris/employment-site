<?php
class Aviso extends AppModel {
	var $name = 'Aviso';
	var $useTable = 'avisos';
	
	var $belongsTo = array(
		'Empresa' => array(
			'className' => 'Empresa',
			'foreignKey' => 'empresa_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'EmpresaProducto' => array(
			'className' => 'EmpresaProducto',
			'foreignKey' => 'empresa_producto_id',
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
		),
		'LaboralArea' => array(
			'className' => 'LaboralArea',
			'foreignKey' => 'area_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'LaboralNivelPuesto' => array(
			'className' => 'LaboralNivelPuesto',
			'foreignKey' => 'nivel_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'LaboralTipoTrabajo' => array(
			'className' => 'LaboralTipoTrabajo',
			'foreignKey' => 'tipotrabajo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Provincia' => array(
			'className' => 'Provincia',
			'foreignKey' => 'provincia_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Permiso' => array(
			'className' => 'Permiso',
			'foreignKey' => 'permiso_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);
	
	var $hasMany = array(
		'CurriculumAviso' => array(
			'className' => 'CurriculumAviso',
			'foreignKey' => 'aviso_id',
			'dependent' => false,
		),
		'AvisoPermiso' => array(
			'className' => 'AvisoPermiso',
			'foreignKey' => 'aviso_id',
			'dependent' => false,
		)
	);
	
	/* Validacion */
	
	public $validate = array(
		'puesto' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'El Puesto no puede estar vacio'
			)
		),
		'descripcion' => array(
			'rule' => 'notEmpty',
			'message' => 'La Descripción no puede estar vacia'
		),
		'provincia_id' => array(
			'rule' => 'notEmpty',
			'message' => 'Seleccione un estado'
		),
		'area_id' => array(
			'rule' => 'notEmpty',
			'message' => 'Seleccione un área'
		),
		'tipotrabajo_id' => array(
			'rule' => 'notEmpty',
			'message' => 'Seleccione un tipo de trabajo'
		),
		'nivel_id' => array(
			'rule' => 'notEmpty',
			'message' => 'Seleccione un nivel'
		),
		'sueldo_bruto' => array(
			'rule' => 'numeric',
			'message' => 'El sueldo bruto tiene un formato invalido'
		)
    );
	
	/* Funciones */
	
	function beforeSave(){
		$vendorpath = App::path('Vendor');
		require_once $vendorpath[0].'HtmlPurifier/HTMLPurifier.auto.php';
		$config = HTMLPurifier_Config::createDefault();
		$config->set('HTML', 'Allowed', $value);
		$purifier = new HTMLPurifier($config);
		$this->data['Aviso']['descripcion'] = $purifier->purify($this->data['Aviso']['descripcion']);
		$this->data['Aviso']['puesto'] = $purifier->purify($this->data['Aviso']['puesto']);
		$this->data['Aviso']['barrio'] = $purifier->purify($this->data['Aviso']['barrio']);
	}
	
	function afterSave($created, $options = array()){
		$this->Behaviors->attach('Containable');
		
		$aviso = $this->find('first',array(
			'conditions'=>array('Aviso.id'=>$this->id),
			'contain'=>array('Empresa'=>array('LaboralIndustria','Provincia'),'LaboralArea','LaboralNivelPuesto','LaboralTipoTrabajo','Provincia')
		));

		$extra_data = $aviso['Empresa']['nombre_comercial'].' ';
		$extra_data .= $aviso['Empresa']['razon_social'].' ';
		$extra_data .= $aviso['Empresa']['calle'].' ';
		$extra_data .= $aviso['Empresa']['Provincia']['denominacion'].' ';
		$extra_data .= $aviso['Empresa']['LaboralIndustria']['denominacion'].' ';
		$extra_data .= $aviso['LaboralArea']['denominacion'].' ';
		$extra_data .= $aviso['LaboralNivelPuesto']['denominacion'].' ';
		$extra_data .= $aviso['LaboralTipoTrabajo']['denominacion'].' ';
		$extra_data .= $aviso['Provincia']['denominacion'].' ';
		
		if(!isset($this->saved_extra_data)){
			$this->saved_extra_data = true;
			$this->saveField('extra_data',$extra_data);
		}
	}
	
	function beforeFind($query){
        parent::beforeFind($query);
        $defaultConditions = array('Empresa.activa' => 1);
        $query['conditions'] = array_merge((isset($query['conditions'])?$query['conditions']:array()), $defaultConditions);
        return $query;
    }
	
	function afterFind($results, $primary = false){
		foreach ($results as $key => $val) {
			if(isset($val['Aviso']['ffin'])){
				$now = strtotime(date('Y-m-d'));
				$your_date = strtotime($val['Aviso']['ffin']);
				$datediff = $your_date - $now;
				$results[$key]['Aviso']['dias_restantes'] = floor($datediff/(60*60*24));
				if($results[$key]['Aviso']['dias_restantes'] < 0){
					if($results[$key]['Aviso']['dias_restantes'] < -30){
						if($val['Aviso']['habilitado'] < 3){
							$results[$key]['Aviso']['habilitado'] = 3;
							$this->Deshabilitar($val['Aviso']['id'],3);
						}
					}else{
						if($val['Aviso']['habilitado'] < 2){
							$results[$key]['Aviso']['habilitado'] = 2;
							$this->Deshabilitar($val['Aviso']['id']);
						}
					}
					
				}
			}
			if(isset($val['Aviso']['finicio'])){
				$time = strtotime($val['Aviso']['finicio']);
				$results[$key]['Aviso']['tiempo'] = $this->humanTiming($time);
				$results[$key]['Aviso']['finicio_formateada'] = $this->formatoFecha($val['Aviso']['finicio']);
			}
			
			$vendorpath = App::path('Vendor');
			require_once $vendorpath[0].'HtmlPurifier/HTMLPurifier.auto.php';
			$config = HTMLPurifier_Config::createDefault();
			$config->set('HTML.Allowed', 'allowed');
			$purifier = new HTMLPurifier($config);
			$results[$key]['Aviso']['descripcion'] = $purifier->purify($val['Aviso']['descripcion']);
			$results[$key]['Aviso']['puesto'] = $purifier->purify($val['Aviso']['puesto']);
			$results[$key]['Aviso']['barrio'] = $purifier->purify($val['Aviso']['barrio']);
		}
		return $results;
	}
	
	function traerAvisos(){
		$cant = 0;
		
		$avisos = $this->find('all', array('conditions'=>array('deleted'=>null, 'habilitado'=>1), 'order'=>'Aviso.id DESC', 'limit'=>8));
		shuffle($avisos);

		$vigentes = array();

		for($i = 0; $i <= count($avisos)-1; $i++){
	    	if($cant<=3){
	    		$vigentes[$cant] = $avisos[$i];
	    		$cant++;
	    	}
		}
		
		return $vigentes;
	}
	
	public function find($conditions = null, $fields = array(), $order = null, $recursive = null) {
		$this->Behaviors->attach('Containable');
		$this->contain(array('Empresa'));
		return parent::find($conditions, $fields, $order, $recursive);
	}
	
	function Deshabilitar($id,$value=2){
		$this->id = $id;
		$this->saveField('habilitado',$value);
	}
	
	function TraerAvisosPorUsuario($data){
		$this->Behaviors->attach('Containable');
		$avisos = $this->find('all',array(
			'conditions'=>array('Aviso.deleted'=>null, 'Aviso.empresa_id'=>$data['Empresa']['id']),
			'contain'=>array('AvisoPermiso','UsuarioInterno','Permiso','CurriculumAviso')
		));
		$avisos_show = array();
		foreach($avisos as $aviso){
			switch($aviso['Aviso']['permiso_id']){
				case 1:
				$avisos_show[] = $aviso;
				break;
				
				case 2:
				if($aviso['Aviso']['usuario_interno_id'] == $data['UsuarioInterno']['id']){
					$avisos_show[] = $aviso;
				}
				break;
				
				case 3:
				foreach($aviso['AvisoPermiso'] as $permiso){
					if($permiso['usuario_interno_id'] == $data['UsuarioInterno']['id']){
						$avisos_show[] = $aviso;
						break;
					}
				}
				break;
			}
		}
		return $avisos_show;
	}
	
	function guardar($data){
		$response = array('status'=>false,'message'=>'No se pudo guardar el Aviso','error'=>null);
		
		if(!isset($data['Aviso']['id'])){
			//if(isset($data['Aviso']['habilitado'])){
				$data['Aviso']['finicio'] = date('Y-m-d h:m:s');
				$date = date_create($data['Aviso']['finicio']);
				date_add($date, date_interval_create_from_date_string('60 days'));
				$data['Aviso']['ffin'] = date_format($date,'Y-m-d h:m:s');
			//}			
		}else{
			$data['Aviso']['permiso_id'] = 1;
		}

		if(isset($data['Aviso']['habilitado'])){$data['Aviso']['habilitado']=1;}
		
		if($this->validates()){
			if(!isset($data['Aviso']['id'])){
				if($empresa_producto_id = $this->EmpresaProducto->AddAvisoByEmpresa($data['Aviso']['empresa_id'])){
					$data['Aviso']['empresa_producto_id'] = $empresa_producto_id;
				}
			}
		}else{
			$response['error'] = $this->validationErrors;
		}
		
		if($this->save($data)){
		
			if($data['Aviso']['permiso_id'] == '3'){
				foreach($data as $key => $value){
					$this->AvisoPermiso->deleteAll(array('AvisoPermiso.aviso_id' => $this->id), false);
					if(strpos($key,'usuario-interno') !== false){
						$usuario_interno_id = str_replace('usuario-interno-','',$key);
						$data['AvisoPermiso']['aviso_id'] = $this->id;
						$data['AvisoPermiso']['usuario_interno_id'] = $usuario_interno_id;
						$this->AvisoPermiso->create();
						$this->AvisoPermiso->save($data);
					}
				}
			}
		
			$response['status'] = true;
			$response['message'] = 'El aviso se guardo con exito';
		}else{
			$response['error'] = $this->invalidFields();                 
		}


		return $response;
	}
	
	function GetRelated($aviso){
		$conditions = array();
		$conditions['Aviso.id !='] = $aviso['Aviso']['id'];
		$conditions['Aviso.area_id'] = $aviso['Aviso']['area_id'];
		$conditions['Aviso.provincia_id'] = $aviso['Aviso']['provincia_id'];
		$conditions['Aviso.deleted'] = null;
		return $this->find('all',array('conditions'=>$conditions,'limit'=>'3'));
	}
	
	function GetNoVencido($id){
		$fecha_vencido = date_create(date('Y-m-d h:m:s'));
		date_add($fecha_vencido, date_interval_create_from_date_string('30 days'));
		$conditions = array('Aviso.habilitado <'=>3,'Aviso.ffin <'=>date_format($fecha_vencido,'Y-m-d h:m:s'),'Aviso.id'=>$id);
		return $this->find('count',array('conditions'=>$conditions));
	}
}
?>