<?php
App::uses('AppController', 'Controller');

class AvisosController extends AppController{

	var $uses = array('Aviso');
	public $components = array('Paginator');
    
	function beforeFilter(){
		parent::beforeFilter();
		$this->set('areas_avisos',$this->Aviso->LaboralArea->getCombo());
		$this->set('ubicaciones_avisos',$this->Aviso->Provincia->getCombo(18));
	}
	
	function destacados() //Home
	{
		$this->CheckLogin();
		
		$destacados = $this->Aviso->find('all',array('conditions'=>array('Aviso.habilitado' => '1', 'Aviso.destacado' => '1'), 'contain'=>array('Provincia','LaboralTipoTrabajo')));
		if(count($destacados) < 15){
			$avisos = $this->Aviso->find('all',array('conditions'=>array('Aviso.habilitado' => '1', 'Aviso.destacado' => '0'), 'contain'=>array('Provincia','LaboralTipoTrabajo'), 'limit' => 15 - count($destacados)));
			foreach($avisos as $aviso){
				$destacados[] = $aviso;
			}
		}
		
		if(isset($this->SessionUsuario['Usuario']['id'])){ //Si se está logueado
			$this->Aviso->CurriculumAviso->Behaviors->attach('Containable');
			$contain = array('Aviso'=>array('Provincia','LaboralTipoTrabajo'));
			if($postulaciones = $this->Aviso->CurriculumAviso->find('all',array('conditions'=>array('CurriculumAviso.usuario_id' => $this->SessionUsuario['Usuario']['id']),'contain'=>$contain))){
				foreach($postulaciones as $postulacion){
					foreach($destacados as $i => $aviso){
						if($aviso['Aviso']['id'] == $postulacion['CurriculumAviso']['aviso_id']){
							$destacados[$i]['Aviso']['postulado'] = true;
						}
					}
				}
			}
		}
		
		$this->set('destacados',$destacados);
		$this->render('/Pages/home');
	}
	
	function index(){
		$conditions = array();

		foreach($this->params->params as $pkey => $param){
			if(strpos($pkey,'cod') !== false){
				$type = preg_replace("/(\d+)/", "", $param);
				$id = preg_replace("/[ap]/", "", $param);
				switch($type){
					case 'a': //Area
					$conditions['Aviso.area_id'] = $id;
					break;
					case 'p': //Provincia
					$conditions['Aviso.provincia_id'] = $id;
					break;
				}
			}
		}
		
		$avisos = $this->Aviso->find('all',array('conditions'=>$conditions, 'contain'=>array('Provincia','LaboralTipoTrabajo')));
		$this->set('conditions',$conditions);
		$this->set('avisos',$avisos);
	}
	
	function busqueda(){
		if(!empty($this->data)){
			$conditions['MATCH(Aviso.puesto, Aviso.descripcion, Aviso.extra_data) AGAINST(? IN BOOLEAN MODE)'] = $this->data['Aviso']['keywords'];
			$contain = array('Provincia','LaboralTipoTrabajo');
			$avisos = $this->Aviso->find('all',array('conditions'=>$conditions,'contain'=>$contain));
			$this->set('busqueda',$this->data['Aviso']['keywords']);
			$this->set('conditions',$conditions);
			$this->set('avisos',$avisos);
		}else{
			$this->redirect(array('controller'=>'avisos','action'=>'index'));
		}
		$this->render('/Avisos/index');
	}
	
	function ver($id = null, $postulado = false){
		if($id != null){
			$this->Aviso->id = $id;
			$contain = array('LaboralArea','LaboralTipoTrabajo','Provincia'=>array('Pais'));
			if($aviso = $this->Aviso->find('first',array('conditions'=>array('Aviso.id'=>$id),'contain'=>$contain))){
				$avisos_relacionados = $this->Aviso->GetRelated($aviso);
				if($this->CheckLogin()){
					$postulaciones = $this->Aviso->CurriculumAviso->TraerPorUsuario($this->SessionUsuario);
					foreach($postulaciones as $postulacion){
						/*foreach($avisos_relacionados as $i => $aviso){
							if($aviso['Aviso']['id'] == $postulacion['Aviso']['id']){
								unset($avisos_relacionados[$i]);
							}
						}*/
						if($id == $postulacion['Aviso']['id']){
							$this->set('postulacion',true);
						}
					}
				}
				$this->set('postulado',$postulado);
				$this->set('aviso',$aviso);
				$this->set('avisos_relacionados',$avisos_relacionados);
			}
		}
	}
	
