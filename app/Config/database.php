<?php
class DATABASE_CONFIG {

	public $default = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'root',
		'password' => 'milagro06',
		'database' => 'xperiencialaboral',
		'prefix' => '',
		'encoding' => 'utf8',
	);

	/*public $default = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'xlaboral_admin',
		'password' => 'l4nz4ll4m4s',
		'database' => 'xlaboral_main',
		'prefix' => '',
		'encoding' => 'utf8',
	);

	public function __construct()
	{
		if (Configure::read('Enclave.dev')) {
			$this->default = $this->development;
		} 
	}*/
}
?>
