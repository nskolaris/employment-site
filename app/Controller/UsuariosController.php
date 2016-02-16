<?php
App::uses('AppController', 'Controller');

class UsuariosController extends AppController{

	public $uses = array('Pais','Provincia','TipoDocumento','LaboralNivelPuesto','LaboralArea','LaboralIndustria','Estudio','ConocimientoIdioma');
	public $components = array('Paginator');
	
	function validate_register(){
		if(!empty($this->data)){
			$this->Usuario->set(array('Usuario'=>$this->data));
			if($this->Usuario->validates()){
				echo 'ok';
			}else{
				echo json_encode($this->Usuario->validationErrors);
			}
		}
		exit;
	}
	
	function add(){
		if(!empty($this->data)){
			$data = array('Usuario'=>$this->data);
			if($this->Usuario->save($data)){
				$data['Usuario']['current_page'] = array('controller'=>'usuarios','action'=>'datos');
				$this->login($data);
			}
		}
		exit;
	}
	
	function validate_login(){
		if(!empty($this->data)){
			$data = $this->data;
			$data['login'] = true;
			$this->Usuario->set(array('Usuario'=>$data));
			if($this->Usuario->validates()){
				echo 'ok';
			}else{
				echo json_encode($this->Usuario->validationErrors);
			}
		}
		exit;
	}
	
	function login($data = null){
		if(!empty($this->data) || !empty($data)){
			if(!empty($this->data) && empty($data)){$data = array('Usuario'=>$this->data);}
			if($user = $this->Usuario->Login($data)){
				$this->Session->write('Usuario',$user);
				if(isset($data['Usuario']['postulacion_attempt'])){
					$this->postular($data['Usuario']);
				}else{
					if(!empty($data['Usuario']['current_page'])){$this->redirect($data['Usuario']['current_page']);}else{$this->redirect('/');}
				}
			}else{
				if(!empty($data['Usuario']['current_page'])){$this->redirect($data['Usuario']['current_page']);}else{$this->redirect('/');}
			}
		}
		exit;
	}
	
	function postular($data_login){
		$this->CheckLogin();
		$data['CurriculumAviso']['aviso_id'] = $data_login['postulacion_attempt'];
		$data['CurriculumAviso']['usuario_id'] = $this->SessionUsuario['Usuario']['id'];
		$response = $this->Usuario->CurriculumAviso->agregar($data);
		if($response['status']){
			$count = $this->Usuario->CurriculumAviso->find('count',array('conditions'=>array('CurriculumAviso.aviso_id'=>$data_login['postulacion_attempt'])));
			$this->Usuario->CurriculumAviso->Aviso->id = $data_login['postulacion_attempt'];
			$this->Usuario->CurriculumAviso->Aviso->saveField('aplicantes_count',$count);
			$this->redirect(array('controller'=>'avisos','action'=>'ver',$data_login['postulacion_attempt'],1));
		}
	}
	
	function datos(){
		if(isset($this->SessionUsuario)){
			$this->Usuario->id = $this->SessionUsuario['Usuario']['id'];
			$this->Usuario->recursive = 2;
			$user = $this->Usuario->read();
			$this->set('user',$user);
			
			/* Seteo los combos */
			$dias = array();
			for($i=1;$i<=31;$i++){$dias[$i] = $i;}
			$this->set('dias',$dias);
			$meses = array();
			
			$this->set('meses',$this->Usuario->GetMeses());
			$anios = array();
			for($i=2014;$i>1900;$i--){$anios[$i] = $i;}
			$this->set('anios',$anios);
			$this->set('paises',$this->Pais->getCombo());
			$this->set('tipos_documentos',$this->TipoDocumento->getCombo());
			$this->set('niveles_puestos',$this->LaboralNivelPuesto->getCombo());
			$this->set('areas_laborales',$this->LaboralArea->getCombo());
			$this->set('industrias',$this->LaboralIndustria->getCombo());
			$this->set('estudio_instituciones',$this->Estudio->EstudioInstitucion->getCombo());
			$this->set('estudio_niveles',$this->Estudio->EstudioNivel->getCombo());
			
			$this->set('idiomas',$this->ConocimientoIdioma->ConocIdioma->getCombo());
			$this->set('idioma_niveles',$this->ConocimientoIdioma->ConocNivelOral->getCombo());
			
			$this->set('software',$this->Usuario->ConocimientoInformatica->ConocSoftware->getCombo());
			$this->set('niveles_conocimiento',$this->Usuario->ConocimientoInformatica->ConocNivel->getCombo());
			
			$this->render('/Pages/inicio-postulante-micv');
		}else{
			$this->redirect('/');
		}
	}
	