	function postular($id = null){
		if($this->CheckLogin(true)){
			if($id != null){
				$data['CurriculumAviso']['aviso_id'] = $id;
				$data['CurriculumAviso']['usuario_id'] = $this->SessionUsuario['Usuario']['id'];
				$response = $this->Aviso->CurriculumAviso->agregar($data);
				if($response['status']){
					$count = $this->Aviso->CurriculumAviso->find('count',array('conditions'=>array('CurriculumAviso.aviso_id'=>$id)));
					$this->Aviso->id = $id;
					$this->Aviso->saveField('aplicantes_count',$count);
					echo 'ok';
				}else{
					var_dump($response['errores']);
				}
			}
		}
		exit;
	}
	
	function postulaciones(){
		if($this->CheckLogin(true)){
			$this->set('avisos',$this->Aviso->CurriculumAviso->TraerPorUsuario($this->SessionUsuario));
		}
	}
	
	function get_ajax($aviso_id = null){
		if(!empty($aviso_id)){
			$this->Aviso->recursive = -1;
			$this->Aviso->id = $aviso_id;
			echo json_encode($this->Aviso->read());
		}
		exit;
	}
	
	/* Sección Empresa */
	
	function empresa_add(){
		if(!empty($this->data)){
		
			$data = array('Aviso'=>$this->data);
			$data['Aviso']['empresa_id'] = $this->SessionUsuarioInterno['Empresa']['id'];
			$data['Aviso']['usuario_interno_id'] = $this->SessionUsuarioInterno['UsuarioInterno']['id'];
			
			$response = $this->Aviso->guardar($data);
			$this->Session->setFlash($response['message']);
			
			if($response['status']){
				$this->redirect(array('controller'=>'avisos','action'=>'index'));
			}else{
				$this->set('errores',$response['error']);
				$this->set('valores',$this->data);
			}
			
		}elseif(!$this->Aviso->EmpresaProducto->GetByEmpresa($this->SessionUsuarioInterno['Empresa']['id'])){
			$this->Session->setFlash('No tiene ningun plan de avisos activo,<br>para comprar haga click <a href="'.Router::Url(array('controller'=>'productos','action'=>'index')).'">aqui</a>');
			$this->redirect(array('controller'=>'avisos','action'=>'index'));
		}
		
		$this->set('areas',$this->Aviso->LaboralArea->getCombo());
		$this->set('niveles',$this->Aviso->LaboralNivelPuesto->getCombo());
		$this->set('tipos',$this->Aviso->LaboralTipoTrabajo->getCombo());
		$this->set('paises',$this->Aviso->Provincia->Pais->getCombo());
		$this->set('pais',18);
		$this->set('provincias',$this->Aviso->Provincia->getCombo());
		$this->set('usuarios_internos',$this->Aviso->UsuarioInterno->find('all',array('conditions'=>array('UsuarioInterno.empresa_id'=>$this->SessionUsuarioInterno['Empresa']['id']))));
	}
	
	function empresa_editar($id = null){
		if($id != null){
			if($aviso = $this->Aviso->find('first',array('conditions'=>array('Aviso.id'=>$id)))){
				if($aviso['Aviso']['aplicantes_count'] < 1 || $aviso['Aviso']['habilitado'] < 2){
					$this->set('areas',$this->Aviso->LaboralArea->getCombo());
					$this->set('niveles',$this->Aviso->LaboralNivelPuesto->getCombo());
					$this->set('tipos',$this->Aviso->LaboralTipoTrabajo->getCombo());
					$this->set('paises',$this->Aviso->Provincia->Pais->getCombo());
					$this->set('pais',$this->Aviso->Provincia->getPais($aviso['Aviso']['provincia_id']));
					$this->set('provincias',$this->Aviso->Provincia->getCombo());
					$this->set('usuarios_internos',$this->Aviso->UsuarioInterno->find('all',array('conditions'=>array('UsuarioInterno.empresa_id'=>$this->SessionUsuarioInterno['Empresa']['id']))));
					$this->set('aviso',$aviso);
					$this->render('/Avisos/empresa_add');
				}else{
					$this->redirect(array('controller'=>'avisos','action'=>'index'));
				}
			}
		}
	}
	
