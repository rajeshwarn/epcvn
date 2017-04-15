<?php
class Admin_SupportController extends My_Controller_Action {
	private $_model = '';
	private $_moduleName = '';
	private $_controllerName = '';
	private $_actionName = '';
	private $_actionMain = '';
	private $_params = array();
	private $_userId = '';
	private $_paginator = array('itemCountPerPage' => 6, 'pageRange' => 5);
	
	public function init(){
		$template_path = TEMPLATE_PATH . "/admin";
		$this->loadTemplate($template_path,'template.ini','template');
		
		$this->_model = new Admin_Model_Support();
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
		$this->_redirect("/{$this->_moduleName}/{$this->_controllerName}/show-all");
	}
	
	public function showAllAction() {
		$this->_helper->redirectSearchPage($this->_params, $this->_request->isPost());
		
		
		$paginator = $this->_helper->paginator->createPaginator($this->_model->countItems($this->_params),
				$this->_paginator['itemCountPerPage'],
				$this->_paginator['pageRange'],
				$this->_paginator['currentPage']);
		
		$options['count'] = $this->_paginator['itemCountPerPage'];
		$options['offset'] = ($this->_paginator['currentPage'] - 1) * $this->_paginator['itemCountPerPage'];
		
		$supports = $this->_model->getItems($this->_params, $options);
		
		$this->view->statusSelected = isset($this->_params['status']) ? $this->_params['status']:"";
		$this->view->keyword = isset($this->_params['keyword']) ? $this->_params['keyword']:"";
		$this->view->data = $supports;
		$this->view->paginator = $paginator;
	}
	
	public function addAction() {
		$data = $this->_request->getParams();
		$form = new Admin_Form_Support();
		
		if($this->_request->isPost()){
			if($form->isValid ( $data )) {
				$data = $form->getValues();
				
				$supportId = $this->_model->addItem($data);
			
				if($supportId) {
					if(isset($this->_params['btnSave'])) {
						$this->view->popupMessage = $this->_helper->popupMessage(MESS_ADD,$this->_actionMain);
					}elseif (isset($this->_params['btnSaveAdd'])) {
						$this->_redirect("/{$this->_moduleName}/{$this->_controllerName}/{$this->_actionName}");
					}
				}
				
			}
		}
		
		$this->view->form = $form;
		$this->view->headScript()->appendFile(TEMPLATE_URL.'/admin/js/ckeditor/ckeditor.js');
	}
	
	public function editAction() {
		$supportId = $this->_params ['id'];
		$form = new Admin_Form_Support();
		
		if($this->_request->isPost()){
			$data = $this->_request->getPost ();
			
			if($form->isValid ( $data )) {
				$data = $form->getValues();
				
				if($this->_model->updateItem($supportId,$data)) {
					if(isset($this->_params['btnSave'])) {
						$this->view->popupMessage = $this->_helper->popupMessage(MESS_UPDATE,$this->_actionMain);
					}elseif (isset($this->_params['btnSaveAdd'])) {
						$this->_redirect("/{$this->_moduleName}/{$this->_controllerName}/add");
					}	
				}
				$this->view->popupMessage = $this->_helper->popupMessage(MESS_UPDATE,$this->_actionMain);
			}
		}else {
			$data = $this->_model->getItemOne( $supportId );
		}
		
		
		$this->view->item = $data;
		$form->populate ( $data );
		$this->view->form = $form;
		$this->view->headScript()->appendFile(TEMPLATE_URL.'/admin/js/ckeditor/ckeditor.js');
	}
	
	function deleteAction(){
		$this->_helper->viewRenderer->setNoRender ();
		$id = $this->_params['id'];
		$supportModel = new Admin_Model_Support();
		$result = $supportModel->getItemOne($id);
		if($result != null){
			$supportModel->deleteItem($id);
		}
		$this->_redirect("/{$this->_moduleName}/{$this->_controllerName}/show-all");
	}
	
	function deleteAllAction()
	{
		$productModel = new Admin_Model_Support();
		if($productModel->getItem() != null){
			if($productModel->removeAllSupport()){
				$this->_redirect("/{$this->_moduleName}/{$this->_controllerName}/show-all");
			}
		}
		else
			$this->_redirect("/{$this->_moduleName}/{$this->_controllerName}/show-all");
	}
	
	function ajaxDeleteSupportAction() {
		$template_path = TEMPLATE_PATH . "/admin";
		$this->loadTemplate ( $template_path, 'template.ini', 'ajax' );
		$this->_helper->viewRenderer->setNoRender ();
	
		$productModel = new Admin_Model_Support ();
	
		$productId = $this->_params ['id'];
		//My_Common::dump($productId);
		$result = array (
				'result' => $this->_model->removeSupport ( $productId ),
				'value' => $productId
		);
	
		echo json_encode ( $result );
		die ();
	}
	
	public function trashAction() {
		$categoryModel = new Admin_Model_Category();
		$category = $categoryModel->getItemInSelectbox('', array('task' => 'filter'));
	
		$this->_helper->redirectSearchPage($this->_params, $this->_request->isPost());
	
		$options['task'] = 'by-category';
		$options['columns'] = array('p.id', 'p.titleVi', 'p.titleEn', 'p.aliasVi', 'p.aliasEn', 'p.image', 'p.status', 'p.weight');
	
		$paginator = $this->_helper->paginator->createPaginator($this->_model->countItems($this->_params, $options),
				$this->_paginator['itemCountPerPage'],
				$this->_paginator['pageRange'],
				$this->_paginator['currentPage']);
	
		$options['count'] = $this->_paginator['itemCountPerPage'];
		$options['offset'] = ($this->_paginator['currentPage'] - 1) * $this->_paginator['itemCountPerPage'];
	
		$products = $this->_model->getItems($this->_params, $options);
	
		$this->view->categorySelected = isset($this->_params['categoryId']) ? $this->_params['categoryId']:"";
		$this->view->statusSelected = isset($this->_params['status']) ? $this->_params['status']:"";
		$this->view->keyword = isset($this->_params['keyword']) ? $this->_params['keyword']:"";
		$this->view->category = $category;
		$this->view->product = $products;
		$this->view->paginator = $paginator;
	}
}