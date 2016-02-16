<?php
App::uses('AppController', 'Controller');

class EmpresasController extends AppController{

	public $uses = array('Empresa');
	public $components = array('Paginator');
	
	function beforeFilter(){
		parent::beforeFilter();
	}
	
	function index(){
		$this->layout = 'empresas';
	}
	
	function add(){
		$this->layout = 'empresas';
		if(!empty($this->data)){
			$response = $this->Empresa->guardar($this->data);
			if($response['status']){
				$this->login(array('UsuarioInterno'=>$this->data));
			}else{
				$this->set('errores',$response['error']);
				$this->set('valores',$this->data);
			}
		}
		$this->set('paises',$this->Empresa->Provincia->Pais->getCombo());
		$this->set('industrias',$this->Empresa->LaboralIndustria->getCombo());
	}
	
	function login($data = null){
		if(!empty($this->data) || !empty($data)){
			if(!empty($this->data) && empty($data)){$data = array('UsuarioInterno'=>$this->data);}
			if($user = $this->UsuarioInterno->Login($data)){
				$this->Session->write('UsuarioInterno',$user);
				$this->redirect(array('controller'=>'avisos','action'=>'index','empresa'=>true));
			}else{
				$this->redirect('/');
			}
		}
		exit;
	}
	
	function get_usuarios_internos($empresa_id = null){
		if($empresa_id != null){
			$this->Empresa->UsuarioInterno->Behaviors->attach('Containable');
			$conditions = array('UsuarioInterno.empresa_id'=>$empresa_id);
			$contain = array('Rol');
			echo json_encode($this->Empresa->UsuarioInterno->find('all',array('conditions'=>$conditions,'contain'=>$contain)));
		}else{
			echo 'error';
		}
		exit;
	}
	
	/* Sección Empresas */

	function empresa_edit(){
		if(!empty($this->data)){
			$data = $this->data;
			$data['modificar'] = true;
			$response = $this->Empresa->guardar($this->data,true);
			if($response['status']){
				$this->redirect(array('controller'=>'avisos','action'=>'index','empresa'=>true));
			}else{
				$this->set('errores',$response['error']);
				$this->set('valores',$this->data);
			}
		}
		$this->set('pais',$this->Empresa->Provincia->getPais($this->SessionUsuarioInterno['Empresa']['provincia_id']));
		$this->set('paises',$this->Empresa->Provincia->Pais->getCombo());
		$this->set('industrias',$this->Empresa->LaboralIndustria->getCombo());
		$this->render('/Empresas/add');
	}
	
	function cambiar_clave($token = null){
		if(isset($this->SessionUsuario) || $token != null || isset($this->data['token'])){
			if(!empty($this->data)){
				if(isset($this->SessionUsuario)){
					if($this->data['password'] == $this->SessionUsuario['UsuarioInterno']['password']){
						$this->Empresa->UsuarioInterno->id = $this->SessionUsuario['UsuarioInterno']['id'];
					}
				}elseif(isset($this->data['token'])){
					if($usuario = $this->Empresa->UsuarioInterno->find('first',array('conditions'=>array('UsuarioInterno.token'=>$this->data['token'])))){
						$this->Empresa->UsuarioInterno->id = $usuario['UsuarioInterno']['id'];
					}
				}
				if($this->UsuarioInterno->id != null && $this->UsuarioInterno->ChangePassword($this->data)){
					$this->redirect('/empresas');
				}else{
					$this->render('/Pages/inicio-postulante-contrasena');
				}
			}else{
				if($this->UsuarioInterno->find('count',array('conditions'=>array('UsuarioInterno.token'=>$token)))){
					$this->set('token',$token);
					$this->set('empresa',true);
					$this->render('/Pages/inicio-postulante-contrasena');
				}else{
					$this->redirect('/empresas');
				}
			}
		}else{
			$this->redirect('/empresas');
		}
	}
	
	/* Sección Control */
	
	function control_index(){
		$this->Empresa->Behaviors->attach('Containable');
		
		$conditions = array();
		
		if(!empty($this->data)){
			foreach($this->data as $model => $values){
				foreach($values as $field => $value){
					if($value != ''){
						$conditions[$model.'.'.$field] = $value;
					}
				}
			}
		
		}
		
		$this->Paginator->settings = array(
			'conditions' => $conditions,
			'contain' => array('LaboralIndustria','Provincia'=>array('Pais')),
			'limit' => 20
		);
		
		$empresas = $this->Paginator->paginate('Empresa');
		$this->set(compact('empresas'));
		
		$this->set('industrias',$this->Empresa->LaboralIndustria->getCombo());
	}
	
	function control_toggle_active($empresa_id = null){
		if($empresa_id != null){
			$this->Empresa->id = $empresa_id;
			$this->Empresa->recursive = -1;
			$empresa = $this->Empresa->read();
			if($empresa['Empresa']['activa'] == 1){
				$this->Empresa->saveField('activa',0);
				echo 'off';
			}else{
				$this->Empresa->saveField('activa',1);
				echo 'on';
			}
		}else{
			echo 'error';
		}
		exit;
	}
	
	function control_get_count(){
		$this->Empresa->Behaviors->attach('Containable');
		$conditions = array();
		echo $this->Empresa->find('count',array('conditions'=>$conditions));
		exit;
	}
	
	function control_get_grouped_by($group){
		
		$this->Empresa->Behaviors->attach('Containable');
	
		$conditions = array();
		
		if(!empty($this->data)){
			foreach($this->data as $model => $conds){
				foreach($conds as $cond => $value){
					if($value != ''){
						if(strpos($cond,'created') !== false){
							$date = new DateTime(str_replace('/','-',$value));
							$value = $date->format('Y-m-d');
						}
						$conditions[$model.'.'.$cond] = $value;
					}
				}
			}
		}
		
		$contain = array();
		
		$group_exploded = explode('.',$group);
		
		if(count($group_exploded) == 1){
			$model = 'Empresa';
			$campo = $group_exploded[0];
			$field = $group_exploded[0];
		}elseif(count($group_exploded) <= 2){
			$model = $group_exploded[0];
			$campo = $group_exploded[1];
			$contain[] = $group_exploded[0];
			$field = $group_exploded[0].'.'.$group_exploded[1];
		}
		
		$fields = array('COUNT(*) AS count', $field);
		
		$empresas = $this->Empresa->find('all',array('fields'=>$fields, 'contain'=>$contain, 'group'=>$field, 'conditions'=>$conditions));
		
		foreach($empresas as $i => $empresa){
			$field_buscado = $empresa[$model][$campo];
			$empresas[$i][0]['name'] = $field_buscado;
		}
		
		echo json_encode($empresas);
		exit;
	}
}