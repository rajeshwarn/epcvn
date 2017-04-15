<?php

class Default_ArticleController extends My_Controller_Action {
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
        
        $this->_model = new Default_Model_Articles();
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
    	
    }
    
    public function categoryAction() {   
    	$ssLang = new Zend_Session_Namespace('ssLang');
    	
    	$options['task'] = 'by-find-in';
    	
    	$paginator = $this->_helper->paginator->createPaginator($this->_model->countItem($this->_params, $options),
	    			$this->_paginator['itemCountPerPage'],
	    			$this->_paginator['pageRange'],
	    			$this->_paginator['currentPage']);
    	 
    	
    	$options['count'] = $this->_paginator['itemCountPerPage'];
    	$options['offset'] = ($this->_paginator['currentPage'] - 1) * $this->_paginator['itemCountPerPage'];

    	$articles = $this->_model->getItems($this->_params, $options); 
		
    	$title = ($articles[0]['catMetaTitle'] != '')?$articles[0]['catMetaTitle'] : $articles[0]['categoryName'.$ssLang->key];
    	$keyword = ($articles[0]['catMetaKeyword'] != '')?$articles[0]['catMetaKeyword'] : $articles[0]['categoryName'.$ssLang->key];
    	$description = ($articles[0]['catMetaDes'] != '')?$articles[0]['catMetaDes'] : $articles[0]['categoryName'.$ssLang->key];    	
    	$this->_helper->pageTitle($title, $keyword, $description);
 		
 		$this->view->articles = $articles;
 		$this->view->data = $paginator;
    }
    
    public function detailAction() {
    	$ssLang = new Zend_Session_Namespace('ssLang');
    	$id = $this->_params['id'];
    	
    	$article = $this->_model->getItemOne($this->_params, array('task' =>'by-alias'));
    	
    	$title = ($article['metaTitle'] != '')?$article['metaTitle'] : $article['title'.$ssLang->key];
    	$keyword = ($article['metaKeyword'] != '')?$article['metaKeyword'] : $article['title'.$ssLang->key];
    	$description = ($article['metaDescription'] != '')?$article['metaDescription'] : $article['title'.$ssLang->key];
    	$this->_helper->pageTitle($title, $keyword, $description);
    		
    	$this->view->article = $article;
    }

}