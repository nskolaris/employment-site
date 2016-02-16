<?php
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'avisos', 'action' => 'destacados'));
	
	Router::connect('/avisos/:nombre-:cod',array('controller'=>'avisos','action' => 'index'),array('cod' => '[ap](\d+)'));
	Router::connect('/avisos/:nombre-:cod/:nombre2-:cod2',array('controller'=>'avisos','action' => 'index'),array('cod' => '[ap](\d+)','cod2' => '[ap](\d+)'));
/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

	Router::connect('/control', array('controller' => 'usuarios', 'action' => 'login', 'control' => true));
	//Router::connect('/empresas', array('controller' => 'pages', 'action' => 'home', 'empresas' => true));
	
/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
