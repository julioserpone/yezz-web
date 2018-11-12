<div class="alert alert_error">
	<?php translate('Your IP has been banned, please contact us to get more information.'); ?>
</div>

<input type="hidden" name="token" value="<?php echo generate_token('form'); ?>">

<label for="username"><?php translate('Name'); ?></label>
<input type="text" name="username" id="username" placeholder="<?php translate('Name'); ?> <?php translate('(Required)'); ?>">
<label for="email"><?php translate('Email'); ?></label>
<input type="text" name="email" id="email" placeholder="<?php translate('Email'); ?> <?php translate('(Required)'); ?>">
<label for="message"><?php translate('Message'); ?></label>
<textarea name="message" id="message" placeholder="<?php translate('Message'); ?> <?php translate('(Required)'); ?>"></textarea>
<p><button class="btn_default" type="button" id="send_email" style="background-color: <?php get_option('background_color_3'); ?>; color: <?php get_option('color_3'); ?>;"><?php translate('Send message'); ?></button></p>
