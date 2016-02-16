<?php
class UsuarioInterno extends AppModel
{
    var $name = 'UsuarioInterno';
	var $useTable = 'usuarios_internos';
	
	public $belongsTo = array(
		'Empresa' => array(
            'className' => 'Empresa',
			'foreignKey' => 'empresa_id'
        ),
		'Rol' => array(
            'className' => 'Rol',
			'foreignKey' => 'rol_id'
        ),
    );
	
	/* Validacion */
	
	public $validate = array(
        'email' => array(
			'email' => array(
				'rule'    => 'email',
				'message' => 'El E-mail ingresado es inválido'
			),
			'notEmpty' => array(
				'rule'    => 'notEmpty',
				'message' => 'El E-mail no puede estar vacio'
			),
			'notExists' => array(
				'rule'    => array('EmailNotExists'),
				'message' => 'El email ingresado ya esta siendo usado'
			),
			'Exists' => array(
				'rule'    => array('EmailExists'),
				'message' => 'El email ingresado no existe'
			)
		),
		'nombre' => array(
			'rule' => 'notEmpty',
			'message' => 'El Nombre Comercial no puede estar vacio'
		),
		'apellido' => array(
			'rule' => 'notEmpty',
			'message' => 'La razón social no puede estar vacía'
		),
		'username' => array(
			'rule' => 'notEmpty',
			'message' => 'El documento no puede estar vacio'
		),
        'password' => array(
			'notEmpty' => array(
				'rule'    => 'notEmpty',
				'message' => 'La contraseña no puede estar vacia'
			),
			'notValid' => array(
				'rule'    => array('PasswordValid'),
				'message' => 'Las contraseña ingresada es incorrecta'
			)
        ),
        'password_repeat' => array(
            'rule'    => array('RepeatPassword'),
            'message' => 'Las contraseñas no coinciden'
        ),
    );
	
	public function RepeatPassword(){
		return $this->data['UsuarioInterno']['password'] == $this->data['UsuarioInterno']['password_repeat'];
	}
	
	public function PasswordValid(){
		if(isset($this->data['UsuarioInterno']['login'])){
			return ($this->find('count',array(
				'conditions'=>array(
					'UsuarioInterno.email'=>$this->data['UsuarioInterno']['email'],
					'UsuarioInterno.password'=>md5($this->data['UsuarioInterno']['password'])
				)
			)) > 0);
		}else{
			return true;
		}
	}
	
	public function EmailNotExists(){
		if(!isset($this->data['UsuarioInterno']['login'])){
			return ($this->find('count',array('conditions'=>array('UsuarioInterno.email'=>$this->data['UsuarioInterno']['email']))) == 0);
		}else{
			return true;
		}
	}
	
	public function EmailExists(){
		if(isset($this->data['UsuarioInterno']['login'])){
			return ($this->find('count',array('conditions'=>array('UsuarioInterno.email'=>$this->data['UsuarioInterno']['email']))) > 0);
		}else{
			return true;
		}
	}
	
	/* Funciones */
	
	function beforeSave($options = array()){
		$this->data['UsuarioInterno']['password'] = md5(strtolower($this->data['UsuarioInterno']['password']));
		return true;
	}
	
	function Login($data){
		$this->Behaviors->attach('Containable');
		$contain = array('Empresa','Rol');
		$conditions = array('UsuarioInterno.username'=>$data['UsuarioInterno']['username'],'UsuarioInterno.password'=>md5(strtolower($data['UsuarioInterno']['password'])));
		return $this->find('first',array('conditions'=>$conditions,'contain'=>$contain));
	}
	
	function RecoverPassword($username){
		$response = array('status'=>false,'message'=>'Ocurrió un error');
		$this->Behaviors->attach('Containable');
		if($user = $this->find('first',array('conditions'=>array('UsuarioInterno.username'=>$username),'contain'=>array('Empresa')))){
			$this->id = $user['UsuarioInterno']['id'];
			$token = md5($user['UsuarioInterno']['id'].$user['UsuarioInterno']['username'].date('d-m-Y'));
			if($this->saveField('token',$token)){
				App::uses('CakeEmail', 'Network/Email');
			
				$url = Router::url(array('controller'=>'empresas','action'=>'cambiar_clave',$token), true );
			
				$Email = new CakeEmail();
				$Email->template('password');
				$Email->from(array('noreply@xperiencialaboral.com' => 'Xperiencia Laboral'));
				$Email->to($user['UsuarioInterno']['email']);
				$Email->subject('Recuperacion contraseña Xperiencia Laboral');
				$Email->viewVars(array('nombre' => $user['UsuarioInterno']['nombre'].' '.$user['UsuarioInterno']['apellido'], 'url'=>$url));
				$Email->emailFormat('html');
				if($Email->send()){
					$response['message'] = 'Un link para reestablecer tu contraseña ha sido enviado a tu email '.$user['UsuarioInterno']['email'];
					$response['status'] = true;
				}else{
					$response['message'] = 'Ocurrio un error al intentar enviar el mail';
				}
			}
		}else{
			$response['message'] = 'El email ingresado no corresponde a un usuario existente';
		}
		return $response;
	}
	
	function ChangePassword($data){
		if($data['new_password'] == $data['repeat_new_password']){
			return $this->saveField('password',$data['new_password']);
		}
		return false;
	}
}