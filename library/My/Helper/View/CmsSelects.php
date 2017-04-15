<?php

class My_View_Helper_CmsSelects extends Zend_View_Helper_Abstract {

	public function cmsSelects($name, $value, $parentId, $options = null, $attribs = array(), &$result) {
		
		$html = '';
		foreach ($options as $key => $item) {
			
		}
		
		foreach ($options as $key => $item) {
			if($item['parentId'] == $parentId && in_array($parentId, $value)){
				$html .= '<option value="'.$item['id'].'">'.$item['titleVi'].'</option>';
				unset($options[$key]);
			}
			
			$tmp = current($options);
			$parentId = $tmp['parentId'];
		}
		
		if($html != ''){
			$result .= '<div class="category-box catChild"><select name="categoryId[]" id="categoryId" multiple="multiple" size="10" class="categoryIdProduct  form-control">'.$html.'</select></div>';
		}
		
		My_Common::dump($result); die;
		
		/* $html = '';
		foreach ($options as $key => $item) {
			if($item['parentId'] == $parentId && in_array($parentId, $value)){
				$html .= '<option value="'.$item['id'].'">'.$item['titleVi'].'</option>';
				unset($options[$key]);
			}
		}	
		
		if($html != ''){
			$result .= '<div class="category-box catChild"><select name="categoryId[]" id="categoryId" multiple="multiple" size="10" class="categoryIdProduct  form-control">'.$html.'</select></div>';
		}
			
		$tmp = current($options);
		$parentIdNew = $tmp['parentId'];
		
		if ($parentIdNew > 0) {
			$this->cmsSelects($name, $value, $parentIdNew, $options, $attribs, $result);
		}  */
		
		/**
		foreach($categorys as $key => $item){
			if($item['parentId'] == 0 || in_array($item['parentId'], $params)){
				
			}
			 
			$html .= '<option value="'.$item['id'].'">'.$item['titleVi'].'</option>';
						
			if($item['parentId'] == 0 || in_array($item['parentId'], $params)){
				$html .= '</select></div>';
			}
		}
		*/
		
		//return $html;
	}
	// edit category old
	/* 
    public function cmsSelects($name, $value = null, $params = null, $attribs = array(), &$result) {
        $categoryModel = new Admin_Model_Category();
        $parentId = $categoryModel->getCategoryOne($params);
        
        if($parentId == null || $parentId['parentId'] == 0){
        	$parentId['parentId'] = 0;
        	$optionFirst[] = array('id'=> null, 'parentId' => null,  'level'=>1, 'titleVi' => 'Danh mục chính');
        }
        
        $options = $categoryModel->getCategorys($parentId['parentId'], array('task' => 'by-parent'));
        
        if(isset($optionFirst)){
        	$options = array_merge($optionFirst, $options);
        }
        
        
        $strAttribs = '';
        if (count($attribs) > 0) {
            foreach ($attribs as $keyAttribs => $valueAttribs) {
                $strAttribs .= $keyAttribs . '="' . $valueAttribs . '" ';
            }
        }

        $xhtml = '<select name="' . $name . '" id="' . $name . '" ' . $strAttribs . ' >';

        foreach ($options as $key => $info) {
            $strSelect = '';
            
            if ($info['id'] == $value) {
                $strSelect = 'selected="selected"';
            }

            $xhtml .= '<option class="ui-tree0" data-level="' . $info['level'] . '" value="' . $info['id'] . '" ' . $strSelect . '>' . $info['titleVi'] . '</option>';
        }

        $xhtml .= '</select>';

        $result[$options[0]['level']] = $xhtml;
        $parentIdNew = $options[0]['parentId'];
        $valueNew = $options[0]['parentId'];

        if ($parentIdNew > 0) {
            $this->cmsSelects($name, $valueNew, $parentIdNew, $attribs, $result);
        }
    } */

}