<?php if (count($departments) == 0): ?>
	<li><a><?php translate('Departments not found'); ?></a></li>
<?php else: ?>
	<?php foreach ($departments as $value): ?>
		<li><a data-id="<?php echo $value['department_id']; ?>" class="transfer_chat"><?php echo $value['department_name']; ?></a></li>
	<?php endforeach; ?>
<?php endif; ?>

