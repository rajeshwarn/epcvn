<div class='partner'>
	<ul>
	<?php 
	foreach($partners as $item){
		echo '<li><div style="height:150px;"><a href="'.$item['website'].'"><img src="'.STATIC_URL . $item['logo'].'" width="209" height="125" /></a></div></li>';
	}
	?>
	</ul>
</div>