$(document).ready(function() {
	var $modal = $('#ajax-modal');
	
    // sort table
    var table = $('#tb_sort');
    $('#tb_sort .sort').each(function() {
        var th = $(this),
                thIndex = th.index(),
                data_type = th.attr('data-id'),
                inverse = false;

        th.click(function() {
            table.find('td').filter(function() {
                return $(this).index() === thIndex;
            }).sortElements(function(a, b) {
                var para1 = '';
                var para2 = '';

                if (data_type == 'int') {
                    para1 = parseInt($.text([a]));
                    para2 = parseInt($.text([b]));
                } else if (data_type == 'date') {
                    para1 = Date.parse($.text([a]));
                    para2 = Date.parse($.text([b]));
                } else {
                    para1 = $.text([a]);
                    para2 = $.text([b]);
                }

                return para1 > para2 ?
                        inverse ? -1 : 1
                        : inverse ? 1 : -1;
            }, function() {
                // parentNode is the element we want to move
                return this.parentNode;
            });
            inverse = !inverse;
            $('.asc, .desc').removeClass();
            if (inverse == true) {
                th.addClass('asc');
            } else {
                th.addClass('desc');
            }
        });
    });

    // check all checkboxes in table
    $('.checkall').click(function() {
        var parentTable = $(this).parents('table');
        var ch = parentTable.find('.checkbox');

        if ($(this).is(':checked')) {
            // check all rows in table
            ch.each(function() {
                this.checked = true;
            });
        } else {
            // uncheck all rows in table
            ch.each(function() {
                $(this).attr('checked', false);
            });
        }
    });


    /*
	 * insert doted into price
	 */
    $('.format-price').live('keyup', function(event) {
        // if ((event.keyCode >= 48 && event.keyCode <= 57) || event.keyCode ==
		// 8) {
        var price = commafy($(this).val());
        var html = '<span class="price_dot">'+price+'</span>';
        
        $(this).css('float','left');
        $(this).next().remove();
        $(this).after(html);
        // html.insertAfter($(this));
       
        /*
		 * }else{ event.preventDefault(); }
		 */
    });

    /**
	 * close popup message
	 */
    $('.toast-item-close').click(function() {
        $(".toast-container").animate({"opacity": 0}, 1500, function() {
            $(this).empty();
        });
        $("#fix-bg").hide();
    });

    /**
	 * count character input SEO
	 */
    $('.product-seo').each(function() {
        var input = '#' + this.id;
        var count = input + '_count';
        $(count).show();
        word_count(input, count);
        $(this).keyup(function() {
            word_count(input, count);
        });
    });

    /**
	 * get category child
	 */
    $('.categoryId').live('change', function() {
        var id = $(this).val();
        var thiss = $(this);

        $.get('/admin/category/ajax-get-category/id/' + id, function(data) {
            if (thiss.parent().next().length > 0) {
                thiss.parent().nextAll('.catChild').remove();
            }

            thiss.parent().after(data);
        });
        
       /* $.get('/admin/feature/ajax-get-category/categoryId/' + id, function(data) {            
            $('#sl_featureCategory').html(data);            
        });*/
    });
    
    $('.categoryIdProduct').live('change', function() {
        var id = $(this).val();
        var thiss = $(this);

        $.get('/admin/category/ajax-get-category-product/id/' + id, function(data) {
            if (thiss.parent().next().length > 0) {
                thiss.parent().nextAll('.catChild').remove();
            }

            thiss.parent().after(data);
        });
        
       /* $.get('/admin/feature-detail/ajax-get-feature-detail/data/' + id, function(data) {            
            $('#featureDetail').html(data);            
        });*/
    });

    /*
	 * hover thumb image when upload
	 */
    $(".result-img").live('hover', function(e) {    	
        if (e.type == 'mouseenter') {
            $(this).find('.close-img').show();
        }

        if (e.type == 'mouseleave') {
            $(this).find('.close-img').hide();
        }
    });
    
    /**
	 * row update
	 */
    $('.row-update').live('click', function(){  
    	$(this).removeClass('row-update');
    	$(this).attr('data-original-title', 'Lưu');
    	$(this).find('i').removeClass();
    	$(this).find('i').addClass('icon-save');
    	$(this).addClass('row-save-update');
    	
    	var item = $(this).parent().parent().parent();
    	var id = $(this).attr('data-id');
    	var obj = $(item).find('.input-update');
    	$(item).addClass('rowNew');
    	
    	$(obj).each(function(index, item ) {
    		var name = $.trim($(item).attr('data-name'));
    		var classs = $.trim($(item).attr('data-class'));    		
    		var value = $.trim($(item).text());
    		var html = "<input type='text' id='" + name + "' data-id='" + id + "' class='" + classs + "' value='" + value + "' style='width:80%;'>";
    		$(item).html(html);
		});
    });
    
    /**
     * datetime picker
     */
    $( ".datepicker" ).datepicker({
	    dateFormat:"yyyy-mm-dd",
	    defaultDate: 'y',
	    showButtonPanel: true,
	    changeMonth: true,
	    changeYear: true
	});

	$( "#ftCreateFrom" ).datepicker({
	    defaultDate: "+1w",
	    dateFormat:"dd-mm-yy",
	    defaultDate: 'y',
	    showButtonPanel: true,
	    changeMonth: true,
	    changeYear: true,
	    onClose: function( selectedDate ) {
	        $( "#ftCreateTo" ).datepicker( "option", "minDate", selectedDate );
	    }
	});
	$( "#ftCreateTo" ).datepicker({
	    defaultDate: "+1w",
	    dateFormat:"dd-mm-yy",
	    defaultDate: 'y',
	    showButtonPanel: true,
	    changeMonth: true,
	    changeYear: true,
	    onClose: function( selectedDate ) {
	        $( "#ftCreateFrom" ).datepicker( "option", "maxDate", selectedDate );
	    }
	});
	
	$( "#ftModifiedFrom" ).datepicker({
	    defaultDate: "+1w",
	    dateFormat:"dd-mm-yy",
	    defaultDate: 'y',
	    showButtonPanel: true,
	    changeMonth: true,
	    changeYear: true,
	    onClose: function( selectedDate ) {
	        $( "#ftModifiedTo" ).datepicker( "option", "minDate", selectedDate );
	    }
	});
	$( "#ftModifiedTo" ).datepicker({
	    defaultDate: "+1w",
	    dateFormat:"dd-mm-yy",
	    defaultDate: 'y',
	    showButtonPanel: true,
	    changeMonth: true,
	    changeYear: true,
	    onClose: function( selectedDate ) {
	        $( "#ftModifiedFrom" ).datepicker( "option", "maxDate", selectedDate );
	    }
	});
    
    /**
	 * delete row new
	 *  $('.delete-row').live('click', function(event){  
    	var element = $(this).parent().parent().parent();		 
    	$(element).animate({"opacity":0}, 500, function(){ $(element).remove(); }) 
    });
	 */
   
    
    /**
     * filter feature detail $('#ftTitleVi, #ftTitleEn, ')
     */          
    
    /*
     * close alert message
     */
    $('.alert .close').live('click', function() {
        $(this).parents('#alert-message').fadeOut();
        $(this).parent('.alert').fadeOut();
    });    
    
    /**
     * colorpicker
     */
    $('.color-picker').colorpicker({
        format: 'hex'
    });
    
    /**
     * created input file 
     */
    $('.add-image').live('click', function(){
    	var id = $(this).val();
    	var name = $(this).attr('data-name');
    	var html = '';
    	
    	if($(this).is(':checked')){
    		if($('#image-attr').is(':empty')){
    			html = "<table class='image-attr'>"+
					   "<thead><tr>" +
					   		"<th>Tên thuộc tính</th>" +
					   		"<th style='position:relative'>Hình ảnh<i class='clip-close-4'></i></th>"+
				   		"</tr></thead>";
    		}
			
			html += "<tr id='item-" + id + "'>"+
			   			"<td>"+name+"</td>"+
			   			"<td>" +
			   			"<div class='fileupload fileupload-new' data-provides='fileupload'>"+
						"<input type='hidden' value='' name=''>"+
						"<div class='fileupload-new thumbnail no-image' style='width: 150px; height: 120px;'>"+
							"<div class='fileupload-image'><i class='clip-image'></i></div>"+
						"</div>"+
						"<div class='fileupload-preview fileupload-exists thumbnail' style='max-width: 150px; max-height: 120px; line-height: 10px;'></div>"+
						"<div>"+
								"<span class='btn btn-light-grey btn-file'><span class='fileupload-new'><i class='icon-picture'></i> Select image</span><span class='fileupload-exists'><i class='icon-picture'></i> Change</span>"+
									"<input type='file' name='images[]'/>"+
								"</span>"+
								"<a href='#' class='btn fileupload-exists btn-light-grey' data-dismiss='fileupload'>"+
									"<i class='icon-remove'></i> Remove"+
								"</a>"+
							"</div>"+
						"</div>"+
			   			"</td>"+
			   		"</tr>";
			
			if($('#image-attr').is(':empty')){
				html += "</table>";
				$('#image-attr').append(html);
			}else{
				$('#image-attr tbody').append(html);
			}
			var arrParams = {};
			arrParams['dir'] = 'product';
			arrParams['thumb'] = true;
			
			//arrParams = {"dir":"product", "thumb":"true"};
	    	//upload('spanButtonPlaceholder-'+id, 'divFileProgressContainer-'+id, 'thumbnail-'+id, '/admin/upload', arrParams);
    	}else{
    		$('#item-' + id).remove();
    	}
    });
    
    /**
     * icon close category select 
     */
	
	$('.close-cat').live('click', function(){
		$(this).parent().fadeOut().remove();
		// $(this).next().fadeOut().remove();
	});
	
	/**
	 * Select with Search
	 */
	jQuery(".chzn-select").chosen();
	
	/**
	 * add class radio-inline in label radio
	 */
	jQuery('.grey').parent().addClass('radio-inline');
	jQuery('.grey').parent().parent().attr('style','display: inline-flex');
	
	/**
	 * click add-category chose many category
	 */
	jQuery('.add-category').click(function(){
		var categoryPath = $(this).attr('data-value');
		
		jQuery.ajax({
			type: "POST",
			data: ({categoryPath: categoryPath}),
			url: '/admin/category/ajax-get-all-category/',
			beforeSend: function() {
				$('body').modalmanager('loading');	
			},
			success: function(data) {	        		 				
				$modal.html(data);
                $modal.modal();
			}
		});
	});
	
	/**
	 * expanded-group click
	 */
	jQuery('.expanded-group').live('click', function(){
		var dataGroup = $(this).attr('data-group');
		$(this).nextAll('.'+dataGroup).css('display','none');
		$(this).find('i').removeClass().addClass('icon-caret-right');		
		$(this).addClass('collapsed-group').removeClass('expanded-group');		
	});
	
	jQuery('.collapsed-group').live('click', function(){
		var dataGroup = $(this).attr('data-group');
		$(this).nextAll('.'+dataGroup).css('display','table-row');
		$(this).find('i').removeClass().addClass('icon-caret-down');		
		$(this).addClass('expanded-group').removeClass('collapsed-group');			
	});
	
	/**
	 * add-feature-detail 
	 */
	$('.add-feature-detail').live('click', function(){
		var featureId = $(this).attr('data-id');
		var categoryPath = $(this).attr('data-category-path');
		
		jQuery.ajax({
			type: "GET",
			data: ({categoryPath: categoryPath, featureId: featureId}),
			url: '/admin/feature-detail/add/',
			beforeSend: function() {
				$('body').modalmanager('loading');	
			},
			success: function(data) {	        		 				
				$modal.html(data);
				$modal.modal();
			}
		});
	});
	
	/**
	 * update-feature-detail 
	 */
	$('.update-feature-detail').live('click', function(){
		var id = $(this).attr('data-id');
		var categoryPath = $(this).attr('data-category-path');
		
		jQuery.ajax({
			type: "GET",
			data: ({categoryPath: categoryPath, id: id}),
			url: '/admin/feature-detail/edit/'+id,
			beforeSend: function() {
				$('body').modalmanager('loading');	
			},
			success: function(data) {	        		 				
				$modal.html(data);
				$modal.modal();
			}
		});
	});
	
	/**
	 * option 
	 */
	$('.feature-checkbox').live('click', function(){
		
		if($(this).is(':checked'))
		    $(this).parent().parent().next(".fade-in").slideDown(); 
		else
			$(this).parent().parent().next(".fade-in").slideUp();
		
	});
	
	//removeArticle
	$('#removeArticle').live('click', function(){
		var id = $(this).attr('data-id');
		var $this = $(this);
		jQuery.ajax({
			type: "POST",
			data: ({id: id}),
			url: '/admin/article/ajax-delete-article/id/'+id,
			beforeSend: function() {
				//$('body').modalmanager('loading');	
			},
			success: function(data) {	        		 				
				var res = jQuery.parseJSON(data);
				//alert(res.result);
				if(res.result == 1){
					$this.parent().parent().parent().remove();
				}
			}
		});
	});
	
	// fillter category article
	/*$("#fCategoryId").change(function(){
		var id = $(this).val();
		window.location.href = "categoryId/" + id + "/";
	});
	// fillter status article
	$("#fStatus").change(function(){
		var status = $(this).val();
		window.location.href ="status/"+status + "/";
	});
	*/
});


