<?php
class Zend_View_Helper_CreateSymbol extends Zend_View_Helper_Abstract {

  public function CreateSymbol($level) {
    if($level == 1){
      return null;
    }else{
      $symbol = '';
      for($i = 2; $i <= $level; $i++){
        $symbol .= '&nbsp;&nbsp;&nbsp;&nbsp;';
      }
      $symbol .= '&#9507;&nbsp;&nbsp;';

      return $symbol;
    }
  }

}
