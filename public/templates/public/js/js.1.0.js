$(document).ready(function() {

    //Tooltips
    $(".frameproduct, .frameproduct2").hover(function(){
        tip = $(this).nextAll('.tooltip');
        tip.show(); //Show tooltip
    }, function() {
        tip.hide(); //Hide tooltip
    }).mousemove(function(e) {
        //Change these numbers to move the tooltip offset
        var mousex = e.pageX + 20; //Get X coodrinates
        var mousey = e.pageY + 20; //Get Y coordinates.
        var tipWidth = tip.width(); //Find width of tooltip
        var tipHeight = tip.height(); //Find height of tooltip

        //Distance of element from the right edge of viewport
        var tipVisX = $(window).width() - (mousex + tipWidth);
        //Distance of element from the bottom of viewport
        var tipVisY = $(document).scrollTop() + $(window).height() - (mousey + tipHeight);
         //alert($(document).scrollTop());
        if (tipVisX < 10) { //If tooltip exceeds the X coordinate of viewport
            mousex = e.pageX - tipWidth - 10;
        } if (tipVisY <  10) { //If tooltip exceeds the Y coordinate of viewport
            mousey = e.pageY - tipHeight - 10;

        }
        //Absolute position the tooltip according to mouse position
        tip.css({  top: mousey, left: mousex });
    });
     /*
    // submenu
    $('.menuleft .open').parents('ul').css({display:'block'});
    $('.menuleft .open').find('ul:first').css({display:'block'});
    $('.menuleft .open a:first').css({'color':'#FF9854', 'font-weight':'bold'});
   */

    var url = window.location.href;
    $('.navigation li a[href="'+url+'"]').parents('li').addClass('active');
    $('.menuleft li a[href="'+url+'"]').parents('li').addClass('active');

    $('.menuleft li:last-child').addClass('lasted');

    $( "#menu ul" ).each(function( index ) {
      if($(this).is(':empty')){
        $(this).remove();
      }
    });

    $( ".menuleft li, .menuleft ul li").hover(function(){
      $(this).find('ul:first').css({'visibility': 'visible'});
    }, function(){
      $(this).find('ul').css({'visibility': 'hidden'});
    });
   
    /**
    // submenu
    $('.menuleft li').hover(function(){
      var ele = $(this).find('ul:first');

      if(ele.is(":empty") == false){
        $(this).find('ul:first').stop(true, true).slideDown();
      }
    }, function(){
      $(this).find('ul').stop(true, true).slideUp();
    });
    */

    //scroll button
    $(window).scroll(function () {
			if ($(this).scrollTop() > 10) {
				$('#topcontrol').fadeIn();
			} else {
				$('#topcontrol').fadeOut();
			}
		});

    $('#topcontrol').click(function(){
      $('html,body').animate( { scrollTop: 0 }, 'slow' );
    });

    // anwer click
    $('#step-next').click(function(){
      if($(this).hasClass('active')){
        $('.info-customer').slideUp();
        $(this).removeClass('active');
      }else{
        $('.info-customer').slideDown();
        $(this).addClass('active');
      }
      return false;
    });

     // support click
    $('#title-support').click(function(){
      if($(this).hasClass('active')){
        $('#content-support').slideUp('fast');
        $(this).removeClass('active');
      }else{
        $('#content-support').slideDown('fast');
        $(this).addClass('active');
      }
      return false;
    });

    //scroll button
    $(window).scroll(function () {
			if ($(this).scrollTop() > 10) {
				$('#topcontrol').fadeIn();
			} else {
				$('#topcontrol').fadeOut();
			}
		});

    $('#topcontrol').click(function(){
      $('html,body').animate( { scrollTop: 0 }, 'slow' );
    });


    //slideshow
    /*
    $('#slider').nivoSlider({
            effect:"fold,fade,sliceUpLeft",
            controlNav:false
        });
    */

    jQuery('.box_skitter_large').skitter({
    	numbers: false,
      //numbers_align:false,
      interval: 3000,
      preview: false,
      velocity: 2,
      animation: "random",
      label: true,
      theme: 'clean',
      dots: false,
      labelAnimation: 'left'
    });
    
    jQuery('.flexslider').flexslider({
        animation: "slide",
        controlNav: false,
        directionNav: true,
        slideToStart: 0,
        animationDuration: 0,
        start: function(slider){
          jQuery('body').removeClass('loading');
        }
      });

   /* jQuery('#mycarousel').jcarousel({
    	wrap: 'circular',
    	auto: 8,
    	scroll: 1
    });*/

    /*$("a#single_image").fancybox({
  		'transitionIn'	:	'elastic',
  		'transitionOut'	:	'elastic',
  		'speedIn'		:	600,
  		'speedOut'		:	200,
  		'overlayShow'	:	false
  	});*/

    $('#sl_HotHome').cycle({ 
    	fx: 'fade',
        speed: 'slow', 
        timeout: 2500, 
        pager: '', 
        slideExpr: '#item_HotHome',
        pause: 1
    });
    
	$(".jcarousel").jCarouselLite({
		btnNext: ".next",
        btnPrev: ".prev",
		 mouseWheel: true,
		 visible: 4
	});
   
	$(".event").jCarouselLite({  // Lấy class của ul và gọi hàm jCarouselLite() trong thư viện
		vertical: true,				// chạy theo chiều dọc
		hoverPause:true,			// Hover vào nó sẽ dừng lại
		visible: 3,					// Số bài viết cần hiện
		auto:1000,					// Tự động scroll
		speed:1000					// Tốc độ scroll
	});			

	$(".partner").jCarouselLite({  // Lấy class của ul và gọi hàm jCarouselLite() trong thư viện
		vertical: true,				// chạy theo chiều dọc
		hoverPause:true,			// Hover vào nó sẽ dừng lại
		visible: 3,					// Số bài viết cần hiện
		auto:3000,					// Tự động scroll
		speed:1000					// Tốc độ scroll
	});	
	// close alert
	$('.alert .close').live('click', function() {
        $(this).parents('#alert-message').fadeOut();
        $(this).parent('.alert').fadeOut();
    });
	
	$("#add-newsletter").click(function(){
        var $this = $(this).parent();
        var email = $this.find('#new-letter').val();
        reg1=/^[0-9A-Za-z]+[0-9A-Za-z_]*@[\w\d.]+.\w{2,4}$/;
	    testmail=reg1.test(email);

        if(email == ''){
          alert('Email not empty');
        }else if(!testmail){
          alert('Invalid Email');
        }else{
          $.ajax({
            type: 'POST',
            url: '/index/news-letter',
            data: ({email:email}),
            success: function(data){
             // if(data == true || data > 0){

                var html = "<p style='color: #fff;font-weight: bold;margin-top: 20px;'>Thank you for signing up</p>";
                $this.html(html);
              //}
            }
          });
        }
    });
});
