<div class="navigationleft">
	<div class="navigationright">
		<div class="navigation">
			<ul>
				<li><a href="/"><?php echo $translate->translate('HOME')?></a></li>
				<li><a href="/<?php echo $translate->translate('ALIAS_ABOUT_US')?>"><?php echo $translate->translate('ABOUT_US')?></a></li>
				<li><a href="/<?php echo $translate->translate('ALIAS_PRODUCT')?>"><?php echo $translate->translate('PRODUCT')?></a></li>
				<li><a href="/<?php echo $translate->translate('ALIAS_PROJECT')?>"><?php echo $translate->translate('PROJECT')?></a></li>
				<li><a href="/<?php echo $translate->translate('ALIAS_RECRUITMENT')?>"><?php echo $translate->translate('RECRUITMENT')?></a></li>
				<li><a href="/<?php echo $translate->translate('ALIAS_NEWS')?>"><?php echo $translate->translate('NEWS')?></a></li>
				<li><a href="/<?php echo $translate->translate('ALIAS_CONTACT')?>"><?php echo $translate->translate('CONTACT')?></a></li>
				<form action='/<?php echo $translate->translate('SEARCH_URL')?>' method='POST'>
					<div class='search'>
					<div class=" bg-btsearch">
						<input style='padding: 0;' type="image"
							src="<?php echo TEMPLATE_URL?>/public/images/bt-search.png" />
					</div>
					<div class="box-search">
						<input type='text' name='keyword'
							value="<?php echo isset($keyword)?$keyword:'';?>"
							placeholder='<?php echo $translate->translate('PLACEHOLDER_SEARCH')?>'>
					</div>
					</div>
				</form>
			</ul>
			
		</div>
	</div>
</div>