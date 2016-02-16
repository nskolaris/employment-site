<?php
class Empresa extends AppModel
{
	var $name = 'Empresa';
    var $useTable = 'empresas';
	
	var $belongsTo = array(
		'Provincia' => array(
			'className' => 'Provincia',
			'foreignKey' => 'provincia_id'
		),
		'LaboralIndustria' => array(
			'className' => 'LaboralIndustria',
			'foreignKey' => 'industria_id'
		)
	);
	
	public $hasMany = array(
        'UsuarioInterno' => array(
            'className' => 'UsuarioInterno',
            'foreignKey' => 'empresa_id',
            'order' => 'UsuarioInterno.id ASC'
        ),
		'EmpresaProducto' => array(
            'className' => 'EmpresaProducto',
            'foreignKey' => 'empresa_id',
            'order' => 'EmpresaProducto.id ASC'
        )
    );
	
	/* Validacion */
	
	public $validate = array(
		'nombre_comercial' => array(
			'rule' => 'notEmpty',
			'message' => 'El Nombre Comercial no puede estar vacio'
		),
		'razon_social' => array(
			'rule' => 'notEmpty',
			'message' => 'La Razón social no puede estar vacia'
		),
		'industria_id' => array(
			'rule' => 'notEmpty',
			'message' => 'Seleccione un ramo o actividad'
		),
		'calle' => array(
			'rule' => 'notEmpty',
			'message' => 'La Calle no puede estar vacia'
		),
		'altura' => array(
			'rule' => 'notEmpty',
			'message' => 'Este campo no puede estar vacio'
		),
		'codigo_postal' => array(
			'rule' => 'notEmpty',
			'message' => 'El código postal no puede estar vacio'
		),
		'provincia_id' => array(
			'rule' => 'notEmpty',
			'message' => 'Seleccione un estado'
		),
		'rfc' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'El RFC no puede estar vacio'
			),
			'valido' => array(
				'rule'    => array('RfcValido'),
				'message' => 'El RFC ingresado tiene un formato inválido'
			),
			'notExists' => array(
				'rule'    => array('RfcNotExists'),
				'message' => 'El RFC ingresado ya esta siendo usado'
			),
		)
    );
	
	public function RfcValido(){
		$valor = $this->data['Empresa']['rfc'];
		$valor = str_replace("-", "", $valor);
        $cuartoValor = substr($valor, 3, 1);
        if (ctype_digit($cuartoValor) && strlen($valor) == 12) {
            $letras = substr($valor, 0, 3);
            $numeros = substr($valor, 3, 6);
            $homoclave = substr($valor, 9, 3);
            if(ctype_alpha($letras) && ctype_digit($numeros) && ctype_alnum($homoclave)){
                return true;
            }
        }elseif(ctype_alpha($cuartoValor) && strlen($valor) == 13) {
            $letras = substr($valor, 0, 4);
            $numeros = substr($valor, 4, 6);
            $homoclave = substr($valor, 10, 3);
            if(ctype_alpha($letras) && ctype_digit($numeros) && ctype_alnum($homoclave)){
                return true;
            }
        }else{
            return false;
        } 
	}
	
	public function RfcNotExists(){
		return ($this->find('count',array('conditions'=>array('Empresa.rfc'=>$this->data['Empresa']['rfc']))) == 0);
	}
	
	/* Funciones */
	
	function guardar($data){
		$response = array('status'=>false,'message'=>'No se pudo guardar la empresa','error'=>array());
		
		$this->set(array('Empresa'=>$data));
		if(!$this->validates()){
			$response['error'] = $this->validationErrors;
		}

		if(!isset($data['modificar'])){
			$this->UsuarioInterno->set(array('UsuarioInterno'=>$data));
			if(!$this->UsuarioInterno->validates()){
				$response['error'] = $response['error'] + $this->UsuarioInterno->validationErrors;
			}
		}
		
		if(!empty($response['error'])){return $response;}
		
		if($this->save(array('Empresa'=>$data))){
		
			if(!isset($data['modificar'])){
				$data = array('UsuarioInterno'=>$data);
				$data['UsuarioInterno']['empresa_id'] = $this->id;
				$data['UsuarioInterno']['rol_id'] = 1;
				
				if($this->UsuarioInterno->save($data)){
					$response['status'] = true;
					$response['message'] = 'La empresa se guardo con exito';
				}
			}else{
				$response['status'] = true;
				$response['message'] = 'La empresa se guardo con exito';
			}
		}
		
		return $response;
	}
}
?>