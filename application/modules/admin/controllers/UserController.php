<?php
class Admin_UserController extends My_Controller_Action {

	  private $_model;
	  private $_moduleName = "";
	  private $_controllerName;
	  private $_actionName;
	  private $_feedback;
	  private $_actionMain = "";
	  private $_params = array();
	  private $_userID = "";
	
	  public function init() {
	    $template_path = TEMPLATE_PATH . "/admin";
	    $this->loadTemplate($template_path, 'template.ini', 'template');
	
	    $this->_model = new Admin_Model_User();
	    $this->_moduleName = $this->_request->getModuleName();
	    $this->_controllerName = $this->_request->getControllerName();
	    $this->_actionName = $this->_request->getActionName();
	    $this->_params = $this->_request->getParams();
	    $this->_actionMain = '/' . $this->_moduleName . '/' . $this->_controllerName . '/show-all';
	    
	    $this->view->params = $this->_params;
	    $this->view->controllerName = $this->_controllerName;
	
	    $auth = Zend_Auth::getInstance();
	    $infoUser = $auth->getIdentity();
	    $this->_userID = $infoUser['userId'];
	    //My_Auth_User::authenticate();
	    /* if (in_array($this->_actionName, array('add', 'edit', 'show-all'))) {
	      $auth = Zend_Auth::getInstance();
	      if ($auth->getIdentity()->Group != 'ADMIN') {
	        $this->_redirect('/index/permission');
	      }
	    }    */ 
	  }
	
	  public function indexAction() {  	
	  	My_Auth_User::allow($this->getRequest());
	  	
	    $this->_forward('show-all');
	  }
	
	  public function loginAction() {
	    $template_path = TEMPLATE_PATH . "/admin";
	    $this->loadTemplate($template_path, 'template.ini', 'login');
	
	    $form = new Admin_Form_Login ();
	    $userModel = new Admin_Model_User();
	
	    if ($this->_request->isPost()) {
	      $salt = '';
	      $formData = $this->_request->getPost();
	     
	      if ($form->isValid($formData)) {
	        $data = $form-> getValues();
	        $user = $userModel->getUserByUsername($data['userName']);
	
	        $adapter = new Zend_Auth_Adapter_DbTable($userModel->getAdapter());
	        $adapter->setTableName('users')
	                ->setIdentityColumn('username')
	                ->setCredentialColumn('password')
	                ->setCredentialTreatment('?');
	        $adapter->setIdentity($data['userName']);
	        $adapter->setCredential($data['password']);
	        if ($user) {
	          $salt = $user->salt;
	        }
	        $adapter->setCredential(md5(md5($data['password']) . $salt));
	        
	        $auth = Zend_Auth::getInstance();
	        $result = $auth->authenticate($adapter);
	        
	        if ($result->isValid()) {
	          $auth->getStorage()->write(array('username' => $user->userName, 'userId' => $user->uid));
	          $redirectUrl = $this->getRequest()->getParam('redirectUrl', '');
	          
	          if ($redirectUrl != '') {
	            $this->_redirect($redirectUrl);
	          } else {
	            $this->_redirect('/admin');
	          }
	        }
	      }      
	      $this->_feedback = 'Tên đăng nhập hoặc mật khẩu không chính xác!';
	    }
	    $this->view->form = $form;
	    $this->view->pageTitle = 'Login';
	    $this->view->feedback = $this->_feedback;
	  }
	
	  public function logoutAction() {
	    $auth = Zend_Auth::getInstance();
	    // Delete user session
	    $auth->clearIdentity();
	    //return $this->_helper->redirector('index', 'user','admin');
	    $this->_redirect('/admin/user/login');
	  }
	  public function showAllAction() {
	  	//My_Auth_User::allow($this->getRequest());
	  	
	  	$this->_helper->redirectSearchPage($this->_params, $this->_request->isPost());
	  
	  	$userPage = $this->_model->getItemInfo($this->_params);
	  
	  	$adapter = new Zend_Paginator_Adapter_DbSelect($userPage);
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
	  	//My_Auth_User::allow($this->getRequest());
	  	
	  	$data = $this->_request->getParams();
	  	$form = new Admin_Form_User();
	  	$roleModel = new Admin_Model_Role();
	  	
	  	$roles = $roleModel->getItemInSelectbox();
	  
	  	if($this->_request->isPost()){
	  		//$valid = new Admin_Form_Validators_UserValid($data);&& $valid->isValid()
	  			
	  		if($form->isValid ( $data ) ) {
	  			$data = $form->getValues();
	  			$db = Zend_Db_Table::getDefaultAdapter();
	  			$db->beginTransaction(); 
	  			try {
	  				$userRoleModel = new Admin_Model_UserRole();
	  				$info['roleId'] = $this->_params['roleId'];
	  				$userId = $this->_model->addItem($data);
	  				$info['uId'] = $userId;
	  				$userRoleId = $userRoleModel->addItem($info);
	  				if($userId && $userRoleId) {
	  					if(isset($this->_params['btnSave'])) {
	  						$this->view->popupMessage = $this->_helper->popupMessage(MESS_ADD,$this->_actionMain);
	  					}elseif (isset($this->_params['btnSaveAdd'])) {
	  						$this->_redirect("/{$this->_moduleName}/{$this->_controllerName}/{$this->_actionName}");
	  					}
	  				}
	  			}catch (Exception $e) {
	  				$db->rollBack();
	  				throw $e;
	  			}
	  		}
	  	}
	  	$this->view->form = $form;
	  	$this->view->role = $roles;
	  }
	  
