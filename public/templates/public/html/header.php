<?php echo $this->doctype() ?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
       	<?php echo $this->headTitle() ?>
       	<?php echo $this->headMeta() ?>
		<?php echo $this->headLink() ?>
		<?php echo $this->headScript() ?>
<script type="text/javascript">

var google_tag_params = {

local_id: 'REPLACE_WITH_VALUE',

local_pagetype: 'REPLACE_WITH_VALUE',

local_totalvalue: 'REPLACE_WITH_VALUE',

};

</script>

<script type="text/javascript">

/* <![CDATA[ */

var google_conversion_id = 995415630;

var google_custom_params = window.google_tag_params;

var google_remarketing_only = true;

/* ]]> */

</script>

<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">

</script>

<noscript>

<div style="display:inline;">

<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/

viewthroughconversion/995415630/?value=0&amp;guid=ON&amp;script=0"/>

</div>

</noscript>
    </head>
    <body id="minwidth-body">
   
        <div id="border-top" class="h_green">
            <div>
                <div>
                    <span class="version">Version 1.0 Alpha</span>
                    <span class="title" style="padding-left:20px">Seahog cms</span>
                </div>
            </div>
        </div>
        <div id="header-box">
            <div id="module-status">
                <span class="preview">
                    <a target="_blank" href="#">Preview</a>
                </span>
                <a href="#">
                    <span class="no-unread-messages">0</span>
                </a>
                <span class="loggedin-users">1</span>
                <span class="logout">
                    <a href="<?php echo $this->baseUrl('/default/public/logout');?>">Logout</a>
                </span>
            </div>
            <div id="module-menu">

                <!-- BEGIN: Menu -->
                <ul class="menuTiny" id="menuTiny">
                    <li><a href="#" class="menuTinyLink">Main</a>
                        <ul>
                            <li><a href="<?php echo $this->baseUrl('/default/index/index/');?>">Front End</a></li>
                            <li><a href="<?php echo $this->baseUrl('/default/admin/index/');?>">Back End</a></li>

                        </ul>
                    </li>
                    <li><a href="#" class="menuTinyLink">Member</a>
                        <ul>
                            <li><a href="<?php echo $this->baseUrl('/default/admin-group/index/');?>">Group manager</a></li>
                            <li><a href="<?php echo $this->baseUrl('/default/admin-user/index/');?>">User manager</a></li>
                            <li><a href="<?php echo $this->baseUrl('/default/admin-permission/index/');?>">Permission</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="menuTinyLink">Products</a>
                        <ul>
                            <li><a href="<?php echo $this->baseUrl('/shopping/admin-category/index/');?>">Category manager</a></li>
                            <li><a href="<?php echo $this->baseUrl('/shopping/admin-item/index/');?>">Product manager</a></li>
                            <li><a href="<?php echo $this->baseUrl('/shopping/admin-bill/index/');?>">Bill</a></li>
                        </ul>
                    </li>
                </ul>

                <script type="text/javascript">
                    var menu=new menu.dd("menu");
                    menu.init("menuTiny","menuTinyHover");
                </script><!-- END: Menu -->				




            </div>
            <div class="clr"></div>
        </div>