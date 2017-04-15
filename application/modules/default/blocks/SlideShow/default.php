<!-- <div id="banner-right">
	<img src="images/banner_12.jpg" width="742" height="165" />
</div> -->
<div  id="banner-right" class="banner">
	<div class="flexslider">
		<ul class="slides">
      		<?php
			foreach ( $slide as $item ) {
				echo '<li><a href="', $item ['website'], '" title="' . $item ['title'] . '" ><img src="' . STATIC_URL . $item ['image'] . '" alt="' . $item ['title'] . '" title="' . $item ['title'] . '" width="742" height="165"/></a></li>';
			}
			?>
          </ul>
	</div>
</div>