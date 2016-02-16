<?php
App::uses('AppController', 'Controller');

class PagesController extends AppController {

	public $uses = array();

	public function display() {
		//$this->layout = 'empresas';
		
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));

		try {
			$this->render(implode('/', $path));
		} catch (MissingViewException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException();
		}
	}
	
	/* Sección Control */
	
	function control_home(){
		$this->set('avisos_count',$this->Aviso->find('count',array('conditions'=>array())));
		$this->set('provincias',$this->Aviso->Provincia->getCombo());
		$this->set('areas',$this->Aviso->LaboralArea->getCombo());
		$this->set('niveles',$this->Aviso->LaboralNivelPuesto->getCombo());
		
		$this->set('usuarios_count',$this->Usuario->find('count',array('conditions'=>array())));
		$this->set('empresas_count',$this->Empresa->find('count',array('conditions'=>array())));
	}
}