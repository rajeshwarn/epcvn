<?php

class My_Helper_Action_RedirectSearchPage extends Zend_Controller_Action_Helper_Abstract {

    public function direct($params = array(), $isPost = false) {
        $url = '';
        $urlParams = array();
        
    	if ($isPost) {
    		
	    	$paramNotUse = array('module', 'controller', 'action', 'page');
	    	foreach ($params as $key => $val){    		
	    		if(!in_array($key, $paramNotUse)){
	    			if(is_array($val)){
	    				$val = end($val);
	    			}
	    			$tmp = explode('_', $key);
	    			$key = (count($tmp) > 1) ? $tmp[1] : $key;  
	    			
	    			$urlParams[$key] = $val;
	    		}
	    	}
	    	
        	$view = new Zend_View();
        	$url = $view->url($urlParams);
        	header("Location: {$url}");
        }
    }
}