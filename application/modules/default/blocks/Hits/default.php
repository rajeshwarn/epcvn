<div id="colleft-title4"><?php echo $translate->translate('VISITOR_HISTORY');?></div>

<div class='hits'>
	<p><?php echo $translate->translate('ONLINE')?>: <span><?php echo $online;?></span></p>
	<p><?php echo $translate->translate('TODAY')?>: <span><?php echo $hits['day']['tongcong'];?></span></p>
	<p><?php echo $translate->translate('WEEK')?>: <span><?php echo $hits['week']['tongcong'];?></span></p>
	<p><?php echo $translate->translate('MONTH')?>: <span><?php echo $hits['month']['tongcong'];?></span></p>
	<p><?php echo $translate->translate('TOTAL')?>: <span><?php echo $hits['total']['tongcong'];?></span></p>
	<p></p>
</div>