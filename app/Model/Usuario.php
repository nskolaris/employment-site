<?php
class Usuario extends AppModel
{
    var $name = 'Usuario';
	
	public $hasOne = array(
        'DatosPersonales' => array(
            'className' => 'DatosPersonales',
			'foreignKey' => 'usuario_id'
        ),
		'PreferenciaLaboral' => array(
            'className' => 'PreferenciaLaboral',
			'foreignKey' => 'usuario_id'
        ),
		'Presentacion' => array(
            'className' => 'Presentacion',
			'foreignKey' => 'usuario_id'
        )
    );
	
	public $hasMany = array(
        'Referencia' => array(
            'className' => 'Referencia',
            'foreignKey' => 'usuario_id',
            'order' => 'Referencia.id ASC'
        ),
		'ConocimientoExtra' => array(
            'className' => 'ConocimientoExtra',
            'foreignKey' => 'usuario_id',
            'order' => 'ConocimientoExtra.id ASC'
        ),
		'ConocimientoInformatica' => array(
            'className' => 'ConocimientoInformatica',
            'foreignKey' => 'usuario_id',
            'order' => 'ConocimientoInformatica.id ASC'
        ),
		'ConocimientoIdioma' => array(
            'className' => 'ConocimientoIdioma',
            'foreignKey' => 'usuario_id',
            'order' => 'ConocimientoIdioma.id ASC'
        ),
		'Estudio' => array(
            'className' => 'Estudio',
            'foreignKey' => 'usuario_id',
            'order' => 'Estudio.ffin DESC'
        ),
		'Experiencia' => array(
            'className' => 'Experiencia',
            'foreignKey' => 'usuario_id',
            'order' => 'Experiencia.ffin DESC'
        ),
		'CurriculumAviso' => array(
			'className' => 'CurriculumAviso',
			'foreignKey' => 'usuario_id',
			'dependent' => false,
		)
    );
	
	/* Validación */
	
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
		return $this->data['Usuario']['password'] == $this->data['Usuario']['password_repeat'];
	}
	
	public function PasswordValid(){
		if(isset($this->data['Usuario']['login'])){
			return ($this->find('count',array(
				'conditions'=>array(
					'Usuario.email'=>$this->data['Usuario']['email'],
					'Usuario.password'=>md5($this->data['Usuario']['password'])
				)
			)) > 0);
		}else{
			return true;
		}
	}
	
	public function EmailNotExists(){
		if(!isset($this->data['Usuario']['login'])){
			return ($this->find('count',array('conditions'=>array('Usuario.email'=>$this->data['Usuario']['email']))) == 0);
		}else{
			return true;
		}
	}
	
	public function EmailExists(){
		if(isset($this->data['Usuario']['login'])){
			return ($this->find('count',array('conditions'=>array('Usuario.email'=>$this->data['Usuario']['email']))) > 0);
		}else{
			return true;
		}
	}
	
	/* Funciones */
	
	function beforeSave($options = array()){
		$this->data['Usuario']['password'] = md5(strtolower($this->data['Usuario']['password']));
		return true;
	}
	
	function Login($data){
		$this->Behaviors->attach('Containable');
		$contain = array('DatosPersonales');
		$conditions = array('Usuario.email'=>$data['Usuario']['email'],'Usuario.password'=>md5(strtolower($data['Usuario']['password'])));
		return $this->find('first',array('conditions'=>$conditions,'contain'=>$contain));
	}
	
	function ChangePassword($data){
		if($data['new_password'] == $data['repeat_new_password']){
			return $this->saveField('password',$data['new_password']);
		}
		return false;
	}
	
	function RecoverPassword($email){
		$response = array('status'=>false,'message'=>'Ocurrió un error');
		$this->Behaviors->attach('Containable');
		if($user = $this->find('first',array('conditions'=>array('Usuario.email'=>$email),'contain'=>array('DatosPersonales')))){
			$this->id = $user['Usuario']['id'];
			$token = md5($user['Usuario']['id'].$user['Usuario']['email'].date('d-m-Y'));
			if($this->saveField('token',$token)){
			
				App::uses('CakeEmail', 'Network/Email');
			
				$url = Router::url(array('controller'=>'usuarios','action'=>'cambiar_clave',$token), true );
			
				$Email = new CakeEmail();
				$Email->template('password');
				$Email->from(array('noreply@xperiencialaboral.com' => 'Xperiencia Laboral'));
				$Email->to($email);
				$Email->subject('Recuperacion contraseña Xperiencia Laboral');
				$Email->viewVars(array('nombre' => $user['DatosPersonales']['nombre'].' '.$user['DatosPersonales']['apellido'], 'url'=>$url));
				$Email->emailFormat('html');
				$Email->send();
				
				$response['message'] = 'Un link para reestablecer tu contraseña ha sido enviado a tu email '.$email;
				$response['status'] = true;
			}
		}else{
			$response['message'] = 'El email ingresado no corresponde a un usuario existente';
		}
		return $response;
	}
}