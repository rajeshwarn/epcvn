<?php

class My_View_Helper_CmsTreeView extends Zend_View_Helper_Abstract {

    public function cmsTreeView($name, $value = null, $parentId, $options, $attribs = array(), &$result) {
        if(count($options) > 0){
	        $strAttribs = '';
	        if (count($attribs) > 0) {
	            foreach ($attribs as $keyAttribs => $valueAttribs) {
	                $strAttribs .= $keyAttribs . '="' . $valueAttribs . '" ';
	            }
	        }
	
	        $result .= '<ul name="' . $name . '" id="' . $name . '" ' . $strAttribs . ' >';
	
	        foreach ($options as $key => $info) {
	        	if($info['parentId'] == $parentId){
		            $liClass = '';
		            
		            if (is_array($value) && in_array($info['id'], $value)) {
		                $liClass = 'active"';
		            }
		
		            $result .= '<li class="'.$liClass.'" data-level="' . $info['level'] . '" id="' . $info['id'] . '" data-value="' . $info['titleVi'] . '">' . $info['titleVi'];
		            
		            $parentNew = $options[$key]['id'];
		            unset($options[$key]);
		            $this->cmsTreeView($name, $value, $parentNew, $options, $attribs, $result);
		            $result .= '</li>';
		        }	
	        }	   
	        $result .= '</ul>';
        }        
    }
}