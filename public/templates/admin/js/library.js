function standardURL(elementSource, elementDes){
	$(elementSource).change(function() {
	    var value = $(this).val();
	
	    str = value.toLowerCase();
	    str = str.replace(/[àáạảãâầấậẩẫăằắặẳẵ]/g, 'a');
	
	    str = str.replace(/[èéẹẻẽêềếệểễ]/g, "e");
	    str = str.replace(/[ìíịỉĩ]/g, "i");
	    str = str.replace(/[òóọỏõôồốộổỗơờớợởỡ]/g, "o");
	    str = str.replace(/[ùúụủũưừứựửữ]/g, "u");
	    str = str.replace(/[ỳýỵỷỹ]/g, "y");
	    str = str.replace(/đ/g, "d");
	    str = str.replace(/[!@%^*()+=<>?/,.:;&#[]~$_]/g, "-");
	    str = str.replace(/[\\\'\"\\,\. ]/g, "-");
	    /* tìm và thay thế các kí tự đặc biệt trong chuỗi sang kí tự - */
	    str = str.replace(/-+-/g, "-"); // thay thế 2- thành 1-
	    str = str.replace(/^\-+|\-+$/g, "");
	    $(elementDes).val(str);
	});
}

/*
 * update value when change element input  
 */
function updateElementChange(element, url, field){
	$(element).live('change', function() {
	    var id = $(this).attr('data-id');
	    var value = $(this).val();
	    var $this = $(this);
	    var html = '<img src="../../public/templates/admin/images/loading.gif"/>';
	
	    $.ajax({
	        type: "POST",
	        url: url,
	        data: ({field: field, value: value, id: id}),
	        beforeSend: function() {
	        	$(html).insertAfter($this);
	        },
	        success: function(string) {	        		        	
	            setTimeout(function() {
	            	$this.next('img').remove();		        	
	            }, 800);	           
	        }
	    });
	});
}

/**
 * update status 
 */	
function updateStatusClick(element, url, field){
	$(element).live('click', function() {
	    var id = $(this).attr('data-id');
	    var value = $(this). attr('data-value');
	    var thiss = $(this);
	
	    $.ajax({
	        type: "POST",
	        url: url,
	        data: ({field: field, value: value, id: id}),
	        beforeSend: function() {
	            $("#updateProgress").show();
	        },
	        success: function(data) {
	            var reponse = jQuery.parseJSON(data);
	            var html = '';
	
	            setTimeout(function() {
	                $("#updateProgress").hide();
	            }, 800);
	
	            
                if (reponse.value == 1) {
                	thiss.removeClass('label-danger');
                	thiss.addClass('label-success');
                	thiss. attr('data-value', 0);
                	thiss.text('Hiện');
                	//html += '<span class="label label-sm label-success status" data-id="' + id +'" data-value="0">Hiện</span>';	                    
                } else {
                	thiss.removeClass('label-success');
                	thiss.addClass('label-danger');
                	thiss. attr('data-value', 1);
                	thiss.text('Ẩn');
                	//html += '<span class="label label-sm label-danger status" data-id="' + id +'" data-value="1">Ẩn</span>';
                }
	           
	        }
	    });
	});
}

/*
 * delete value when click element input  
 */
function removeElementClick(element, url, action){
	$(element).live('click', function() {        
        if (confirm('Bạn có muốn xóa mục này?')) {
        	if(action == 'REMOVE_ROW'){
	        	var id = $(this).attr('data-id');
	
	            $.ajax({
	                type: "POST",
	                url: url,
	                data: ({data: id, actionName : action}),
	                success: function(data) {
	                    var reponse = jQuery.parseJSON(data);
	
	                    if (reponse.result == 1) {
	                        $('#item-' + id).slideUp();
	                        $('#item-' + id).empty();
	                    } else {
	                        $('body').append(reponse.value);
	                    }
	                }
	            });
        	}else if(action == 'REMOVE_SELECT'){
        		var element = $(this).parent().next('.table').find('.checkbox');
        		var data = new Array();

                $(element).each(function(){
                	if($(this).is(':checked')){
                		data.push($(this).attr('data-id'));
                	}
                });
                
                $.ajax({
	                type: "POST",
	                url: url,
	                data: ({data: data, actionName : action}),
	                success: function(data) {
	                    var reponse = jQuery.parseJSON(data);
	
	                    if (reponse.result == 1) {
	                    	var arrId = reponse.value;
	                    	$.each(arrId, function(index, value) {
	                    		$('#item-' + value).slideUp();
		                        $('#item-' + value).empty(); 
                    		});	                        
	                    } else {
	                        $('body').append(reponse.value);
	                    }
	                }
	            });        		
        	}else if(action == 'REMOVE_ALL'){
        		$.ajax({
	                type: "POST",
	                url: url,
	                data: ({actionName : action}),
	                success: function(data) {
	                	alert($(this).parent().parent().find('.table').attr('data-id'));
	                	$(this).parent().next().find('tbody').slideUp();
	                	$(this).parent().next().find('tbody').empty();
	                }
	            });
        	}
        }
    });
}

/*
 * delete all when click
 */
function removeAllClick(element, url){
	$(element).live('click', function() {
        if (confirm('Bạn có muốn xóa mục này?')) {
            $.ajax({
                type: "POST",
                url: url,
                success: function(data) {
                	var el = $(this).parent().next('.row').find('.panel');
                	alert(el.text());
                	el.block({
                        overlayCSS: {
                            backgroundColor: '#fff'
                        },
                        message: '<img src="../../public/templates/admin/images/loading.gif" /> Please wait...',
                        css: {
                            border: 'none',
                            color: '#333',
                            background: 'none'
                        }
                    });
                    window.setTimeout(function () {
                        el.unblock();
                    }, 1000);
                    
                }
            });
        }
    });
}

//add comman integer
function commafy(num) {
    var str = num.toString().split('.');
    if (str[0].length >= 4) {
        str[0] = str[0].replace(/(\d)(?=(\d{3})+$)/g, '$1,');
    }
    if (str[1] && str[1].length >= 4) {
        str[1] = str[1].replace(/(\d{3})/g, '$1 ');
    }
    return str.join('.');
}

function word_count(field, count) {
    var text = $.trim($(field).val());
    var wordcount = 0;
    if (text.length > 0)
        wordcount = text.split(" ").length;
    $(count).html('<b>' + wordcount + '</b> từ - <b>' + $(field).val().length + '</b> ký tự.');
}

function upload(element, divFileProgress, divThumbnail, uploadURL, params){
	var swfu;
	//window.onload = function () {
		swfu = new SWFUpload({
			// Backend Settings
			upload_url: uploadURL,
			post_params: params,
			file_post_name: "Filedata",
			requeue_on_error: false,
			http_success : [123, 444],
			
			// File Upload Settings
			file_size_limit : "5 MB",	// 2MB
			file_types : "*.*",
			file_types_description : "All Files",
			file_upload_limit : "0",
			
	
			// Event Handler Settings - these functions as defined in Handlers.js
			//  The handlers are not part of SWFUpload but are part of my website and control how
			//  my website reacts to the SWFUpload events.
			file_queued_handler : fileQueued,			
			file_queue_error_handler : fileQueueError,
			file_dialog_complete_handler : fileDialogComplete,
			upload_progress_handler : uploadProgress,
			upload_error_handler : uploadError,
			upload_success_handler : uploadSuccess,
			upload_complete_handler : uploadComplete,
			
			// Button Settings
			//button_image_url : "/public/templates/admin/js/plugins/swfupload/images/SmallSpyGlassWithTransperancy_17x18.png",
			button_placeholder_id : element,
			button_width: 130,
			button_height: 20,
			button_text : '<span class="button">Chọn hình <span class="buttonSmall">(5 MB Max)</span></span>',
			button_text_style : '.button { font-family: Helvetica, Arial, sans-serif; font-size: 12pt; } .buttonSmall { font-size: 10pt; }',
			button_text_top_padding: 5,
			button_text_left_padding: 5,
			button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
			button_cursor: SWFUpload.CURSOR.HAND,
			
			// Flash Settings
			flash_url : "/public/templates/admin/js/plugins/swfupload/swfupload.swf",
	
			custom_settings : {
				upload_target : divFileProgress,
				thumbnail_target: divThumbnail,
			},
			
			// Debug Settings
			debug: false
		});
	//};
}

function removeImage(element){
	var id = $(element).attr('data-id');

	$.ajax({
		type: "POST",
		url: "/admin/upload/ajax-delete",
		data: ({id : id}),
		success: function(data){
			
			if(data){
				$(element).parent('.result-img').fadeOut("slow", function(){ $(element).parent('.result-img').remove(); });
			}
		}
	});
}
/**
 * search filter ajax
 
function filter(element){	
	var trFilter = $(element).parent().parent();
	var obj = $(item).find('.input-filter');
	var data = [];
	
	$(obj).each(function(index, item ) {
		var key = $(item).attr('data-name');
		var value = $(item).val();
		
		data[key] = value;
		
		$.ajax({
	        type: "POST",
	        url: "/admin/feature-detail/ajax-search/",
	        data: ({data: data}),
	        beforeSend: function() {
	            $("#updateProgress").show();
	        },
	        success: function(data) {
	        	trFilter.nextAll().remove();
	        }
	    });
	}
}*/
