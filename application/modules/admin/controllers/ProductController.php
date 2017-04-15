<?php
class Admin_ProductController extends My_Controller_Action {
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
		$this->_userID = $infoUser['userId'];
		
		My_Auth_User::authenticate();
		
	}
	
	public function indexAction() {
		$this->_redirect("/{$this->_moduleName}/{$this->_controllerName}/show-all");
	}
	
	public function showAllAction() {
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
	
	public function addAction() {
		$data = $this->_request->getParams();
		$form = new Admin_Form_Product();
		
		$categoryModel = new Admin_Model_Category ();
		$categorys = $categoryModel->getFetchPairs ( array ('parentId' => 0), array ('task' => 'by-parent') );
		
		if($this->_request->isPost()){
			
			if($form->isValid ( $data )) {
				$data = $form->getValues();
				$data ['categoryId'] = end($this->_params ['categoryId']);
				$data ['categorys'] = implode(',', $this->_params ['categoryId']);
				$data ['createdBy'] = $this->_userId;
				
				$upload = new My_File_Upload();
				$fileInfo = $upload->getFileInfo('image');
				$fileName = $fileInfo['image']['name'];
				 
				if(!empty($fileName)){
					//options for upload images
					$options = array(
							'rename' => true,
							'override' => false,
					);
					$fileName = $upload->upload(UPLOAD_PATH . '/products','image',$options);
				
					$img = new My_File_Image();
					//options for thumb images
					$options = array (
							'upload-dir' => UPLOAD_PATH . '/products' ,
							'thumbs-dir' => UPLOAD_PATH . '/products'. '/thumbs',
							'thumbs' => array (
									array (
											'width' => PRODUCT_WIDTH_THUMBS,
											'height' => PRODUCT_HEIGHT_THUMBS,
											'type' => 'absolute',
											'watermark' => false
									),
									array (
											'width' => PRODUCT_WIDTH_SMALL,
											'height' => PRODUCT_HEIGHT_SMALL,
											'type' => '',
											'watermark' => true
									) ) );
					
					$img->resizeImage($fileName, $options);
				}
				 
				$data['image'] = $fileName;
				
				$productId = $this->_model->addItem($data);
			
				if($productId) {
					if(isset($this->_params['btnSave'])) {
						$this->view->popupMessage = $this->_helper->popupMessage(MESS_ADD,$this->_actionMain);
					}elseif (isset($this->_params['btnSaveAdd'])) {
						$this->_redirect("/{$this->_moduleName}/{$this->_controllerName}/{$this->_actionName}");
					}
				}
				
			}
		}
		
		$this->view->form = $form;
		$this->view->category = $categorys;
		$this->view->headScript()->appendFile(TEMPLATE_URL.'/admin/js/ckeditor/ckeditor.js');
	}
	
	public function editAction() {
		$productId = $this->_params ['id'];
		$form = new Admin_Form_Product();
		$categoryModel = new Admin_Model_Category ();
		//$categorys = $categoryModel->getFetchPairs ( array ('parentId' => 0), array ('task' => 'by-parent') );
		
		if($this->_request->isPost())
		{
			$data = $this->_request->getPost ();
			
			if($form->isValid ( $data )) {
				$data = $form->getValues();
				$data ['categoryId'] = end($this->_params ['categoryId']);
				$data ['categorys'] = implode(',', $this->_params ['categoryId']);
				$data ['modified'] = date ( DATETIME_FORMAT_DB, time () );
				$data ['modifiedBy'] = $this->_userId;
				
					$upload = new My_File_Upload();
			        $fileInfo = $upload->getFileInfo('image');
			        $fileName = $fileInfo['image']['name'];
			        
			        if(!empty($fileName)){
			        	//options for upload images
			        	$options = array(
			        			'rename' => true,
			        			'override' => false,
			        	);
			        	$fileName = $upload->upload(UPLOAD_PATH . '/products','image',$options);
			        	
			        	$img = new My_File_Image();
			        	//options for thumb images
			        	$options = array (
			        			'upload-dir' => UPLOAD_PATH . '/products' ,
			        			'thumbs-dir' => UPLOAD_PATH . '/products'. '/thumbs',
			        			'thumbs' => array (
			        					array (
			        							'width' => PRODUCT_WIDTH_THUMBS,
			        							'height' => PRODUCT_HEIGHT_THUMBS,
			        							'type' => 'absolute',
			        							'watermark' => false
			        					),
			        					array (
			        							'width' => PRODUCT_WIDTH_SMALL,
			        							'height' => PRODUCT_HEIGHT_SMALL,
			        							'type' => '',
			        							'watermark' => true
			        					) ) );
			        	$img->resizeImage($fileName, $options);
			        	
			        	My_File_Upload::remove(UPLOAD_PATH . '/products', $this->_params ['imageOld']);
			        	My_File_Upload::remove(UPLOAD_PATH . '/products/' . PRODUCT_WIDTH_THUMBS . 'x'. PRODUCT_HEIGHT_THUMBS, $this->_params ['imageOld']);
			        	My_File_Upload::remove(UPLOAD_PATH . '/products/' . PRODUCT_WIDTH_SMALL . 'x' . PRODUCT_HEIGHT_SMALL, $this->_params ['imageOld']);
			        	
			        	$data['image'] = $fileName;
			        }else{
			        	$data['image'] = $this->_params ['imageOld'];
			        }						        
					
				if($this->_model->updateItem($productId,$data)) {
					if(isset($this->_params['btnSave'])) {
						$this->view->popupMessage = $this->_helper->popupMessage(MESS_UPDATE,$this->_actionMain);
					}elseif (isset($this->_params['btnSaveAdd'])) {
						$this->_redirect("/{$this->_moduleName}/{$this->_controllerName}/add");
					}	
				}
				$this->view->popupMessage = $this->_helper->popupMessage(MESS_UPDATE,$this->_actionMain);
			}
		}else {
			$data = $this->_model->getItemOne( $productId );
		}
		
		$categoryModel = new Admin_Model_Category ();
		$categoryPath = is_array($data['categoryId']) ? implode(',', $data['categoryId']) : $data['categorys'];
		$categorys = $categoryModel->getCategorys ($categoryPath.',0', array('task' => 'by-parent-in'));
		$arrCategory = null;
		foreach($categorys as $key => $value){
			$arrCategory[$value['level']][] = $value;
		}
		
		ksort($arrCategory);
		$this->view->item = $data;
		$this->view->arrCategory = $arrCategory;
		$form->populate ( $data );
		$this->view->form = $form;
		$this->view->category = $categoryPath;
		$this->view->headScript()->appendFile(TEMPLATE_URL.'/admin/js/ckeditor/ckeditor.js');
	}
	
	function deleteAction(){
		$productId = $this->_params['id'];
		$productModel = new Admin_Model_Product();
		$result = $productModel->getItemOne($productId);
		if($result != null){
			if($productModel->removeItem($productId)){
				//$this->view->popupMessage = $this->_helper->popupMessage(MESS_DELETE,"/{$this->_moduleName}/{$this->_controllerName}/show-all");
				$this->_redirect("/{$this->_moduleName}/{$this->_controllerName}/show-all");
			}
		}
	}
	
	function deleteAllAction()
	{
		$productModel = new Admin_Model_Product();
		if($productModel->getItem() != null){
			if($productModel->removeAllItem()){
				$this->_redirect("/{$this->_moduleName}/{$this->_controllerName}/show-all");
			}
		}
		else
			$this->_redirect("/{$this->_moduleName}/{$this->_controllerName}/show-all");
	}
	
	function ajaxDeleteProductAction() {
		$template_path = TEMPLATE_PATH . "/admin";
		$this->loadTemplate ( $template_path, 'template.ini', 'ajax' );
		$this->_helper->viewRenderer->setNoRender ();
	
		$productModel = new Admin_Model_Product ();
	
		$productId = $this->_params ['id'];
		//My_Common::dump($productId);
		$result = array (
				'result' => $this->_model->removeProduct ( $productId ),
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