	function empresa_index(){
		$this->set('avisos',$this->Aviso->TraerAvisosPorUsuario($this->SessionUsuarioInterno));
		$this->set('usuarios_internos',$this->UsuarioInterno->find('all',array('conditions'=>array('UsuarioInterno.empresa_id'=>$this->SessionUsuarioInterno['Empresa']['id']))));
	}
	
	function empresa_cambiar_permisos(){
		if(isset($this->data)){
			$this->Aviso->id = $this->data['aviso_id'];
			if($this->Aviso->saveField('permiso_id',$this->data['permiso_id'])){
				if(isset($this->data['usuarios_internos'])){
					$this->Aviso->AvisoPermiso->deleteAll(array('AvisoPermiso.aviso_id' => $this->data['aviso_id']), false);
					foreach($this->data['usuarios_internos'] as $user_id){
						$data['AvisoPermiso']['aviso_id'] = $this->data['aviso_id'];
						$data['AvisoPermiso']['usuario_interno_id'] = $user_id;
						$this->Aviso->AvisoPermiso->create();
						$this->Aviso->AvisoPermiso->save($data);
					}
				}
				echo 'ok';
			}else{
				echo 'error';
			}
		}
		exit;
	}
	
	function empresa_postulante_favorito($id = null){
		if($id != null){
			$this->Aviso->CurriculumAviso->id = $id;
			$this->Aviso->CurriculumAviso->recursive = -1;
			$postulante = $this->Aviso->CurriculumAviso->read();
			if($postulante['CurriculumAviso']['preferido'] == 1){
				$this->Aviso->CurriculumAviso->saveField('preferido',0);
			}else{
				$this->Aviso->CurriculumAviso->saveField('preferido',1);
			}
			if($this->Aviso->CurriculumAviso->saveField('usuario_interno_id',$this->SessionUsuarioInterno['UsuarioInterno']['id'])){
				echo 'ok';
			}else{
				echo 'error';
			}
		}
		exit;
	}
	
	/* Sección Control */
	
	function control_index(){
		$this->Aviso->Behaviors->attach('Containable');
		
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
			'contain' => array(/*'LaboralIndustria','Provincia'=>array('Pais')*/),
			'limit' => 20
		);
		
		$avisos = $this->Paginator->paginate('Aviso');
		$this->set(compact('avisos'));
		
		$this->set('industrias',$this->Empresa->LaboralIndustria->getCombo());
	}
	
	function control_destacado($id = null){
		if($id != null){
			$this->Aviso->id = $id;
			$this->Aviso->recursive = -1;
			$aviso = $this->Aviso->read();
			if($aviso['Aviso']['destacado']){
				$this->Aviso->saveField('destacado',0);
			}else{
				$this->Aviso->saveField('destacado',1);
			}
			echo 'ok';
		}
		exit;
	}
	
	function control_toggle_active($id = null){
		if($id != null){
			$this->Aviso->id = $id;
			$this->Aviso->recursive = -1;
			$aviso = $this->Aviso->read();
			if($aviso['Aviso']['habilitado'] == 1){
				if($this->Aviso->saveField('habilitado',0)){
					echo 'off';
				}
			}else{
				if($this->Aviso->saveField('habilitado',1)){
					echo 'on';
				}
			}
		}else{
			echo 'error';
		}
		exit;
	}
	
	function control_get_count(){
		$this->Aviso->Behaviors->attach('Containable');
		$conditions = array();
		echo $this->Aviso->find('count',array('conditions'=>$conditions));
		exit;
	}
	
	function control_get_grouped_by($group){
	
		$this->Aviso->Behaviors->attach('Containable');
	
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
			$model = 'Aviso';
			$campo = $group_exploded[0];
			$field = $group_exploded[0];
		}elseif(count($group_exploded) <= 2){
			$model = $group_exploded[0];
			$campo = $group_exploded[1];
			$contain[] = $group_exploded[0];
			$field = $group_exploded[0].'.'.$group_exploded[1];
		}
		
		$fields = array('COUNT(*) AS count', $field);
		
		$avisos = $this->Aviso->find('all',array('fields'=>$fields, 'contain'=>$contain, 'group'=>$field, 'conditions'=>$conditions));
		
		foreach($avisos as $i => $aviso){
			$field_buscado = $aviso[$model][$campo];
			$avisos[$i][0]['name'] = $field_buscado;
		}
		
		echo json_encode($avisos);
		exit;
	}
}
?>