	function cambiar_clave($token = null){
		if(isset($this->SessionUsuario) || $token != null || isset($this->data['token'])){
			if(!empty($this->data)){
				if(isset($this->SessionUsuario)){
					if($this->data['password'] == $this->SessionUsuario['Usuario']['password']){
						$this->Usuario->id = $this->SessionUsuario['Usuario']['id'];
					}
				}elseif(isset($this->data['token'])){
					if($usuario = $this->Usuario->find('first',array('conditions'=>array('Usuario.token'=>$this->data['token'])))){
						$this->Usuario->id = $usuario['Usuario']['id'];
					}
				}
				if($this->Usuario->id != null && $this->Usuario->ChangePassword($this->data)){
					$this->redirect('/');
				}else{
					$this->render('/Pages/inicio-postulante-contrasena');
				}
				
			}else{
				if($this->Usuario->find('count',array('conditions'=>array('Usuario.token'=>$token)))){
					$this->set('token',$token);
					$this->render('/Pages/inicio-postulante-contrasena');
				}else{
					$this->redirect('/');
				}
			}
		}else{
			$this->redirect('/');
		}
	}
	
	function recover_password(){
		if(isset($this->data)){
			$response = $this->Usuario->RecoverPassword($this->data['email']);
			echo json_encode($response);	
		}
		exit;
	}
	
	function recover_password_empresa(){
		if(isset($this->data)){
			$response = $this->UsuarioInterno->RecoverPassword($this->data['username']);
			echo json_encode($response);	
		}
		exit;
	}
	
	function get_profile_pic_thumb(){
		if(!empty($this->data)){
			$this->layout = null;
			foreach($this->data as $i => $value){
				$this->set($i,$value);
			}
		}
	}
	
	/* Sección Empresas */
	
	function empresa_ver($id = null){
		if($id != null){
			$this->layout = 'empresas_back';
			$this->Usuario->id = $id;
			$this->Usuario->recursive = 2;
			$user = $this->Usuario->read();
			$this->set('postulante',$user);
		}elseif(isset($this->data['user_id'])){
			$this->Usuario->id = $this->data['user_id'];
			$this->Usuario->recursive = 2;
			$user = $this->Usuario->read();
			echo json_encode($user);
			exit;
		}
	}
	
	/* Sección Control */
	
	function control_login(){
		if(!empty($this->data)){
			$data['Admin'] = $this->data;
			if($admin = $this->Admin->Login($data)){
				$this->Session->write('Admin',$admin);
				$this->redirect(array('controller'=>'pages','action'=>'home'));
			}
		}
	}
	
	function control_gestionar(){

		$this->Usuario->Behaviors->attach('Containable');
		
		$conditions = array();
		$contain = array('DatosPersonales','Estudio','Experiencia');
		$joins = array(
			array(
				'table' => 'estudios',
				'alias' => 'Estudio',
				'type' => 'LEFT',
				'conditions' => array(
					'Estudio.usuario_id = Usuario.id',
				)
			),
			array(
				'table' => 'experiencias',
				'alias' => 'Experiencia',
				'type' => 'LEFT',
				'conditions' => array(
					'Experiencia.usuario_id = Usuario.id',
				)
			)
		);
		
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
			'contain' => $contain,
			'joins'=>$joins,
			'group' => 'Usuario.id',
			'limit' => 20
		);
		
		$usuarios = $this->Paginator->paginate('Usuario');

		$this->set(compact('usuarios'));
		
