<?php

class Default_IndexController extends My_Controller_Action {
	private $_model = '';
	private $_moduleName = '';
	private $_controllerName = '';
	private $_actionName = '';
	private $_actionMain = '';
	private $_params = array ();
	private $_userId = '';
	private $_paginator = array('itemCountPerPage' => 6, 'pageRange' => 5);
	
    public function init() {
        $template_path = TEMPLATE_PATH . "/public";
        $this->loadTemplate($template_path, 'template.ini', 'template');
        
        $this->_model = new Default_Model_Products();
        $this->_moduleName = $this->_request->getModuleName ();
        $this->_controllerName = $this->_request->getControllerName ();
        $this->_actionName = $this->_request->getActionName ();
        $this->_params = $this->_request->getParams ();
        $this->_actionMain = '/' . $this->_moduleName . '/' . $this->_controllerName . '/index';
        $this->_paginator['currentPage'] = $this->_getParam('page',1);
                
        $this->view->params = $this->_params;
        $this->view->controllerName = $this->_controllerName;
    }

    public function indexAction() {   
    	$ssLang = new Zend_Session_Namespace('ssLang');
    	
    	$options['task'] = 'by-product-new';
    	 
    	$paginator = $this->_helper->paginator->createPaginator($this->_model->countItem($this->_params, $options),
    			$this->_paginator['itemCountPerPage'],
    			$this->_paginator['pageRange'],
    			$this->_paginator['currentPage']);
    	
    	 
    	$options['count'] = $this->_paginator['itemCountPerPage'];
    	$options['offset'] = ($this->_paginator['currentPage'] - 1) * $this->_paginator['itemCountPerPage'];
    	
    	$products = $this->_model->getItems($this->_params, $options);
    	
    	$this->view->products = $products;
    }
    
    public function contactAction() {
    	$configs = Zend_Registry::get('config');
		$pageModel = new Default_Model_Page();
    	$page = $pageModel->getItemOne('contact');
    	
    	$this->view->configs = $configs;
    	$this->view->page = $page;
    }
    
    public function searchAction(){
    	$ssSearch = new Zend_Session_Namespace('ssSearch');
    	if($this->_params['keyword'] != null){
    		$ssSearch->key = $this->_params['keyword'];
    	}
    	
    	
    	$articleModel = new Default_Model_Articles();
    	
    	$paginator = $this->_helper->paginator->createPaginator($this->_model->countItem($ssSearch->key, array('task' => 'by-search')),
    			$this->_paginator['itemCountPerPage'],
    			$this->_paginator['pageRange'],
    			$this->_paginator['currentPage']);
    	
    	$options['count'] = $this->_paginator['itemCountPerPage'];
    	$options['offset'] = ($this->_paginator['currentPage'] - 1) * $this->_paginator['itemCountPerPage'];
    	
    	$products = $this->_model->search($ssSearch->key, $options); 
    	
    	$this->view->products = $products;
    	$this->view->data=$paginator;
    }
	public function errorAction()
	{
		$this -> _redirect('/');
	}
}