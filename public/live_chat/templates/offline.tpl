<p><?php translate('At this moment there are no logged members, but you can leave your messages.'); ?></p>

<input type="hidden" name="token" value="<?php echo generate_token('form'); ?>">

<label for="username"><?php translate('Name'); ?></label>
<input type="text" name="username" id="username" placeholder="<?php translate('Name'); ?> <?php translate('(Required)'); ?>">
<label for="email"><?php translate('Email'); ?></label>
<input type="text" name="email" id="email" placeholder="<?php translate('Email'); ?> <?php translate('(Required)'); ?>">
<label for="department_id"><?php translate('Department'); ?></label>
<select name="department_id" id ="department_id">
	<?php foreach ($departments as $value): ?>
		<option value="<?php echo $value['department_id']; ?>"><?php echo $value['department_name']; ?> - <?php translate('(Offline)'); ?></option>
	<?php endforeach; ?>
</select>
<label for="message"><?php translate('Message'); ?></label>
<textarea name="message" id="message" placeholder="<?php translate('Message'); ?> <?php translate('(Required)'); ?>"></textarea>
<p><button class="btn_default" type="button" id="send_email" style="background-color: <?php get_option('background_color_3'); ?>; color: <?php get_option('color_3'); ?>;"><?php translate('Send message'); ?></button></p>
