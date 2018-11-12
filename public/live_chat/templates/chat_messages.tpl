<?php foreach ($messages as $value): ?>
	<div class="message_row">
		<div class="time"><?php echo $value['time']; ?></div>
		<span class="username"><?php echo $value['name']; ?>:&nbsp;</span>
		<?php echo $value['message']; ?>
	</div>
<?php endforeach; ?>
