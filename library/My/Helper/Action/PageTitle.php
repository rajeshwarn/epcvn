<?php

class My_Helper_Action_PageTitle extends Zend_Controller_Action_Helper_Abstract {

    public function direct($title, $keyword, $description) {
    	$layout = Zend_Layout::getMvcInstance();
    	$view = $layout->getView();
    	
    	if($title != ''){
    		$view->headTitle()->set('');
    		$view->headTitle($title);
    	}
    	
    	if($keyword || $description){
    		$view->headMeta()->getContainer()->exchangeArray(array());
    		
    		$view->headMeta()->appendName('keywords', $keyword);
    		$view->headMeta()->appendName('description', $description);
    	}
    }
}
