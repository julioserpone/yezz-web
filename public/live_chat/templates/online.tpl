<p><?php translate('Thanks for contacting us! Please fill out the form below and representative will be with you shortly.'); ?></p>

<input type="hidden" name="token" value="<?php echo generate_token('form'); ?>">

<label for="username"><?php translate('Name'); ?></label>
<input type="text" name="username" id="username" placeholder="<?php translate('Name'); ?> <?php translate('(Required)'); ?>">
<label for="email"><?php translate('Email'); ?></label>
<input type="text" name="email" id="email" placeholder="<?php translate('Email'); ?> <?php translate('(Required)'); ?>">
<label for="department_id"><?php translate('Department'); ?></label>
<select name="department_id" id ="department_id">
	<?php foreach ($departments as $value): ?>
		<?php if ($value['total'] > $value['online_timeout']): ?>
			<option value="<?php echo $value['department_id']; ?>"><?php echo $value['department_name']; ?> - <?php translate('(Offline)'); ?></option>
		<?php else: ?>
			<option value="<?php echo $value['department_id']; ?>"><?php echo $value['department_name']; ?></option>
		<?php endif; ?>
	<?php endforeach; ?>
</select>
<label for="message"><?php translate('Message'); ?></label>
<textarea name="message" id="message" placeholder="<?php translate('Message'); ?> <?php translate('(Required)'); ?>"></textarea>
<p><button class="btn_default" type="button" id="start_chat" style="background-color: <?php get_option('background_color_3'); ?>; color: <?php get_option('color_3'); ?>;"><?php translate('Start chat'); ?></button></p>
