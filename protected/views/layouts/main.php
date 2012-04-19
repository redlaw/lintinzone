<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container showgrid" id="page">

	<div id="header">
		<div id="logo" class="span-5">
			<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php">
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo.png">
			</a>
		</div>
		<div id="search" class="span-10">
			<input type="text" class="text" id="search_box" name="q" value="Search here">		
			<input id="button" type="button" value="Search">
		</div>
		<div id="user_panel" class="span-6 prepend-3 last">
			<?php
				if (Yii::app()->user->isGuest)
				{
					//echo CHtml::link('Login', 'user/login') . ' | ';
					//echo CHtml::link('Join LintinZone', 'user/registration');
					echo '<a href="' . Yii::app()->createAbsoluteUrl('user/login') . '" title="Login">Login</a> | ';
					echo '<a href="' . Yii::app()->createAbsoluteUrl('user/registration') . '" title="Join LintinZone">Join LintinZone</a>';
				}
				else
					echo '<a href="' . Yii::app()->createAbsoluteUrl('site/logout') . '" title="Logout">Logout (' . Yii::app()->user->name . ')</a>';
			?>
		</div>
	</div><!-- header -->
		
	<div class="span-24">
	<br>
	</div>
	<!-- Begin  main-->	
    <div class="span-24 ">	
    	<!-- Begin navigation -->	
        <div id="nav" class="span-5">          			
			<ul>
			OrderZone
				<li >
				<a href="login.html">All Orders</a>
				</li>
				<li>
				<a href="order.html">Your Orders</a>
				</li>
				<li>
				<a href="">Offers</a>
				</li>
			</ul>
							
			<ul>
			ShipZone
				<li >
				<a href="">All Trips</a>
				</li>
				<li>
				<a href="">Your Trips</a>
				</li>
				<li>
				<a href="">Requests</a>
				</li>
			</ul>
						
			<ul>
			Transactions
				<li>
				<a href="">All Transactions</a>
				</li>
				<li>
				<a href="">Ongoing</a>
				</li>
				<li>
				<a href="">Negotiating</a>
				</li>
			</ul>
        </div>
        <!-- End navigation -->
        
        <!-- Begin bread-content -->
        <div class="span-19 last">
		<?php echo $content; ?>
		</div>
		<!-- End bread-content -->
		
	</div>
	<!-- End main -->
	
	<!-- footer -->
	<div id="footer" class="span-24">
		<div id="lintinzone" class="span-10">
			Copyright &copy; 2011 - <?php echo date('Y'); ?> by LintinZone.
			All Rights Reserved.
		</div>
		<div id="footer-nav" class="span-4 prepend-10 last">
		<a href="about">About </a>|<a href="about"> Contact </a>|<a href="about"> Faq </a>
		</div>
	</div>	

	

</div><!-- page -->

</body>
</html>
