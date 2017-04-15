<?php
class Admin_ConfigController extends My_Controller_Action {
	private $_model = "";
	private $_moduleName = "";
	private $_controllerName = "";
	private $_actionName = "";
	private $_actionMain = "";
	private $_params = array();
	private $_userId = "";
	
	public function init(){
		$template_path = TEMPLATE_PATH . "/admin";
		$this->loadTemplate($template_path,'template.ini','template');
		
		$this->_model = new Admin_Model_Config();
		$this->_moduleName = $this->_request->getModuleName();
		$this->_controllerName = $this->_request->getControllerName();
		$this->_actionName = $this->_request->getActionName();
		$this->_params = $this->_request->getParams();
		$this->_actionMain = '/' . $this->_moduleName . '/' . $this->_controllerName . '/index';
		
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
	
		$configPage = $this->_model->getItemInfo($this->_params);
		
		$adapter = new Zend_Paginator_Adapter_DbSelect($configPage);
		$paginator = new Zend_Paginator($adapter);
		$paginator->setItemCountPerPage(PER_PAGE);
		$paginator->setPageRange(PAGE_RANGE);
		$currentPage = $this->_request->getParam('page',1);
		$paginator->setCurrentPageNumber($currentPage);
		
		$this->view->keyword = isset($this->_params['keyword']) ? $this->_params['keyword']:"";
		$this->view->data=$paginator;
	
	}
	
	public function editAction() {
		$configId = $this->_params ['id'];
		$form = new Admin_Form_Config();

		if($this->_request->isPost())
		{
			$data = $this->_request->getPost ();
			//$valid = new Admin_Form_Validators_ConfigValid($data); && $valid->isValid()
			if($form->isValid ( $data )) {
				$data = $form->getValues();				
				$pre = $this->_params['pre'];
				
				if($pre == '1'){
					$data['value'] = 'http://'.$data['value'];
				}
				if($pre == '2'){
					$data['value'] = 'https://'.$data['value'];
				}
				
				if($this->_model->updateItem($configId,$data)) {
					if(isset($this->_params['btnSave'])) {
						$this->view->popupMessage = $this->_helper->popupMessage(MESS_UPDATE,$this->_actionMain);
					}elseif (isset($this->_params['btnSaveAdd'])) {
						$this->_redirect("/{$this->_moduleName}/{$this->_controllerName}/add");
					}
				}
				
				$data = $this->_model->getItemOne( $configId );
				$this->view->popupMessage = $this->_helper->popupMessage(MESS_UPDATE,$this->_actionMain);
			}
		}else {
			$data = $this->_model->getItemOne( $configId );
			
		}
		$this->view->item = $data;
		$form->populate ( $data );
		$this->view->form = $form;
		//$this->view->headScript()->appendFile(TEMPLATE_URL.'/admin/js/ckeditor/ckeditor.js');
	}

}