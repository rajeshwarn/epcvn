<?php

class Default_Blocks_Support extends Zend_View_Helper_Abstract {

    public function support() {    	
    	$translate = Zend_Registry::get('Zend_Translate');
    	$ssLang = new Zend_Session_Namespace('ssLang');
    	
    	$supportModel = new Default_Model_Support();
    	$supports = $supportModel->getItems();
    	
        require_once (BLOCK_DEFAULT_PATH . '/Support/default.php');
    }
}