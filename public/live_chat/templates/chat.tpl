<div id="chat_messages">
	
	<input type="hidden" name="token" value="<?php echo generate_token('form'); ?>">
	
	<div class="queue">
		<span><?php translate('Thank you for contacting us, an operator will be with you shortly.'); ?></span>
	</div>
	
	<div class="messages">
		<div class="message_content">
		</div>
	</div>
	
	<div class="chat_options pull_left">
		<a href="#" class="chat_sound"><i class="icon_volume_up"></i></a>
	</div>
	
	<div class="operator_typing pull_right">
		<span><?php translate('Operator is typing now...'); ?></span>
	</div>
	<div class="clearfix"></div>
	
	<textarea id="message" name="message"></textarea>
	<p>
		<button class="btn_default" type="button" id="send_message" style="background-color: <?php get_option('background_color_3'); ?>; color: <?php get_option('color_3'); ?>;"><?php translate('Send'); ?></button>
		<button class="btn_default" type="button" id="stop_chat" style="background-color: <?php get_option('background_color_3'); ?>; color: <?php get_option('color_3'); ?>;"><?php translate('Close chat'); ?></button>
	</p>
	
</div>
