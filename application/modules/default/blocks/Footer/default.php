<div id="menufoot">
	<ul>
		<li><a href="/"><?php echo $translate->translate('HOME')?></a></li>
		<li><a href="<?php echo $translate->translate('ALIAS_ABOUT_US')?>"><?php echo $translate->translate('ABOUT_US')?></a></li>
		<li><a href="<?php echo $translate->translate('ALIAS_PRODUCT')?>"><?php echo $translate->translate('PRODUCT')?></a></li>
		<li><a href="<?php echo $translate->translate('ALIAS_PROJECT')?>"><?php echo $translate->translate('PROJECT')?></a></li>
		<li><a href="<?php echo $translate->translate('ALIAS_RECRUITMENT')?>"><?php echo $translate->translate('RECRUITMENT')?></a></li>
		<li><a href="<?php echo $translate->translate('ALIAS_NEWS')?>"><?php echo $translate->translate('NEWS')?></a></li>
		<li><a href="<?php echo $translate->translate('ALIAS_CONTACT')?>"><?php echo $translate->translate('CONTACT')?></a></li>
	</ul>

</div>
<div id='footer-left'>
<p>
	<?php echo $page['content'.$ssLang->key];?>
	<!-- 
	<span style='font-size:16px;font-weight:bold;color:#666'><?php //echo $config['company'.$ssLang->key]?></span></br>
	<?php //echo $translate->translate('ADDRESS')?>: <?php //echo $config['address'.$ssLang->key]?><br /> 
	<?php //echo $translate->translate('TELEPHONE')?>: <?php //echo $config['telephone']?> - Fax: <?php //echo $config['fax']?> -
	Hotline: <?php //echo $config['hotline']?> - Email: <?php //echo $config['email']?><br /> 
	Website được thiết kế và xây dựng bởi Facecom việt nam
	 -->
</p>
</div>
<div id='footer-right' class="addcol1 social" style="border: none;">
	<p>
		<a target='_blank' href='<?php echo $config['pageFacebook'];?>' rel="nofollow" title='Facebook'>
			<img src="<?php echo TEMPLATE_URL.'/public/images/f-icon.png';?>" width="33" height="33">&nbsp;
		</a>
		<a target='_blank' href='<?php echo $config['pageGoogle'];?>' rel="nofollow" title='Google+'>
			<img src="<?php echo TEMPLATE_URL.'/public/images/g-icon.png';?>" width="33" height="33">&nbsp;
		</a>
		<a target='_blank' href='<?php echo $config['pageTwitter'];?>' rel="nofollow" title='Twitter'>
			<img src="<?php echo TEMPLATE_URL.'/public/images/t-icon.png';?>" width="33" height="33">&nbsp;
		</a>				
		<a target='_blank' href='<?php echo $config['pageLinkein'];?>' rel="nofollow" >
			<img src="<?php echo TEMPLATE_URL.'/public/images/in-icon.png';?>" width="35" height="35">&nbsp;
		</a>
		
	</p>
</div>