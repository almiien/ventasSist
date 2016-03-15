<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initAutoloader()
	{
		 new Zend_Application_Module_Autoloader(array(
			 'namespace' => 'Ventas',
			 'basePath'  => APPLICATION_PATH . '/modules/ventas',
		 ));
	}
}

