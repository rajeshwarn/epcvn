<?php

class My_View_Helper_CmsEditor extends Zend_View_Helper_Abstract {

	/*
	 * setupCKeditor
	 */
	public function cmsEditor($form, $name, $width = '100%', $height = '300') {
		$html = $form;
	
		$html .= "<script type=\"text/javascript\">
		    var editor = CKEDITOR.replace('" . $name . "',
									    {
                                            width: '" . $width . "',
                                            height: '" . $height . "',
                                            filebrowserBrowseUrl : '" . TEMPLATE_URL . "/admin/js/ckfinder/ckfinder.html',
                                            filebrowserImageBrowseUrl : '" . TEMPLATE_URL . "/admin/js/ckfinder/ckfinder.html?type=Images',
                                            filebrowserFlashBrowseUrl : '" . TEMPLATE_URL . "/admin/js/ckfinder/ckfinder.html?type=Flash',
                                            filebrowserUploadUrl : '" . TEMPLATE_URL . "/admin/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                                            filebrowserImageUploadUrl : '" . TEMPLATE_URL . "/admin/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                                            filebrowserFlashUploadUrl : '" . TEMPLATE_URL . "/admin/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
                                        });
				  CKFinder.setupCKEditor( editor, '../' );
	
		    </script>";
	
		return $html;
	}
	
	/*
    public function cmsEditor($name, $attribs = array(), $width = '100%', $height = '300') {
        $strAttribs = '';
        if (count($attribs) > 0) {
            foreach ($attribs as $keyAttribs => $valueAttribs) {
                $strAttribs .= $keyAttribs . '="' . $valueAttribs . '" ';
            }
        }

        $html = '<textarea name="' . $name . '" id="' . $name . '" ' . $strAttribs . ' cols="40" rows="2"></textarea>';

        $html .= "<script type=\"text/javascript\">
		    var editor = CKEDITOR.replace('" . $name . "',
									    {
                                            width: '" . $width . "',
                                            height: '" . $height . "',
                                            filebrowserBrowseUrl : '" . TEMPLATE_URL . "/admin/js/ckfinder/ckfinder.html',
                                            filebrowserImageBrowseUrl : '" . TEMPLATE_URL . "/admin/js/ckfinder/ckfinder.html?type=Images',
                                            filebrowserFlashBrowseUrl : '" . TEMPLATE_URL . "/admin/js/ckfinder/ckfinder.html?type=Flash',
                                            filebrowserUploadUrl : '" . TEMPLATE_URL . "/admin/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                                            filebrowserImageUploadUrl : '" . TEMPLATE_URL . "/admin/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                                            filebrowserFlashUploadUrl : '" . TEMPLATE_URL . "/admin/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
                                        });
				  CKFinder.setupCKEditor( editor, '../' );
		    
		    </script>";

        return $html;
    }
    */

}