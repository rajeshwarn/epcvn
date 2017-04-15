<?php
class My_Helper_Action_Paginator extends Zend_Controller_Action_Helper_Abstract{
    public function createPaginator($totalItem,$itemCountPerPage,$pageRange,$currentPage,$option = NULL){

        $adapter = new Zend_Paginator_Adapter_Null($totalItem);

        $paginator  = new Zend_Paginator($adapter);

        $paginator->setItemCountPerPage($itemCountPerPage);
        $paginator->setPageRange($pageRange);
        $paginator->setCurrentPageNumber($currentPage);

        return $paginator;
    }
}