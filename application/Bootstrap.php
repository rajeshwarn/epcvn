<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initSession() {
        Zend_Session::start();
    }

    protected function _initLocale() {
    	$locale = new Zend_Locale('vi');
    	Zend_Registry::set('Zend_Locale', $locale);
    }
    
    protected function _initAutoload() {    	
        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new Zend_Controller_Plugin_ErrorHandler(array(
            'module' => 'error',
            'controller' => 'error',
            'action' => 'error'
        ))); 
		
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		
		Zend_Loader_Autoloader::getInstance()->registerNamespace('My_');
        
        $resourceLoader = new Zend_Loader_Autoloader_Resource(
				array('basePath' => APPLICATION_PATH, 'namespace' => '',
        		'resourceTypes' => array(
        				'Admin_blocks' => array(
        						'path' => 'modules/admin/blocks/',
        						'namespace' => 'Admin_Blocks_'),
        				'Default_blocks' => array(
        						'path' => 'modules/default/blocks/',
        						'namespace' => 'Default_Blocks_'),
        				 
        		))); 
        
        $modelLoader = new Zend_Application_Module_Autoloader(array(
            'namespace' => '',
            'basePath' => APPLICATION_PATH . '/modules/default'));
		
        return $modelLoader;
    }
	

    protected function _initRoute(){
    	$front = Zend_Controller_Front::getInstance();
    	$front -> setControllerDirectory(array(	"default" => APPLICATION_PATH."/modules/default/controllers",
    			"admin" => APPLICATION_PATH."/modules/admin/controllers"));
    	$error = new Zend_Controller_Plugin_ErrorHandler(array(	"module" => "default",
    			"controller" => "index",
    			"action" => "error"));
    	$front -> registerPlugin($error); 
    	$config = new Zend_Config_Ini(APPLICATION_PATH."/configs/routers.ini", "routers");
    	$router = new Zend_Controller_Router_Rewrite();
    	$router = $router -> addConfig($config, "routes");
    	$front -> setRouter($router);
    	return $front;
    }
    
    public function _initNavigationIni() {
    	
        $this->bootstrap('layout');
        $layout = $this->getResource('layout');
        $view = $layout->getView();
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/navigation.ini');
        
        $navigation = new Zend_Navigation($config->navigation);
        $view->navigation($navigation);
    }

    public function _initPlugins() {
        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new My_Plugin_LangSelector());
        
        /**
         * save last url
         */
        //$front->registerPlugin(new Application_Plugin_LastUrl());

        /**
         * Initializer
         */
        //$front->registerPlugin(new Application_Plugin_Initializer());
        //$front->registerPlugin(new Application_Plugin_Authentication());
    }

}