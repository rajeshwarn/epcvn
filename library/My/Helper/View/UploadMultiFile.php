<?php
class Zend_View_Helper_UploadMultiFile {

	function uploadMultiFile($spanButtonPlaceholderId, $pathUpload, $params = null) {
		$params = json_encode($params);
		
		return "<script type=\"text/javascript\">
                    var swfu;
					window.onload = function () {
						swfu = new SWFUpload({
							// Backend Settings
							upload_url: '".$pathUpload."',
							post_params: '".$params."',
			
							// File Upload Settings
							file_size_limit : '2 MB',	// 2MB
							file_types : '*.*',
							file_types_description : 'All Files',
							file_upload_limit : '0',
			
							// Event Handler Settings - these functions as defined in Handlers.js
							//  The handlers are not part of SWFUpload but are part of my website and control how
							//  my website reacts to the SWFUpload events.
							file_queue_error_handler : fileQueueError,
							file_dialog_complete_handler : fileDialogComplete,
							upload_progress_handler : uploadProgress,
							upload_error_handler : uploadError,
							upload_success_handler : uploadSuccess,
							upload_complete_handler : uploadComplete,
			
							// Button Settings
							button_image_url : '/public/template/admin/js/swfupload/images/SmallSpyGlassWithTransperancy_17x18.png',
							button_placeholder_id : '".$spanButtonPlaceholderId."',
							button_width: 180,
							button_height: 18,
							button_text : '<span class=\"button\">Select Images <span class=\"buttonSmall\">(2 MB Max)</span></span>',
							button_text_style : '.button { font-family: Helvetica, Arial, sans-serif; font-size: 12pt; } .buttonSmall { font-size: 10pt; }',
							button_text_top_padding: 0,
							button_text_left_padding: 18,
							button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
							button_cursor: SWFUpload.CURSOR.HAND,
							
							// Flash Settings
							flash_url : '/public/template/admin/js/swfupload/swfupload.swf',
			
							custom_settings : {
								upload_target : 'divFileProgressContainer'
							},
							
							// Debug Settings
							debug: false
						});
					};
                    
                  </script>";
	}
}