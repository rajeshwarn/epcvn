<?php

class Admin_CategoryController extends My_Controller_Action {

    private $_model = '';
    private $_moduleName = '';
    private $_controllerName = '';
    private $_actionName = '';
    private $_actionMain = '';
    private $_feedback = '';
    private $_params = array();
    private $_userId = '';
    private $_userName = '';

    public function init() {
        $template_path = TEMPLATE_PATH . "/admin";
        $this->loadTemplate($template_path, 'template.ini', 'template');

        $this->_model = new Admin_Model_Category();
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
        $this->_userName = $infoUser['username'];
    }

    public function indexAction() {
        $this->_redirect("/{$this->_moduleName}/{$this->_controllerName}/show-all");
    }

    public function showAllAction() {
        $category = $this->_model->getCategoryInfo();

        $this->view->category = $category;
    }
    
    public function addAction() {
        $data = $this->_request->getPost();
        $form = new Admin_Form_Category();

        //$this->view->category = $this->_model->getItemInSelectbox();
        
        $categorys = $this->_model->getItemInSelectbox();        
       
        if ($this->_request->isPost()) {
            //$valid = new Admin_Form_Validators_CategoryValid($data);
           
            if ($form->isValid($data)) {
                $data = $form->getValues();
                
                $data['parentId'] =  $this->_params['categoryId'];                
                $data['createdBy'] = $this->_userId;
                
                $categoryId = $this->_model->addItem($data);

                if ($categoryId) {
                    if (isset($this->_params['btnSave'])) {
                        $this->view->popupMessage = $this->_helper->popupMessage(MESS_ADD, $this->_actionMain);
                    } elseif (isset($this->_params['btnSaveAdd'])) {
                        $this->_redirect("/{$this->_moduleName}/{$this->_controllerName}/{$this->_actionName}");
                    }
                }
            } else {
                $this->view->error = $form->messages;
            }
        }
        
        
        $this->view->form = $form;
        $this->view->category = $categorys;
    }

    public function editAction() {
        $categoryId = $this->_params['id'];
        
        $categorys = $this->_model->getItemInSelectbox();
        
        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
        } else {
            $data = $this->_model->getCategoryOne($categoryId);
        }

        $form = new Admin_Form_Category();

        if ($this->_request->isPost()) {
            //$valid = new Admin_Form_Validators_CategoryValid($data);

            if ($form->isValid($data)) {
                $data = $form->getValues();

                $data['parentId'] = $this->_params['categoryId'];
                $data['modified'] = date(DATETIME_FORMAT_DB, time());
                $data['modifiedBy'] = $this->_userId;
                
                if ($this->_model->updateItem($categoryId, $data)) {
                    if (isset($this->_params['btnSave'])) {
                        $this->view->popupMessage = $this->_helper->popupMessage(MESS_UPDATE, $this->_actionMain);
                    } elseif (isset($this->_params['btnSaveAdd'])) {
                        $this->_redirect("/{$this->_moduleName}/{$this->_controllerName}/add");
                    }
                }
            } else {
                $this->view->error = $form->messages;
            }
        }

