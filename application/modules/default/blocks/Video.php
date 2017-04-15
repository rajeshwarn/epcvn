<?php

class Default_Blocks_Video extends Zend_View_Helper_Abstract {

    public function video() {    	
    	$videoModel = new Default_Model_Video();
    	
    	$options['columns'] = array('code');
    	$videos = $videoModel->getItems('', $options);
    	
        require_once (BLOCK_DEFAULT_PATH . '/Video/default.php');
    }
}