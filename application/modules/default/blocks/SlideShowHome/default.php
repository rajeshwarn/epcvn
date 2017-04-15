<!-- <div id="slideShow">
	<img src="images/slide/slide1.jpg" width="1024" height="366" />
</div>
 -->
<div id="slideshow">
  <div id="wrapper">
    <div id="banner">
    	<div class="banner">
	      <div class="box_skitter box_skitter_large" style="float:left;">
          <ul>
      		<?php
      		
            foreach($slide as $item){
            	
				if(file_exists(PUBLIC_PATH.$item['image'])){
					echo '<li><a href="'.$item['website'].'"><img src="'.STATIC_URL.$item['image'].'" alt=""  width="1030" height="385"/></a><div class="label_text"><p>'.$item['title'.$ssLang->key].'</p><p class="slide-intro">'.$item['intro'.$ssLang->key].'</p></div></li>';
					//echo '<li><a href="'.$item['website'].'"><img src="'.STATIC_URL.$item['image'].'" alt=""  width="1030" height="385"/></a></li>';
				}
            }
            ?>
          </ul>
        </div>
	    </div>
    </div>
  </div>
  <div class="clearb"></div>
</div>