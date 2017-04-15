<?php

class Zend_View_Helper_CurrentResultItemNumber extends
                Zend_View_Helper_Abstract {
    public function currentResultItemNumber($paginator, $pageListCount = PAGE_LIST_COUNT) {
        $itemNumber = $paginator->getCurrentItemCount();
        $first = $pageListCount * ($paginator->getCurrentPageNumber() - 1);
        if($itemNumber != 0) {
            $first++;
        }
        $last = $first + $itemNumber - 1;
        $result = 'Results ' . $first
                .' - ' . $last
                .' out of ' . $paginator->getTotalItemCount();
        return $result;
    }
}
