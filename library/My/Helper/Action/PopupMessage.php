<?php

class My_Helper_Action_PopupMessage extends Zend_Controller_Action_Helper_Abstract {

    public function direct($message, $path = null, $type = 'success') {
        $html = '<script>';
        $html .= '$(document).ready(function(){';
        $html .= '$("#fix-bg").show();';
        $html .= 'setTimeout(function(){ $(".toast-container").animate({"opacity":0}, 2000, function(){$(this).empty(); $("#fix-bg").hide();';
        if ($path != null) {
            $html .= 'window.location="' . $path . '"';
        }
        $html .= '}), 2000 });';
        $html .= '});</script>';
        $html .= '<div class="toast-container toast-position-top-right">';
        $html .= '<div class="toast-item-wrapper">';
        $html .= '<div class="toast-item toast-type-' . $type . '">';
        $html .= '<div class="toast-item-image toast-item-image-' . $type . '"></div>';
        $html .= '<div class="toast-item-close"></div>';
        $html .= '<p>' . $message . '</p>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        return $html;
    }

}
