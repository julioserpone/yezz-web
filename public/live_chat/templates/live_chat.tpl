<div id="chat_wrapper">
	
	<div class="alert alert_info" id="invitation_message" style="display: none;">
		<a href="#" class="close">&times;</a>
		<a href="#" id="accept_invitation">&nbsp;</a>
	</div>
	
	<div id="chat_header" style="background-color: <?php get_option('background_color_1'); ?>; color: <?php get_option('color_1'); ?>;">
		<span class="pull_left">&nbsp;</span>
		<i class="icon_chevron_up pull_right arrow"></i>
		<div class="clearfix"></div>
	</div>
	
	<div id="chat_content" style="background-color: <?php get_option('background_color_2'); ?>; color: <?php get_option('color_2'); ?>;">
		
		<div class="loading">
			<div class="loading_opacity"></div>
			<div class="loading_image"><img src="<?php get_option('absolute_url'); ?>templates/images/loader.gif" alt="" /></div>
		</div>
		
		<form id="<?php echo $form_1; ?>"></form>
		<form id="<?php echo $form_2; ?>"></form>
		
	</div>

</div>
