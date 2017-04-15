<?php

class Default_ProductController extends My_Controller_Action {
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
    	 
    	//$options['columns'] = array('i');
    	$paginator = $this->_helper->paginator->createPaginator($this->_model->countItem($this->_params, $options),
    			$this->_paginator['itemCountPerPage'],
    			$this->_paginator['pageRange'],
    			$this->_paginator['currentPage']);
    	 
    	$options['count'] = $this->_paginator['itemCountPerPage'];
    	$options['offset'] = ($this->_paginator['currentPage'] - 1) * $this->_paginator['itemCountPerPage'];
    	
    	$products = $this->_model->getItems($this->_params, $options);
    	
    	$title = ($products[0]['catMetaTitle'] != '')?$products[0]['catMetaTitle'] : $products[0]['categoryName'.$ssLang->key];
    	$keyword = ($products[0]['catMetaKeyword'] != '')?$products[0]['catMetaKeyword'] : $products[0]['categoryName'.$ssLang->key];
    	$description = ($products[0]['catMetaDes'] != '')?$products[0]['catMetaDes'] : $products[0]['categoryName'.$ssLang->key];
    	$this->_helper->pageTitle($title, $keyword, $description);
    		
    	$this->view->products = $products;
    	$this->view->data = $paginator;
    }
    
    public function categoryAction() {   
    	$ssLang = new Zend_Session_Namespace('ssLang');
    	
    	$categoryModel = new Default_Model_Category();
    	$category = $categoryModel->getItemOne($this->_params, array('task' => 'by-alias', 'columns' => array('id')));
    	
    	$options['task'] = 'by-find-in';
    	$paginator = $this->_helper->paginator->createPaginator($this->_model->countItem(array('categoryId' => $category['id']), $options),
	    			$this->_paginator['itemCountPerPage'],
	    			$this->_paginator['pageRange'],
	    			$this->_paginator['currentPage']);
    	 
    	
    	$options['count'] = $this->_paginator['itemCountPerPage'];
    	$options['offset'] = ($this->_paginator['currentPage'] - 1) * $this->_paginator['itemCountPerPage'];

    	$products = $this->_model->getItems(array('categoryId' => $category['id']), $options); 

    	$title = ($products[0]['catMetaTitle'] != '')?$products[0]['catMetaTitle'] : $products[0]['categoryName'.$ssLang->key];
    	$keyword = ($products[0]['catMetaKeyword'] != '')?$products[0]['catMetaKeyword'] : $products[0]['categoryName'.$ssLang->key];
    	$description = ($products[0]['catMetaDes'] != '')?$products[0]['catMetaDes'] : $products[0]['categoryName'.$ssLang->key];    	
    	$this->_helper->pageTitle($title, $keyword, $description);
 		
 		$this->view->products = $products;
 		$this->view->data = $paginator;
    }
    
    public function detailAction() {
    	$ssLang = new Zend_Session_Namespace('ssLang');
    	//$id = $this->_params['id'];
    	
    	$product = $this->_model->getItemOne($this->_params, array('task' => 'by-alias'));
    	$productOther = $this->_model->getItems(array('id'=>$product['id'], 'categoryId'=>$product['categoryId']), array('task' => 'by-product-other', 'count' => 4));
    	
    	$timeview = new Zend_Session_Namespace ( 'timeview' );
    	$time = time ();
    	$view = $product ['views'];
    	 
    	if (! $timeview->timeview) {
    		$timeview->timeview = $time;
    		$view += 1;
    		$info ['views'] = $view;
    		 
    		$this->_model->updateItem ( $product['id'], $info );
    	} elseif ($time - $timeview->timeview > 30) {
    		$timeview->timeview = $time;
    		 
    		$view += 1;
    		$info ['views'] = $view;
    		 
    		$this->_model->updateItem ( $product['id'], $info );
    	}
    	
    	$title = ($product['metaTitle'] != '')?$product['metaTitle'] : $product['title'.$ssLang->key];
    	$keyword = ($product['metaKeyword'] != '')?$product['metaKeyword'] : $product['title'.$ssLang->key];
    	$description = ($product['metaDescription'] != '')?$product['metaDescription'] : $product['title'.$ssLang->key];
    	$this->_helper->pageTitle($title, $keyword, $description);
    		
    	$this->view->product = $product;
    	$this->view->productOther = $productOther;
    }

}