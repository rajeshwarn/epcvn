<?php

class Default_Blocks_Partner extends Zend_View_Helper_Abstract {

    public function partner() {    	
    	$partnerModel = new Default_Model_Partner();
    	$partners = $partnerModel->getItems('', array('count' => 10, 'offset' => 0));
    	
        require_once (BLOCK_DEFAULT_PATH . '/Partner/default.php');
    }
}