<?php

class Default_Blocks_ProductHot extends Zend_View_Helper_Abstract {

    public function productHot() {    	
    	$translate = Zend_Registry::get('Zend_Translate');
    	
        require_once (BLOCK_DEFAULT_PATH . '/ProductHot/default.php');
    }
}