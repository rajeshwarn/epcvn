<div id="colleft-title3"><?php echo $translate->translate('SUPPORT_ONLINE');?></div>
<div style='padding: 0 10px;' id='support'>
	<?php 
	$i = 1;
	foreach($supports as $item){
		$html='';
		if($item['regency'.$ssLang->key] != '')
			$html .= '<p style="font-size:14px;color:#666"><strong>'.$item['regency'.$ssLang->key].'</strong></p>';
		
		if($item['mobile'] != '')
			$html .= '<p><label>Tel: </label><span>'.$item['mobile'].'</p>';
		
		if($item['fax'] != '')
			$html .= '<p><label>Fax: </label><span>'.$item['fax'].'</p>';
		
		if($item['email'] != '')
			$html .= '<p><label>Email: </label><span>'.$item['email'].'</p>';
		
		if($item['skype'] != '')
			$html .= '<p><label>Skype: </label><span><a style="padding:0;" href="skype:'.$item['skype'].'?chat" rel="nofollow"><img style="margin-top:-5px" src="http://mystatus.skype.com/smallclassic/'.$item['skype'].'" style="border: none;"></a>&nbsp;</p>';
		if($item['yahoo'] != '')
			$html .= '<p><label>Yahoo: </label><a style="padding:0;" href="ymsgr:sendIM?'.$item['yahoo'].'"><img  style="margin-top:-5px" border="0" src="http://mail.opi.yahoo.com/online?u='.$item['yahoo'].'&amp;m=g&amp;t=2"></a></p>';
		
		
		if($item['hotline'] == 1){
			if($i == count($supports))
				$html .= '<p class="lasted">';
			else
				$html .= '<p>';
		
			if($item['name'.$ssLang->key] != '')
				$html .= '<strong style="color: #FF0000;">HOTLINE: '.$item['mobile'].' </strong> - '.$item['name'.$ssLang->key];
			else
				$html .= '<strong style="color: #FF0000;">HOTLINE: '.$item['mobile'].'</strong>';
		
			$html .= '</p>';
			$i++;
		}
		echo $html;
	}
	?>
</div>