		$this->set('sexos', $this->Usuario->DatosPersonales->Sexo->getCombo());
		$this->set('estados_civiles', $this->Usuario->DatosPersonales->EstadoCivil->getCombo());
		$this->set('paises', $this->Usuario->DatosPersonales->Pais->getCombo());
		$this->set('provincias',$this->Usuario->DatosPersonales->Provincia->getCombo());
		$this->set('estudio_instituciones',$this->Usuario->Estudio->EstudioInstitucion->getCombo());
		$this->set('estudio_niveles',$this->Usuario->Estudio->EstudioNivel->getCombo());
		$this->set('estudio_areas',$this->Usuario->Estudio->EstudioArea->getCombo());
		$this->set('laboral_nivelpuestos',$this->Usuario->Experiencia->LaboralNivelPuesto->getCombo());
		$this->set('laboral_areas',$this->Usuario->Experiencia->LaboralArea->getCombo());
		$this->set('laboral_industrias',$this->Usuario->Experiencia->LaboralIndustria->getCombo());
	}
	
	function control_get_count(){
		$this->Usuario->Behaviors->attach('Containable');
		$conditions = array();
		echo $this->Usuario->find('count',array('conditions'=>$conditions));
		exit;
	}
	
	function control_get_grouped_by($group){
	
		$this->Usuario->Behaviors->attach('Containable');
	
		$conditions = array();
		$contain = array();
		
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

		$group_exploded = explode('.',$group);
		
		if(count($group_exploded) == 1){
			$model = 'Usuario';
			$campo = $group_exploded[0];
			$field = $group_exploded[0];
		}elseif(count($group_exploded) == 2){
			$model = $group_exploded[0];
			$campo = $group_exploded[1];
			$contain[] = $group_exploded[0];
			$field = $group_exploded[0].'.'.$group_exploded[1];
		}
		
		/* Estudios */
		
		if($model == 'Estudio'){
		
			$this->Usuario->Estudio->Behaviors->attach('Containable');
		
			$estudios = $this->Usuario->Estudio->find('all',array(
				'fields'=>array('MAX(Estudio.nivel_id) AS max_level','EstudioArea.denominacion','EstudioNivel.denominacion'),
				'contain'=>array('EstudioArea','EstudioNivel'),
				'group'=>'Estudio.usuario_id',
				'conditions'=>''
			));
			
			$estudios = $this->Usuario->Estudio->query('
				SELECT e.id, e.usuario_id, ea.denominacion, en.denominacion FROM estudios e
				LEFT JOIN estudio_areas AS ea
				ON ea.id = e.area_id
				LEFT JOIN estudio_niveles AS en
				ON en.id = e.nivel_id
				JOIN 
				(SELECT usuario_id, MAX(nivel_id) maxlevel
				  FROM estudios GROUP BY usuario_id
				) e2
				ON e.nivel_id = e2.maxlevel AND e.usuario_id = e2.usuario_id;
			');
			
			if($campo == 'area_id'){
				foreach($estudios as $estudio){
					$override_array[$estudio['ea']['denominacion']] = (isset($override_array[$estudio['ea']['denominacion']])?$override_array[$estudio['ea']['denominacion']]+1:1);
				}				
			}elseif($campo == 'nivel_id'){
				foreach($estudios as $estudio){
					$override_array[$estudio['en']['denominacion']] = (isset($override_array[$estudio['en']['denominacion']])?$override_array[$estudio['en']['denominacion']]+1:1);
				}
			}
			
			foreach($override_array as $name => $count){
				if($name == ''){$name = 'Sin definir';}
				$return_array[] = array(array('name'=>$name,'count'=>$count));
			}

			echo json_encode($return_array);
			exit;
		}
		
		/* Experiencias */
		
		if($model == 'Experiencia'){
		
			$this->Usuario->Experiencia->Behaviors->attach('Containable');
			
			$experiencias = $this->Usuario->Experiencia->query('
				SELECT e.id, e.usuario_id, ln.denominacion, li.denominacion, la.denominacion FROM experiencias e
				LEFT JOIN laboral_nivelespuestos AS ln
				ON ln.id = e.nivelpuesto_id
				LEFT JOIN laboral_industrias AS li
				ON li.id = e.industria_id
				LEFT JOIN laboral_areas AS la
				ON la.id = e.area_id
				JOIN 
				(SELECT usuario_id, MAX(ffin) maxffin
				  FROM experiencias GROUP BY usuario_id
				) e2
				ON e.ffin = e2.maxffin AND e.usuario_id = e2.usuario_id;
			');
			
			if($campo == 'area_id'){
				foreach($experiencias as $experiencia){
					$override_array[$experiencia['la']['denominacion']] = (isset($override_array[$experiencia['la']['denominacion']])?$override_array[$experiencia['la']['denominacion']]+1:1);
				}				
			}elseif($campo == 'nivelpuesto_id'){
				foreach($experiencias as $experiencia){
					$override_array[$experiencia['ln']['denominacion']] = (isset($override_array[$experiencia['ln']['denominacion']])?$override_array[$experiencia['ln']['denominacion']]+1:1);
				}
			}elseif($campo == 'industria_id'){
				foreach($experiencias as $experiencia){
					$override_array[$experiencia['li']['denominacion']] = (isset($override_array[$experiencia['li']['denominacion']])?$override_array[$experiencia['li']['denominacion']]+1:1);
				}
			}
			
			foreach($override_array as $name => $count){
				if($name == ''){$name = 'Sin definir';}
				$return_array[] = array(array('name'=>$name,'count'=>$count));
			}

			echo json_encode($return_array);
			exit;
		}
		
		if($campo == 'edad'){
			$fields = array(
				"DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(DatosPersonales.fnacimiento, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(DatosPersonales.fnacimiento, '00-%m-%d')) AS age",
				'COUNT(*) AS count'
			);
			$field = 'age';
		}else{
			$fields = array('COUNT(*) AS count', $field);
		}
		
		$usuarios = $this->Usuario->find('all',array('fields'=>$fields, 'contain'=>$contain, 'group'=>$field, 'conditions'=>$conditions));
		
		foreach($usuarios as $i => $usuario){
		
			switch($campo){
				case 'sexo_id':
				$name_array = $this->Usuario->DatosPersonales->Sexo->getCombo();
				break;
				
				case 'estadocivil_id':
				$name_array = $this->Usuario->DatosPersonales->EstadoCivil->getCombo();
				break;
				
				case 'provincia_residencia_id':
				$name_array = $this->Usuario->DatosPersonales->Provincia->getCombo();
				break;
				
				case 'edad':
				if($usuario[0]['age'] == null){
					$override_array['No especificado'] = (isset($override_array['No especificado'])?$override_array['No especificado'] + $usuario[0]['count']:$usuario[0]['count']);
				}elseif($usuario[0]['age'] < 22){
					$override_array['18-22'] = (isset($override_array['18-22'])?$override_array['18-22'] + $usuario[0]['count']:$usuario[0]['count']);
				}elseif($usuario[0]['age'] < 27){
					$override_array['22-27'] = (isset($override_array['22-27'])?$override_array['22-27'] + $usuario[0]['count']:$usuario[0]['count']);
				}elseif($usuario[0]['age'] < 30){
					$override_array['27-30'] = (isset($override_array['27-30'])?$override_array['27-30'] + $usuario[0]['count']:$usuario[0]['count']);
				}elseif($usuario[0]['age'] < 40){
					$override_array['30-40'] = (isset($override_array['30-40'])?$override_array['30-40'] + $usuario[0]['count']:$usuario[0]['count']);
				}elseif($usuario[0]['age'] < 50){
					$override_array['40-50'] = (isset($override_array['40-50'])?$override_array['40-50'] + $usuario[0]['count']:$usuario[0]['count']);
				}elseif($usuario[0]['age'] >= 50){
					$override_array['>50'] = (isset($override_array['>50'])?$override_array['>50'] + $usuario[0]['count']:$usuario[0]['count']);
				}
				break;
			}
			
			if(isset($usuario[$model][$campo])){
				$field_buscado = $name_array[$usuario[$model][$campo]];
			}else{
				$field_buscado = 'No especificado';
			}
			
			$usuarios[$i][0]['name'] = $field_buscado;
		}
		
		if(isset($override_array)){	
			foreach($override_array as $name => $count){
				$return_array[] = array(array('name'=>$name,'count'=>$count));
			}
			echo json_encode($return_array);
		}else{
			echo json_encode($usuarios);
		}
		
		exit;
	}
}