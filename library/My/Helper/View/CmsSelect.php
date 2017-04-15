<?php

class My_View_Helper_CmsSelect extends Zend_View_Helper_Abstract {

    public function cmsSelect($name, $value = null, $options, $attribs = array()) {

        $strAttribs = '';
        if (count($attribs) > 0) {
            foreach ($attribs as $keyAttribs => $valueAttribs) {
                $strAttribs .= $keyAttribs . '="' . $valueAttribs . '" ';
            }
        }

        $xhtml = '<select name="' . $name . '" id="' . $name . '" ' . $strAttribs . ' >';
        //$xhtml .= '<option value="">'.PLEASE_SELECT.'</option>';
        foreach ($options as $key => $info) {
            $strSelect = '';
            if ($info['id'] == $value) {
                $strSelect = 'selected="selected"';
            }

            if ($info['level'] == 1) {
                $xhtml .= '<option class="ui-tree0" data-level="'.$info['level'].'" value="' . $info['id'] . '" ' . $strSelect . '>' . $info['titleVi'] . '</option>';
            } else {
                $string = '&nbsp;&nbsp;&nbsp;&nbsp;';
                $newString = '';
                for ($i = 1; $i < $info['level']; $i++) {
                    $newString .= $string;
                }
                $info['titleEn'] = $newString . '&#9507;&nbsp;&nbsp;' . $info['titleVi'];
                $xhtml .= '<option class="ui-tree0" data-level="'.$info['level'].'" value="' . $info['id'] . '" ' . $strSelect . '>' . $info['titleVi'] . '</option>';
            }
        }

        $xhtml .= '</select>';

        return $xhtml;
    }

}