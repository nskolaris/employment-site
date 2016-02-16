<?php
App::uses('AppController', 'Controller');

class CurriculumAvisosController extends AppController{

	var $uses = array('CurriculumAviso');
	public $components = array('Paginator','RequestHandler');
    
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
				}else{
					var_dump($response['errores']);
				}
			}
		}
		exit;
	}
	
	/* Sección Empresas */
	
	function empresa_index($id = null, $get_count = false)
	{
		if($id != null && $this->CurriculumAviso->Aviso->GetNoVencido($id)){
		
			$this->CurriculumAviso->Behaviors->attach('Containable');
		
			$conditions = array('CurriculumAviso.aviso_id'=>$id);
			
			$joins = array(
				array(
					'table' => 'usuarios_datospersonales',
					'alias' => 'DatosPersonales',
					'type' => 'left',
					'conditions' => array(
						'DatosPersonales.usuario_id = CurriculumAviso.usuario_id',
					)
				)
			);
			
			$joins_made = array(); //Sirve para ver si ya hice join de cierto modelo
			
			$contain = array(
				'Usuario'=>array(
					'DatosPersonales'=>array(
						'Provincia'=>array('Pais')
					),
					'Experiencia'=>array(
						'LaboralNivelPuesto'
					),
					'Estudio'=>array('EstudioInstitucion')
				),
				'CurriculumavisoNota'
			);
			
			$order = array();
			
			if(!empty($this->data)){
				$filter_url['controller'] = $this->request->params['controller'];
				$filter_url['action'] = $this->request->params['action'];
				$filter_url[] = $id;
				$filter_url['page'] = 1;
				$filter_url = $this->GenerateFilterUrl($this->data,$filter_url);
				return $this->redirect($filter_url);
			}else{
				foreach($this->params['named'] as $param_name => $value){
					if(!in_array($param_name, array('page','sort','direction','limit'))){
					
						if(strpos($param_name,'Estudio') !== false){
							if(!isset($joins_made['Estudio'])){
								$joins[] = array(
									'table' => 'estudios',
									'alias' => 'Estudio',
									'conditions' => array(
										'Estudio.usuario_id = CurriculumAviso.usuario_id',
									)
								);
								$joins_made['Estudio'] = 1;
							}
						}elseif(strpos($param_name,'Experiencia') !== false){
							if(!isset($joins_made['Experiencia'])){
								$joins[] = array(
									'table' => 'experiencias',
									'alias' => 'Experiencia',
									'conditions' => array(
										'Experiencia.usuario_id = CurriculumAviso.usuario_id',
									)
								);
								$joins_made['Experiencia'] = 1;
							}
						}elseif(strpos($param_name,'ConocimientoIdioma') !== false){
							$param_name_exploded = explode('.',$param_name);
							$param_name = 'ConocimientoIdioma_'.$param_name_exploded[1].'.'.$param_name_exploded[2];
							if(!isset($joins_made['ConocimientoIdioma_'.$param_name_exploded[1]])){
								$joins[] = array(
									'table' => 'conocimientos_idioma',
									'alias' => 'ConocimientoIdioma_'.$param_name_exploded[1],
									'conditions' => array(
										'ConocimientoIdioma_'.$param_name_exploded[1].'.usuario_id = CurriculumAviso.usuario_id',
									)
								);
								$joins_made['ConocimientoIdioma_'.$param_name_exploded[1]] = 1;
							}
						}elseif(strpos($param_name,'ConocimientoInformatica') !== false){
							$param_name_exploded = explode('.',$param_name);
							$param_name = 'ConocimientoInformatica_'.$param_name_exploded[1].'.'.$param_name_exploded[2];
							if(!isset($joins_made['ConocimientoInformatica_'.$param_name_exploded[1]])){
								$joins[] = array(
									'table' => 'conocimientos_informatica',
									'alias' => 'ConocimientoInformatica_'.$param_name_exploded[1],
									'conditions' => array(
										'ConocimientoInformatica_'.$param_name_exploded[1].'.usuario_id = CurriculumAviso.usuario_id',
									)
								);
								$joins_made['ConocimientoInformatica_'.$param_name_exploded[1]] = 1;
							}
						}elseif(strpos($param_name,'DatosPersonales') !== false){
							if(strpos($param_name,'edad_interval') !== false){
								$value_exploded = explode(',',$value);
								
								$min_edad = $this->CurriculumAviso->calcular_edad($value_exploded[0],true);
								$max_edad = $this->CurriculumAviso->calcular_edad($value_exploded[1],true);
								
								$conditions['DatosPersonales.fnacimiento >'] = $max_edad;
								$this->request->data['DatosPersonales.fnacimiento >'] = $max_edad;
								$conditions['DatosPersonales.fnacimiento <'] = $min_edad;
								$this->request->data['DatosPersonales.fnacimiento <'] = $min_edad;
								
								$param_name = null;
							}
						}elseif(strpos($param_name,'PreferenciasLaborales') !== false){
							if($value != 0){
								if(!isset($joins_made['PreferenciasLaborales'])){
									$joins[] = array(
										'table' => 'preferencias_laborales',
										'alias' => 'PreferenciasLaborales',
										'conditions' => array(
											'PreferenciasLaborales.usuario_id = CurriculumAviso.usuario_id',
										)
									);
									$joins_made['PreferenciasLaborales'] = 1;
								}
							}else{
								$param_name = null;
							}
						}
						
						if($param_name != null){
							$conditions[$param_name] = $value;
							$this->request->data[$param_name] = $value;
						}
						
					}elseif(in_array($param_name, array('sort','direction'))){
						$order[$param_name] = $value;
					}
				}
				$this->set('filtros',$this->request->data);
			}
			
			$order_txt = (isset($order['direction'])&&isset($order['sort'])?$order['sort'].' '.$order['direction']:null);
			$limit = 50;
			$page = (isset($this->params['named']['page'])?$this->params['named']['page']:1);
			$offset = ($page-1)*$limit;
			$count_postulantes = $this->CurriculumAviso->find('count',array('conditions'=>$conditions, 'joins'=>$joins, 'contain'=>$contain));
			$pages_array = array('current_page'=>$page,'pages'=> ceil($count_postulantes / $limit),'count'=>$count_postulantes);
			
			if($get_count){
				echo json_encode($pages_array);
				exit;
			}

			$postulantes = $this->CurriculumAviso->find('all',array(
				'conditions'=>$conditions,
				'joins'=>$joins,
				'contain'=>$contain,
				'order'=>$order_txt,
				'limit'=>$limit,
				'offset' => $offset
			));

			$this->set('postulantes', $postulantes);
			
			if($this->RequestHandler->isAjax()){
				$this->autoRender = false;
				$this->layout = false;
				$this->render('/Elements/cv-preview-structure');
			}else{
				$this->CurriculumAviso->Aviso->recursive = -1;
				$this->set('aviso',$this->CurriculumAviso->Aviso->find('first',array('conditions'=>array('Aviso.id'=>$id))));
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
				$this->set('conoc_idiomas',$this->Usuario->ConocimientoIdioma->ConocIdioma->getCombo());
				$this->set('conoc_nivel_idiomas',$this->Usuario->ConocimientoIdioma->ConocNivelOral->getCombo());
				$this->set('conoc_nivel',$this->Usuario->ConocimientoInformatica->ConocNivel->getCombo());
				$this->set('conoc_software',$this->Usuario->ConocimientoInformatica->ConocSoftware->getCombo());
				$this->set('pages',$pages_array);
			}
		}else{
			$this->redirect(array('controller'=>'avisos','action'=>'index'));
		}
	}
	
	function GenerateFilterUrl($data,$filter_url,$string = '')
	{
		foreach($data as $name => $value){
			if($name != 'Extra'){
				if(is_array($value)){
					$filter_url = $this->GenerateFilterUrl($value,$filter_url,$name);
				}else{
					if($value){
						$filter_url[($string!=''?$string.'.':'').$name] = urlencode($value);
					}
				}
			}
		}
		return $filter_url;
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
	
	function empresa_marcar_leido($id, $state){
		if($id != null){
			$this->CurriculumAviso->id = $id;
			if($this->CurriculumAviso->saveField('nuevo',$state)){
				echo 'ok';
			}else{
				echo 'error';
			}
		}
		exit;
	}
	
	function empresa_agregar_nota(){
		$data['CurriculumavisoNota'] = $this->data;
		$data['CurriculumavisoNota']['usuario_id'] = $this->SessionUsuarioInterno['UsuarioInterno']['id'];
		if($this->CurriculumAviso->CurriculumavisoNota->save($data)){
			echo 'ok';
		}else{
			echo 'error';
		}
		exit;
	}
	
	function empresa_borrar_nota($id=null){
		if($id != null){
			if($this->CurriculumAviso->CurriculumavisoNota->delete($id)){
				echo 'ok';
			}else{
				echo 'error';
			}
		}else{
			echo 'error';
		}
		exit;
	}
	
	function empresa_ver_notas($id = null){
		if($id != null){
			$this->CurriculumAviso->CurriculumavisoNota->Behaviors->attach('Containable');
			$notas = $this->CurriculumAviso->CurriculumavisoNota->find('all',array('conditions'=>array('CurriculumavisoNota.curriculumaviso_id'=>$id),'contain'=>array('UsuarioInterno'),'order'=>'CurriculumavisoNota.created DESC'));
			if($notas){
				echo json_encode($notas);
			}else{
				echo 'error';
			}
		}
		exit;
	}
}
?>