<?php

class Default_Blocks_Footer extends Zend_View_Helper_Abstract {

    public function footer() {    	
    	$config = Zend_Registry::get('config');
    	$translate = Zend_Registry::get('Zend_Translate');
    	$ssLang = new Zend_Session_Namespace('ssLang');
		$pageModel = new Default_Model_Page();
    	$page = $pageModel->getItemOne('footer');
    	
        require_once (BLOCK_DEFAULT_PATH . '/Footer/default.php');
    }
}