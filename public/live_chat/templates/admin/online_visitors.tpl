<p class="muted"><?php translate('Online visitors'); ?></p>

<table class="table table-condensed">
	<tbody>
	<?php foreach ($online_visitors as $value): ?>
		<tr>
			<?php if (get_option('ip_tracker_url', TRUE)): ?>
				<td>
					<a href="<?php echo get_option('ip_tracker_url', TRUE) . $value['ip_address']; ?>" target="_blank">
						<?php echo $value['ip_address']; ?>
					</a>
				</td>
				<td>
					<a href="<?php echo $value['referer']; ?>" target="_blank">
						<?php if (strlen($value['referer']) > 20): ?>
							<?php echo substr($value['referer'], 0, 16) . '...'; ?>
						<?php else: ?>
							<?php echo $value['referer']; ?>
						<?php endif; ?>
					</a>
				</td>
				<td>
					<button type="button" class="btn btn-primary btn-mini pull-right" id="invite_visitor" data-ip="<?php echo $value['ip_address']; ?>"><?php translate('Invite'); ?></button>
				</td>
			<?php else: ?>
				<td>
					<?php echo $value['ip_address']; ?>
				</td>
				<td>
					<a href="<?php echo $value['referer']; ?>" target="_blank">
						<?php if (strlen($value['referer']) > 20): ?>
							<?php echo substr($value['referer'], 0, 16) . '...'; ?>
						<?php else: ?>
							<?php echo $value['referer']; ?>
						<?php endif; ?>
					</a>
				</td>
				<td>
					<button type="button" class="btn btn-primary btn-mini pull-right" id="invite_visitor" data-ip="<?php echo $value['ip_address']; ?>"><?php translate('Invite'); ?></button>
				</td>
			<?php endif; ?>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
