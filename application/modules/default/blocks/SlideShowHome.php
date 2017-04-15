<?php

class Default_Blocks_SlideShowHome extends Zend_View_Helper_Abstract {

    public function slideShowHome() {    	
    	$translate = Zend_Registry::get('Zend_Translate');
    	$slideshowModel = new Default_Model_SlideShow();
    	$slide = $slideshowModel->getItems(array('task' => 'home'));
    	$ssLang = new Zend_Session_Namespace('ssLang');
    	
        require_once (BLOCK_DEFAULT_PATH . '/SlideShowHome/default.php');
    }
}