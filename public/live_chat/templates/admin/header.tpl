<!DOCTYPE html>
<html>
	<head>
		
		<meta charset="<?php get_option('charset'); ?>">
		
		<title><?php get_option('site_title'); ?></title>

		<link href="<?php get_option('absolute_url'); ?>templates/admin/css/main.css" rel="stylesheet">
		<link href="<?php get_option('absolute_url'); ?>templates/admin/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php get_option('absolute_url'); ?>templates/admin/css/jquery.minicolors.css" rel="stylesheet">		

		<script src="<?php get_option('absolute_url'); ?>templates/admin/js/jquery.min.js"></script>
		<script src="<?php get_option('absolute_url'); ?>templates/admin/js/bootstrap.min.js"></script>

		<script src="<?php get_option('absolute_url'); ?>templates/admin/js/jquery.validate.min.js"></script>
		<script src="<?php get_option('absolute_url'); ?>templates/admin/js/jquery.minicolors.min.js"></script>
		
		<?php if (in_array(basename($_SERVER['PHP_SELF']), array('index.php')) && $authentication->logged_in()): ?>
			<script type="text/javascript">
				var console_interval = <?php echo get_option('console_interval', TRUE) * 1000; ?>;
			</script>
			<script src="<?php get_option('absolute_url'); ?>templates/admin/js/main.min.js"></script>
		<?php endif; ?>	
		
	</head>
	<body>
		
		<div class="navbar navbar-fixed-top">
			
			<div class="navbar-inner">
				
				<div class="container-fluid">

					<a class="brand" href="index.php"><?php get_option('site_title'); ?></a>

					<ul class="nav pull-right">
						<?php if (in_array(basename($_SERVER['PHP_SELF']), array('index.php')) && $authentication->logged_in()): ?>
							<li><a href="#" class="status"><span title="<?php translate('Change status to online/offline'); ?>"><?php translate('Loading...'); ?></span></a></li>
							<li><a href="#" class="sound"><i class="icon-volume-up"></i></a></li>
						<?php endif; ?>
						<?php if ($authentication->logged_in()): ?>
							<li><a><i class="icon-user"></i> <?php echo $chat->operator_get_full_name($session->get('user_id')); ?></a></li>
							<li><a href="?logout"><i class="icon-off"></i></a></li>
						<?php endif; ?>
					</ul>
					
				</div>
				
			</div>
			
		</div>
