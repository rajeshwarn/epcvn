<?php

class Default_Blocks_SlideShow extends Zend_View_Helper_Abstract {

    public function slideShow() {    	
    	$slideshowModel = new Default_Model_SlideShow();
    	$request=Zend_Controller_Front::getInstance()->getRequest(); 
		$params=$request->getParams();
		$catId = null;
		
		if(isset($params["categoryId"])){
			$options['task'] = 'child-category';
			$catId = $params["categoryId"];
		}elseif($params["controller"] === 'article' && $params["action"] === 'detail'){
			$options['task'] = 'child-detail';
			$catId = $params["id"];
		}else{
			$options['task'] = 'child-orther';
		}
		
    	$slide = $slideshowModel->getItems($options, $catId);
    	
    	if(empty($slide)){
    		$slide = $slideshowModel->getItems(array('task' => 'child-orther'));
    	} 
    	
        require_once (BLOCK_DEFAULT_PATH . '/SlideShow/default.php');
    }
}