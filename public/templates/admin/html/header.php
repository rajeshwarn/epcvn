<div class="container">
	<div class="navbar-header">
		<!-- start: RESPONSIVE MENU TOGGLER -->
		<button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
			<span class="clip-list-2"></span>
		</button>
		<!-- end: RESPONSIVE MENU TOGGLER -->
		<!-- start: LOGO -->
		<a class="navbar-brand" href="index.html"> 
		</a>
		<!-- end: LOGO -->
	</div>
	<div class="navbar-tools">
		<!-- start: TOP NAVIGATION MENU -->
		<?php
			$auth = Zend_Auth::getInstance();
			if ($auth->hasIdentity()):
			    $dataAuth = $auth->getIdentity();
		?>
		<ul class="nav navbar-right">
			<!-- start: USER DROPDOWN -->
			<li class="dropdown current-user"><a data-toggle="dropdown" class="dropdown-toggle" href="#"> <img src="<?php echo TEMPLATE_URL;?>/admin/images/avatar-1-small.jpg" class="circle-img" alt=""> <span class="username"><?php echo ucfirst($dataAuth['username']); ?></span> <i class="clip-chevron-down"></i>
			</a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo $this->url(array('controller' => 'user', 'action' => 'logout')); ?>"> <i class="clip-exit"></i> &nbsp;Log Out
					</a></li>
				</ul></li>
			<!-- end: USER DROPDOWN -->
		</ul>
		<?php endif; ?>
		<!-- end: TOP NAVIGATION MENU -->
	</div>
</div>