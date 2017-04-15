<?php

class Block_BlkMenu extends Zend_View_Helper_Abstract {

    public function blkMenu() {    	
    	require_once (BLOCK_PATH . '/BlkMenu/default.php');
        /* $view = $this->view;
        $arrParam = $view->arrParam;
       	$categoryModel = new Default_Model_Category();
       	$categorys = $categoryModel->getItems(); 
       	
        $strMenu = $this->createMenu($categorys, 0, $view);
        
        require_once (BLOCK_PATH . '/BlkMenu/default.php'); */
    }

    /* public function createMenu($sourceArr, $parents = 0, $viewObj) {
        $this->recursiveMenu($sourceArr, $parents = 0, &$newMenu, $viewObj);
        return str_replace('<ul></ul>', '', $newMenu);
    }

    public function recursiveMenu($sourceArr, $parents = 0, &$newMenu, $viewObj) {
        $filter = new Zend_Filter();
        $multiFilter = $filter->addFilter(new Zendvn_Filter_RemoveCircumflex())
                ->addFilter(new Zend_Filter_StringToLower(array('encoding' => 'UTF-8')))
                ->addFilter(new Zend_Filter_Alnum(true))
                ->addFilter(new Zend_Filter_PregReplace(array('match' => '#\s+#', 'replace' => '-')))
                ->addFilter(new Zend_Filter_Word_SeparatorToDash());
        if (count($sourceArr) > 0) {
            $idUL = 'ulGroup_' . $parents;
            $newMenu .= '<ul id="' . $idUL . '">';
            foreach ($sourceArr as $key => $value) {
                if ($value['parents'] == $parents) {
                    $liMenu = 'liMenu_' . $value['id'];
                    if ($value['parents'] == 0) {
                        $newMenu .= '<li ><a id="' . $liMenu . '">' . $value['name'] . '</a>';
                    } else {
                        $link = $viewObj->baseUrl('/shopping/index/category/cid/'
                                . $value['id'] . '/name/'
                                . $multiFilter->filter($value['name']));
                        $newMenu .= '<li ><a href="' . $link . '" id="' . $liMenu . '">' . $value['name'] . '</a>';
                    }

                    $newParents = $value['id'];
                    unset($sourceArr[$key]);
                    $this->recursiveMenu($sourceArr, $newParents, $newMenu, $viewObj);
                    $newMenu .= '</li>';
                }
            }
            $newMenu .= '</ul>';
        }
    } */

}