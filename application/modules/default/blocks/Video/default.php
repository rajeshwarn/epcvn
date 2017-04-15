<div id="colleft-title1">VIDEO</div>

<?php 
if($videos != null){
	foreach ($videos as $item){
		echo '<div style="margin-bottom:10px;padding: 0 5px;"><iframe width="233" height="169" src="//www.youtube.com/embed/'.$item['code'].'" frameborder="0" allowfullscreen=""></iframe></div>';
	}
}
?>
