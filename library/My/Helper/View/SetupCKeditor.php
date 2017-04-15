<?php
class Zend_View_Helper_SetupCKEditor {

	function setupCKEditor($textareaId) {
		return "<script type=\"text/javascript\">
                    var editor = CKEDITOR.replace('" . $textareaId . "',
                                 {
                                     filebrowserBrowseUrl : '/public/template/admin/js/ckfinder/ckfinder.html',
                                     filebrowserImageBrowseUrl : '/public/template/admin/js/ckfinder/ckfinder.html?type=Images',
                                     filebrowserFlashBrowseUrl : '/public/template/admin/js/ckfinder/ckfinder.html?type=Flash',
                                     filebrowserUploadUrl : '/public/template/admin/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                                     filebrowserImageUploadUrl : '/public/template/admin/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                                     filebrowserFlashUploadUrl : '/public/template/admin/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
                                  });
                                  CKFinder.setupCKEditor( editor, '../' );
                    
                  </script>";
	}
}