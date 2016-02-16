<?php
App::uses('Controller', 'Controller');

class AppController extends Controller {

	public $uses = array('Empresa','Usuario','Aviso','Admin','UsuarioInterno','Slide');
	public $helpers = array('PhpThumb');
	public $theme = 'XperienciaLaboral';
	
	function beforeFilter(){
		parent::beforeFilter();
		
		if(isset($this->params['prefix']) && $this->params['prefix'] == 'control'){
			if($this->CheckAdmin()){
				$this->layout = 'control';
			}
		}elseif(isset($this->params['prefix']) && $this->params['prefix'] == 'empresa'){
			if($this->CheckEmpresa()){
				$this->layout = 'empresas_back';
				$this->set('empresa_producto',$this->Empresa->EmpresaProducto->GetByEmpresa($this->SessionUsuarioInterno['Empresa']['id']));
			}
		}else{
			$this->CheckLogin();
		}
		
		$this->set('slides',$this->Slide->find('all',array('conditions'=>array('Slide.borrador'=>0))));
	}
	
	function CheckLogin($redirect = false){
		$user = $this->Session->read('Usuario');
		if(!empty($user)){
			$this->set('user',$user);
			$this->SessionUsuario = $user;
			return true;
		}else{
			if($redirect){
				$this->redirect('/');
			}
			return false;
		}
	}
	
	function logout(){
		$this->Session->write('Usuario',null);
		$this->redirect('/');
	}
	
	function CheckEmpresa()
	{
		$user = $this->Session->read('UsuarioInterno');
		if(!empty($user)){
			$this->set('user',$user);
			$this->SessionUsuarioInterno = $user;
			return true;
		}else{
			if($this->params->params['action'] == 'empresas_login' || $this->params->params['action'] == 'empresas_logout'){
				return true;
			}else{
				$this->redirect('/empresas');
				return false;
			}
		}
	}
	
	function empresa_logout(){
		$this->Session->write('UsuarioInterno',null);
		$this->redirect('/empresas');
	}
	
	function CheckAdmin()
	{
		$admin = $this->Session->read('Admin');
		
		if(!empty($admin)){
			$this->set('admin',$admin);
			$this->SessionAdmin = $admin;
			return true;
		}else{
			if($this->params->params['action'] == 'control_login'){
				return true;
			}else{
				$this->redirect('/control/usuarios/login');
				return false;
			}
		}
	}
	
	function control_logout(){
		$this->Session->write('Admin',null);
		$this->redirect('/control');
	}
	
	function base64_to_jpeg($base64_string, $output_file) {
		$ifp = fopen($output_file, "wb"); 
		$data = explode(',', $base64_string);
		fwrite($ifp, base64_decode($data[1]));
		fclose($ifp);
		return $output_file; 
	}
	
	function save_image(){
		if(!empty($this->data)){
			if(isset($this->data['origin']) && $this->data['origin'] == 'empresas'){
				$this->CheckEmpresa();
				$path = 'empresas/'.$this->SessionUsuarioInterno['Empresa']['id'];
			}else{
				$this->CheckLogin();
				$path = ''.$this->SessionUsuario['Usuario']['id'];
			}
			if($file = $this->base64_to_jpeg($this->data['imgdata'],'img/profile_pics/'.$path.'.jpg')){
				echo $file;
			}else{
				echo 'error';
			}
		}else{
			echo 'error';
		}
		exit;
	}
}