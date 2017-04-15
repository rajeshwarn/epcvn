<?php

class Default_Blocks_Menu extends Zend_View_Helper_Abstract {

    public function menu() {    	
    	$translate = Zend_Registry::get('Zend_Translate');
    	$categoryModel = new Default_Model_Category();
       	$categorys = $categoryModel->getItems();        	
       	$view = Zend_Layout::getMvcInstance()->getView();
        $strMenu = $this->createMenu($categorys, 0, $view);
        
        require_once (BLOCK_DEFAULT_PATH . '/Menu/default.php');
    }

    public function createMenu($sourceArr, $parents = 0, $viewObj) {
        $this->recursiveMenu($sourceArr, $parents = 0, &$newMenu, $viewObj);
        return preg_replace('/<ul[^>]*>(.*)<\/ul[^>]*>/i', '$1', $newMenu);
    }

    public function recursiveMenu($sourceArr, $parents = 0, &$newMenu, $viewObj, $step = 0) {
    	$ssLang = new Zend_Session_Namespace('ssLang');
    	$translate = Zend_Registry::get('Zend_Translate');
    	
        $filter = new Zend_Filter();
        $multiFilter = $filter->addFilter(new Zend_Filter_StringToLower(array('encoding' => 'UTF-8')))
                ->addFilter(new Zend_Filter_PregReplace(array('match' => '#\s+#', 'replace' => '-')))
                ->addFilter(new Zend_Filter_Word_SeparatorToDash());
        if (count($sourceArr) > 0) {
            $idUL = 'ulGroup_' . $parents;
            $newMenu .= '<ul id="' . $idUL . '">';
            foreach ($sourceArr as $key => $value) {
                if ($value['parentId'] == $parents) {
                    $liMenu = 'liMenu_' . $value['id'];
                    $link = '/'.$translate->translate('ALIAS_CATEGORY'). $viewObj->baseUrl($multiFilter->filter($value['alias'.$ssLang->key]));
                    
                    if($step % 2 == 0){
                    	$class='class="bg-menu"';
                    }else{
                    	$class='class=""';
                    }
                    
                   /*  if ($value['parentId'] == 0) {
                        $newMenu .= '<li ><a id="' . $liMenu . '">' . $value['title'.$ssLang->key] . '</a>';
                    } else { */
                        
                        $newMenu .= '<li '.$class.'><a href="' . $link . '" id="' . $liMenu . '">' . $value['title'.$ssLang->key] . '</a>';
                    //}

                    $newParents = $value['id'];
                    unset($sourceArr[$key]);
                    $this->recursiveMenu($sourceArr, $newParents, $newMenu, $viewObj,  $step++);
                    $newMenu .= '</li>';
                }
            }
            $newMenu .= '</ul>';
        }
    }

}