        $form->populate($data);
        $this->view->data = $data;        
        $this->view->form = $form;
        $this->view->category = $categorys;
    }
    
    function deleteAllAction(){
    	$this->_model->removeAllItem('', array('task' => 'remove-all'));
    	 
    	$this->_redirect("/{$this->_moduleName}/{$this->_controllerName}/show-all");
    }

    function ajaxEditCategoryAction() {
        $template_path = TEMPLATE_PATH . "/admin";
        $this->loadTemplate($template_path, 'template.ini', 'ajax');
        $this->_helper->viewRenderer->setNoRender();

        $categoryId = $this->_params['id'];
        $field = $this->_params['field'];
        $value = $this->_params['value'];

        $data[$field] = $value;
        $data['modified'] = date(DATETIME_FORMAT_DB, time());
        $data['modifiedBy'] = $this->_userId;
        $data['modifiedByUserName'] = $this->_userName;

        $result = array(
            'result' => $this->_model->updateItem($categoryId, $data),
            'value' => $value,
        );
        echo json_encode($result);
        die;
    }

    function ajaxRemoveCategoryAction() {
        $template_path = TEMPLATE_PATH . "/admin";
        $this->loadTemplate($template_path, 'template.ini', 'ajax');
        $this->_helper->viewRenderer->setNoRender();
        
        $actionName = $this->_params['actionName'];
        
        if($actionName == 'REMOVE_ROW'){
	        $productModel = new Admin_Model_Product();
	
	        $categoryId = $this->_params['data'];
	        $parents = $this->_model->getCategorys($categoryId, array('task'=>'by-parent'));
	        $products = $productModel->getItems($categoryId, array('task'=>'by-category'));
	
	        if ($products != NULL) {
	            $message = 'Không thể xoá danh mục này. Vì có sản phẩm trong danh mục';
	            $message = $this->_helper->popupMessage($message);
	            $result = array(
	                'result' => 2,
	                'value' => $message,
	            );
	        } elseif ($parents != NULL) {
	            $message = 'Không thể xoá danh mục này. Vì có danh mục con';
	            $message = $this->_helper->popupMessage($message);
	            $result = array(
	                'result' => 3,
	                'value' => $message,
	            );
	        } else {
	            $result = array(
	                'result' => $this->_model->removeItem($categoryId),
	                'value' => $categoryId,
	            );
	        }
        }elseif ($actionName == 'REMOVE_ALL'){
        	$this->_model->removeItem('', array('task' => 'remove-all'));
        }

        echo json_encode($result);
        die;
    }
    
    function ajaxRemoveAction() {
    	$template_path = TEMPLATE_PATH . "/admin";
    	$this->loadTemplate($template_path, 'template.ini', 'ajax');
    	$this->_helper->viewRenderer->setNoRender();
    
    	$this->_model->removeItem('', array('task' => 'remove-all'));
    	
    	die;
    }
    
    function ajaxDeleteCategoryAction() {
    	$template_path = TEMPLATE_PATH . "/admin";
    	$this->loadTemplate($template_path, 'template.ini', 'ajax');
    	$this->_helper->viewRenderer->setNoRender();
    
    	$actionName = $this->_params['actionName'];
    
    	if($actionName == 'REMOVE_ROW'){
    		$productModel = new Admin_Model_Product();
    
    		$categoryId = $this->_params['data'];
    		$parents = $this->_model->getCategorys($categoryId, array('task'=>'by-parent'));
    		$products = $productModel->getProduct($categoryId, array('task'=>'by-category'));
    
    		if ($products != NULL) {
    			$message = 'Không thể xoá danh mục này. Vì có sản phẩm trong danh mục';
    			$message = $this->_helper->popupMessage($message);
    			$result = array(
    					'result' => 2,
    					'value' => $message,
    			);
    		} elseif ($parents != NULL) {
    			$message = 'Không thể xoá danh mục này. Vì có danh mục con';
    			$message = $this->_helper->popupMessage($message);
    			$result = array(
    					'result' => 3,
    					'value' => $message,
    			);
    		} else {
    			$result = array(
    					'result' => $this->_model->removeItem($categoryId),
    					'value' => $categoryId,
    			);
    		}
    	}elseif ($actionName == 'REMOVE_ALL'){
    		$this->_model->removeItem('', array('task' => 'remove-all'));
    	}
    
    	echo json_encode($result);
    	die;
    }
    
    function ajaxDeleteAction() {
    	$template_path = TEMPLATE_PATH . "/admin";
    	$this->loadTemplate($template_path, 'template.ini', 'ajax');
    	$this->_helper->viewRenderer->setNoRender();
    
    	$this->_model->removeItem('', array('task' => 'remove-all'));
    	 
    	die;
    }

    public function ajaxGetCategoryAction() {
        $this->_helper->layout()->setLayout('ajax');        
        $parentId = $this->_request->getParam('id', null);
        $categorys = null;
        
        if($parentId != null){
        	$categorys = $this->_model->getFetchPairs(array('parentId' => $parentId), array('task' => 'by-parent'));
        }
        
        $this->view->category = $categorys;
    }
    
    /**
     * get category array page product
     */
    public function ajaxGetCategoryProductAction() {
    	$this->_helper->layout()->setLayout('ajax');
    	$parentId = $this->_request->getParam('id', null);
    	$categorys = null;
    
    	if($parentId != null){
    		$categorys = $this->_model->getFetchPairs(array('parentId' => $parentId), array('task' => 'by-parent'));
    	}
    
    	$this->view->category = $categorys;
    }
    
    /**
     * get all category
     */
    public function ajaxGetAllCategoryAction() {
    	$this->_helper->layout()->setLayout('ajax');
    	
    	$categoryPath = explode(',', $this->_request->getParam('categoryPath', null));
    	$categorys = $this->_model->getCategorys();    	
    	
    	$this->view->category = $categorys;
    	$this->view->categoryPath = $categoryPath;
    }

    public function trashAction(){
    	$category = $this->_model->getCategoryInfo('', array('task'=>'trash'));
    	
    	$this->view->category = $category;
    }
}