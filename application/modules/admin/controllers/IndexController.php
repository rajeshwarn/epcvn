<?php

class Admin_IndexController extends My_Controller_Action {
	private $_model = '';
	private $_moduleName = '';
	private $_controllerName = '';
	private $_actionName = '';
	private $_actionMain = '';
	private $_params = array();
	private $_userId = '';
	
    public function init() {
       	$template_path = TEMPLATE_PATH . "/admin";
		$this->loadTemplate($template_path,'template.ini','template');
		
		$this->_model = new Admin_Model_Product();
		$this->_moduleName = $this->_request->getModuleName();
		$this->_controllerName = $this->_request->getControllerName();
		$this->_actionName = $this->_request->getActionName();
		$this->_params = $this->_request->getParams();
		$this->_actionMain = '/' . $this->_moduleName . '/' . $this->_controllerName . '/index';
		$this->_paginator['currentPage'] = $this->_getParam('page',1);
		
		$this->view->params = $this->_params;
		$this->view->controllerName = $this->_controllerName;
		
		$auth = Zend_Auth::getInstance();
		$infoUser = $auth->getIdentity();
		$this->_userId = $infoUser['userId'];
		
		My_Auth_User::authenticate();
    }

    public function indexAction() {    	
        $productViews = $this->_model->getItems('', array('task'=>'admin-views', 'count'=>10));
        $productNew = $this->_model->getItems('', array('task'=>'admin-product-new', 'count'=>10));
        $productFeature = $this->_model->getItems('', array('task'=>'admin-product-feature', 'count'=>10));
        
        $this->view->productViews = $productViews;
        $this->view->productNew = $productNew;
        $this->view->productFeature = $productFeature;
    }
}