	  public function editAction() {
	  	//My_Auth_User::allow($this->getRequest());
	  	
	  	$userId = $this->_params ['id'];
	  	$form = new Admin_Form_User();
	  	$roleModel = new Admin_Model_Role();
	  	$userRoleModel = new Admin_Model_UserRole();
	  	
	  	$roles = $roleModel->getItemInSelectbox();
	  
	  	if($this->_request->isPost())
	  	{
	  		$data = $this->_request->getPost ();
	  		//$valid = new Admin_Form_Validators_UserValid($data);&& $valid->isValid()
	  		if($form->isValid ( $data ) ) {
	  			$data = $form->getValues();
	  			
	  			$db = Zend_Db_Table::getDefaultAdapter();
	  			$db->beginTransaction();
	  			try {
	  				$info=$this->_params ['roleId'];
	  				$userUpdate = $this->_model->updateItem($userId,$data);
	  				$userRoleUpdate = $userRoleModel->updateItem($userId, $info);
		  			if($userUpdate && $userRoleUpdate) {
		  				if(isset($this->_params['btnSave'])) {
		  					$this->view->popupMessage = $this->_helper->popupMessage(MESS_UPDATE,$this->_actionMain);
		  				}elseif (isset($this->_params['btnSaveAdd'])) {
		  					$this->_redirect("/{$this->_moduleName}/{$this->_controllerName}/add");
		  				}
		  			}
	  			}
	  			catch (Exception $e){
	  				$db->rollBack();
	  				throw $e;
	  			}
	  			$data = $this->_model->getUserOne( $userId );
	  			$this->view->popupMessage = $this->_helper->popupMessage(MESS_UPDATE,$this->_actionMain);
	  		}
	  	}else {
	  		$data = $this->_model->getUserOne( $userId );
	  			
	  	}
	  	$this->view->item = $data;
	  	$form->populate ( $data );
	  	$this->view->form = $form;
	  	$this->view->role = $roles;
	  	$this->view->roleSelect = $data['roleId'];
	  }
	  
	  function deleteAction(){
	  	My_Auth_User::allow($this->getRequest());
	  	
	  	$userId = $this->_params['id'];
	  	$result = $this->_model->getUserOne($userId);
	  	
	  	if($result != null){
	  		if($this->_model->removeItem($userId)){
	  			$this->_redirect("/{$this->_moduleName}/{$this->_controllerName}/show-all");
	  		}
	  	}
	  }
	  
	  function deleteAllAction()
	  {
	  	My_Auth_User::allow($this->getRequest());
	  	if($this->_model->getItem() != null){
	  		if($this->_model->removeAllItem()){
	  			$this->_redirect("/{$this->_moduleName}/{$this->_controllerName}/show-all");
	  		}
	  	}
	  	else
	  		$this->_redirect("/{$this->_moduleName}/{$this->_controllerName}/show-all");
	  }
	  public function roleAction(){
	  	My_Auth_User::allow($this->getRequest());
	  	
	  	//$this->_helper->redirectSearchPage($this->_params, $this->_request->isPost());
	  	$resourceModel = new Admin_Model_Resource();
	  	$privilegeModel = new Admin_Model_Privilege();
	  	$roleModel = new Admin_Model_Role();
	  	
	  	$roles = $roleModel->getItemInSelectbox();
	  	
	  	$resources = $resourceModel->getItems();
	  	$arrResource = null;
	  	$status = "";
	  	foreach ($resources as $k => $val){
	  		$arrResource[$val['controllerName']][] = $val;
	  	}
	  	
	  	if($this->_request->isPost()){
		  	if(isset($this->_params['sl_status']) && $this->_params['sl_status'] != ''){
		  		$privilegeId = $this->_params['sl_status'];
		  		$privileges = $privilegeModel->getItemInfo($privilegeId,array('task' => 'by-resourceId'));
		  		if($privileges == null){
		  			$arrPrivileges = array();
		  		}
		  		else {
		  			$arrPrivileges = array();
		  			foreach ($privileges as $k => $val){
		  				$arrPrivileges[$val['resourceId']] = $val['resourceId'];
		  			}
		  		}
		  	}
		  	if(isset($this->_params['btnSave'])){
		  		$data['roleId'] = $this->_params['userId'];
		  		$arrResourceId = $this->_params['arrResourceId'];
		  		$privilegeModel->deleteItem($data['roleId']);
	  			foreach ($arrResourceId as $k => $val){
	  				$data['resourceId'] = $val;
	  				$privilegeModel->addItem($data);
	  			}
		  		$privileges = $privilegeModel->getItemInfo($data['roleId'],array('task' => 'by-resourceId'));
		  		if($privileges == null){
		  			$arrPrivileges = array();
		  		}
		  		else {
		  			$arrPrivileges = array();
		  			foreach ($privileges as $k => $val){
		  				$arrPrivileges[$val['resourceId']] = $val['resourceId'];
		  			}
		  		}
		  		$status = $data['roleId'];
		  	}
	  	}else{
	  		$userRoleModel = new Admin_Model_UserRole();
	  		$role = $userRoleModel->getItemOne($this->_userID);
	  		$privileges = $privilegeModel->getItemInfo($role['roleId'],array('task' => 'by-resourceId'));
	  		if($privileges == null){
	  			$arrPrivileges = array();
	  		}
	  		else {
	  			$arrPrivileges = array();
	  			foreach ($privileges as $k => $val){
	  				$arrPrivileges[$val['resourceId']] = $val['resourceId'];
	  			}
	  		}
	  	}
	  	$this->view->arrPrivileges = $arrPrivileges;
	  	$this->view->arrResource = $arrResource;
	  	$this->view->role = $roles;
	  	$this->view->statusSelected = isset($this->_params['sl_status']) ? $this->_params['sl_status']:$status;
	  	//My_Common::dump($this->_userID); die;
	  	$this->view->UserId = isset($this->_params['sl_status']) ? $this->_params['sl_status']:$this->_userID;
	  }

}