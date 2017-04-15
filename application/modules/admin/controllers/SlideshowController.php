<?php
class Admin_SlideshowController extends My_Controller_Action {
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
		
		$this->_model = new Admin_Model_Slideshow();
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
	
		$customerPage = $this->_model->getItemInfo($this->_params);
		
		$adapter = new Zend_Paginator_Adapter_DbSelect($customerPage);
		$paginator = new Zend_Paginator($adapter);
		$paginator->setItemCountPerPage(PER_PAGE);
		$paginator->setPageRange(PAGE_RANGE);
		$currentPage = $this->_request->getParam('page',1);
		$paginator->setCurrentPageNumber($currentPage);
	
		$this->view->statusSelected = isset($this->_params['status']) ? $this->_params['status']:"";
		$this->view->keyword = isset($this->_params['keyword']) ? $this->_params['keyword']:"";
		$this->view->data=$paginator;
	
	}
	public function addAction() {
		$data = $this->_request->getParams();
		$form = new Admin_Form_Slideshow();
	
		if($this->_request->isPost()){
			//$valid = new Admin_Form_Validators_SlideshowValid($data); && $valid->isValid()
			
			if($form->isValid ( $data )) {
				$data = $form->getValues();
				try {
					$upload = new My_File_Upload();
					$fileInfo = $upload->getFileInfo('image');
					$fileName = $fileInfo['image']['name'];
						
					if(!empty($fileName)){
						//options for upload images
						$options = array(
								'rename' => true,
								'override' => false,
						);
						$fileName = $upload->upload(UPLOAD_PATH . '/slideshows','image',$options);
					
					}
							
					$data['image'] = '/uploads/slideshows/'.$fileName;
					
					/* $fileUpload = new My_File_Upload();
					$data['image'] ='/uploads/slideshows/'. $fileUpload->upload('image', 'slideshows' , array('task' => 'rename')); */
					$slideshowId = $this->_model->addItem($data);
					if($slideshowId) {
						if(isset($this->_params['btnSave'])) {
							$this->view->popupMessage = $this->_helper->popupMessage(MESS_ADD,$this->_actionMain);
						}elseif (isset($this->_params['btnSaveAdd'])) {
							$this->_redirect("/{$this->_moduleName}/{$this->_controllerName}/{$this->_actionName}");
						}
					}
				}catch (Exception $e) {
					throw $e;
				}
			}
		}
	
		$this->view->form = $form;
		$this->view->headScript()->appendFile(TEMPLATE_URL.'/admin/js/timepicker/jquery-ui-timepicker-addon.js');
	}
	
	public function editAction() {
		$slideshowId = $this->_params ['id'];
		$form = new Admin_Form_Slideshow();
		
		if($this->_request->isPost())
		{
			$data = $this->_request->getPost ();
			//$valid = new Admin_Form_Validators_SlideshowValid($data); && $valid->isValid()
			if($form->isValid ( $data )) {
				$data = $form->getValues();
				
				$upload = new My_File_Upload();
				$fileInfo = $upload->getFileInfo('image');
				$fileName = $fileInfo['image']['name'];
				 
				if(!empty($fileName)){
					//options for upload images
					$options = array(
							'rename' => true,
							'override' => false,
					);
					$fileName = $upload->upload(UPLOAD_PATH . '/slideshows','image',$options);
					
					My_File_Upload::remove('', $this->_params ['imageOld']);
					
					$data['image'] = '/uploads/slideshows/'.$fileName;
		        }else{
		        	$data['image'] = '/uploads/slideshows/'.$this->_params ['imageOld'];
		        }	
				
				if($this->_model->updateItem($slideshowId,$data)) {
					if(isset($this->_params['btnSave'])) {
						$this->view->popupMessage = $this->_helper->popupMessage(MESS_UPDATE,$this->_actionMain);
					}elseif (isset($this->_params['btnSaveAdd'])) {
						$this->_redirect("/{$this->_moduleName}/{$this->_controllerName}/add");
					}
				}
				
				$data = $this->_model->getItemOne( $slideshowId );
				$this->view->popupMessage = $this->_helper->popupMessage(MESS_UPDATE,$this->_actionMain);
			}
		}else {
			$data = $this->_model->getItemOne( $slideshowId );
			
		}
		$result = str_split($data['image'],19);
		$data['image'] ='';
		foreach($result as $k => $val){
			if($k != 0)
				$data['image'] .= $val;
		}
		$this->view->item = $data;
		$form->populate ( $data );
		$this->view->form = $form;
	}
	
	function deleteAction(){
		$slideshowId = $this->_params['id'];
		$result = $this->_model->getItemOne($slideshowId);
		if($result != null){
			if($this->_model->deleteItem($slideshowId)){
				$this->_redirect("/{$this->_moduleName}/{$this->_controllerName}/show-all");
			}
		}
	}
	
	function deleteAllAction()
	{
		if($this->_model->getItem() != null){
			if($this->_model->deleteAllItem()){
				$this->_redirect("/{$this->_moduleName}/{$this->_controllerName}/show-all");
			}
		}
		else
			$this->_redirect("/{$this->_moduleName}/{$this->_controllerName}/show-all");
	}

}