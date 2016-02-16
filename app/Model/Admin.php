<?php
class Admin extends AppModel
{
    var $name = 'Admin';
	
	function Login($data){
		$this->Behaviors->attach('Containable');
		$contain = array();
		$conditions = array('Admin.username'=>$data['Admin']['username'],'Admin.password'=>md5(strtolower($data['Admin']['password'])));
		return $this->find('first',array('conditions'=>$conditions,'contain'=>$contain));
	}
}