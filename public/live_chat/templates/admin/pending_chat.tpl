<table class="table">
	<thead>
		<tr>
			<th><?php translate('Name'); ?></th>
			<th><?php translate('IP address'); ?></th>
			<th><?php translate('Status'); ?></th>
			<th><?php translate('Department'); ?></th>
			<th><?php translate('Total time'); ?></th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php $i = 1; ?>
	<?php foreach ($pending_chat as $value): ?>
		<tr>

			<td><?php echo $value['username']; ?></td>
			
			<td><?php echo $value['ip_address']; ?></td>

			<?php if ($value['chat_status'] == 0): ?>
				<td><?php translate('In queue'); ?></td>
			<?php elseif ($value['chat_status'] == 2): ?>
				<td><?php translate('In chat'); ?></td>
			<?php endif; ?>
			
			<td><?php echo $value['department_name']; ?></td>
			<td><?php echo $value['elapsed_time']; ?></td>
			
			<?php if ($value['chat_status'] == 0 && $i == 1): ?>
				<td>&nbsp;</td>
				<td><a href="#" class="start_chat" data-id="<?php echo $value['chat_id']; ?>"><i class="icon-ok-sign"></i></a></td>
				<td><a href="blocked_visitors.php?ip_address=<?php echo $value['ip_address']; ?>" title="<?php translate('Block user'); ?>"><i class="icon-ban-circle"></i></a></td>
			<?php elseif ($value['chat_status'] == 2 && $i == 1): ?>
				<td><a href="#" class="open_chat" data-id="<?php echo $value['chat_id']; ?>" title="<?php translate('Click to chat'); ?>"><i class="icon-comment"></i></a></td>
				<td><a href="#" class="watch_chat" data-id="<?php echo $value['chat_id']; ?>" title="<?php translate('Watch the chat'); ?>"><i class="icon-eye-open"></i></a></td>
				<td><a href="blocked_visitors.php?ip_address=<?php echo $value['ip_address']; ?>" title="<?php translate('Block user'); ?>"><i class="icon-ban-circle"></i></a></td>
			<?php else: ?>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><a href="blocked_visitors.php?ip_address=<?php echo $value['ip_address']; ?>" title="<?php translate('Block user'); ?>"><i class="icon-ban-circle"></i></a></td>
			<?php endif; ?>
			<?php $i++; ?>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
