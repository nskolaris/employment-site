<?php
class DatosPersonales extends AppModel
{
    var $name = 'DatosPersonales';
	var $useTable = 'usuarios_datospersonales';
	
	public $belongsTo = array(
        'Usuario' => array(
            'className' => 'Usuario',
            'foreignKey' => 'usuario_id'
        ),
		'Pais' =>
		array('className'    => 'Pais',
			'foreignKey'   => 'pais_nacionalidad_id'
		),
		'Provincia' =>
		array('className'    => 'Provincia',
			'foreignKey'   => 'provincia_residencia_id'
		),
		'EstadoCivil' =>
		array('className'    => 'EstadoCivil',
			'foreignKey'   => 'estadocivil_id'
		),
		'Sexo' =>
		array('className'    => 'Sexo',
			'foreignKey'   => 'sexo_id'
		),
		'TipoDocumento' =>
		array('className'    => 'TipoDocumento',
			'foreignKey'   => 'tipodocumento_id'
		)
    );
	
	public $validate = array(
		'nombre' => array(
			'rule' => 'notEmpty',
			'message' => 'El nombre no puede estar vacio'
		),
		'apellido' => array(
			'rule' => 'notEmpty',
			'message' => 'El apellido no puede estar vacio'
		),
		/*'nrodocumento' => array(
			'rule' => 'notEmpty',
			'message' => 'El documento no puede estar vacio'
		),*/
		'fnacimiento' => array(
			'rule' => 'notEmpty',
			'message' => 'La fecha de nacimiento no puede estar vacio'
		)
    );
	
	function afterFind($results, $primary = false){
		foreach ($results as $key => $val) {
			if(isset($val['DatosPersonales']['fnacimiento'])){
				$birthDate = $val['DatosPersonales']['fnacimiento'];
				$birthDate = explode("-", $birthDate);
				$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
				? ((date("Y") - $birthDate[0]) - 1)
				: (date("Y") - $birthDate[0]));
				$results[$key]['DatosPersonales']['fnacimiento-dia'] = intval($birthDate[2]);
				$results[$key]['DatosPersonales']['fnacimiento-mes'] = intval($birthDate[1]);
				$results[$key]['DatosPersonales']['fnacimiento-ano'] = $birthDate[0];
				$results[$key]['DatosPersonales']['edad'] = $age;
			}
			if(isset($val['DatosPersonales']['telefono_hogar'])){
				$num_separado = explode(' ',$val['DatosPersonales']['telefono_hogar']);
				if(isset($num_separado[1])){
					$results[$key]['DatosPersonales']['telefono_hogar-cod'] = $num_separado[0];
					$results[$key]['DatosPersonales']['telefono_hogar-num'] = $num_separado[1];
				}else{
					$results[$key]['DatosPersonales']['telefono_hogar-num'] = $num_separado[0];
				}
			}
			if(isset($val['DatosPersonales']['telefono_celular'])){
				$num_separado = explode(' ',$val['DatosPersonales']['telefono_celular']);
				if(isset($num_separado[1])){
					$results[$key]['DatosPersonales']['telefono_celular-cod'] = $num_separado[0];
					$results[$key]['DatosPersonales']['telefono_celular-num'] = $num_separado[1];
				}else{
					$results[$key]['DatosPersonales']['telefono_celular-num'] = $num_separado[0];
				}
			}
		}
		return $results;
	}
	
	function agregar($data){
		$response = array('status'=>false,'message'=>'No se pudieron guardar los datos','errores'=>null);
		if($exists = $this->find('first',array('conditions'=>array('DatosPersonales.usuario_id'=>$data['usuario_id'])))){
			$this->id = $exists['DatosPersonales']['id'];
		}
		if(!empty($data['telefono_hogar-cod']) && !empty($data['telefono_hogar-num'])){$data['telefono_hogar'] = $data['telefono_hogar-cod'].' '.$data['telefono_hogar-num'];}
		if(!empty($data['telefono_celular-cod']) && !empty($data['telefono_celular-num'])){$data['telefono_celular'] = $data['telefono_celular-cod'].' '.$data['telefono_celular-num'];}
		if(!empty($data['fnacimiento-dia']) && !empty($data['fnacimiento-mes']) && !empty($data['fnacimiento-ano'])){
			$data['fnacimiento'] = $data['fnacimiento-ano'].'-'.$data['fnacimiento-mes'].'-'.$data['fnacimiento-dia'];
		}
		if($this->save(array('DatosPersonales'=>$data))){
			if(!$exists){
				$this->Usuario->id = $data['usuario_id'];
				$this->Usuario->saveField('datos_minimos',1);
			}
			$response['status'] = true;
			$response['message'] = 'Los datos se guardaron con exito';
		}else{
			$response['errores'] = $this->invalidFields();
		}
		return $response;
	}
}