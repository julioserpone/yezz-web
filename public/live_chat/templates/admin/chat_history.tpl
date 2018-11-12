<?php require_once('header' . get_option('template_extension', TRUE)); ?>

		<script type="text/javascript">
			$(function() {

				$('.select_all').click(function() {
					
					if ($(this).is(':checked')) {
						
						$('input:checkbox').prop('checked', true);
						
					} else {
						
						$('input:checkbox').prop('checked', false);
						
					}

				});

				$('#delete').click(function(event) {
					
					event.preventDefault();
					
					$('input:checked').each(function() {
						
						$('#modal').modal({
							backdrop: false
						});
						
					});
					
				});
				
				$('#close_dialog').click(function(event) {
					
					event.preventDefault();
					
					$('#modal').modal('hide');

				});
				
				$('#submit').click(function() {

					$('form:first').submit();
					
				});

			});
		</script>

		<div class="container-fluid">
			
			<div class="row-fluid">
				
				<div class="span12">
					
					<ul class="breadcrumb">
						<li><a href="index.php"><?php translate('Home'); ?></a> <span class="divider"><?php translate('/'); ?></span></li>
						<li class="active"><?php translate('Chat history'); ?></li>
					</ul>
				
				</div>
			
			</div>
			
			<div class="row-fluid">
				
				<div class="span3">
					
					<div class="row-fluid">
						
						<div class="span12">
							<?php require_once('nav' . get_option('template_extension', TRUE)); ?>
						</div>
						
					</div>
					
				</div>
				
				<div class="span9">
					
					<?php if ($row_count > 0): ?>

						<div id="modal" class="modal hide fade">
							<div class="modal-body">
								<p><?php translate('These item(s) will be permanently deleted and cannot be recovered. Are you sure?'); ?></p>
							</div>
							<div class="modal-footer">
								<button class="btn" id="close_dialog"><?php translate('Close'); ?></button>
								<button class="btn btn-primary" id="submit"><?php translate('Delete'); ?></button>
							</div>
						</div>

						<div class="well">
							
							<form method="post">
								
								<input type="hidden" name="token" value="<?php echo generate_token('form'); ?>">
								
								<button class="btn btn-primary" id="delete"><?php translate('Delete'); ?></button>
								
								<table class="table">
									<thead>
										<tr>
											<th><input type="checkbox" value="cb_chat" class="select_all"></th>
											<th><?php translate('Name'); ?></th>
											<th><?php translate('IP address'); ?></th>
											<th><?php translate('Department'); ?></th>
											<th><?php translate('Time in chat'); ?></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($chat_history as $value): ?>
											<tr>
												<td><input type="checkbox" value="<?php echo $value['chat_id']; ?>" name="cb_chat[]"></td>
												<td><a href="view_chat.php?chat_id=<?php echo $value['chat_id']; ?>" title="<?php translate('View chat'); ?>"><?php echo $value['username']; ?></a></td>
												<?php if (empty($option['ip_tracker_url'])): ?>
													<td><?php echo $value['ip_address']; ?></td>
												<?php else: ?>
													<td><a href="<?php echo $option['ip_tracker_url'] . $value['ip_address']; ?>" target="_blank"><?php echo $value['ip_address']; ?></a></td>
												<?php endif; ?>
												<td><?php echo $value['department_name']; ?></td>
												<td><?php echo $value['elapsed_time']; ?></td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							
							</form>
							
							<ul class="pager">
								<?php if ($current_page > 1 && ($current_page - 1) < $pages): ?>
									<li><a href="?page=<?php echo ($current_page - 1); ?>"><?php translate('Previous'); ?></a></li>
								<?php endif; ?>
								<?php if ($pages > $current_page && ($current_page - 1) < $pages): ?>
									<li><a href="?page=<?php echo ($current_page + 1); ?>"><?php translate('Next'); ?></a></li>
								<?php endif; ?>
							</ul>
							
						</div>
					
					<?php else: ?>
					
						<div class="alert alert-info">
							<?php translate('Records not found.'); ?>
						</div>
					
					<?php endif; ?>
					
				</div>
				
			</div>
			
		</div>
		
<?php require_once('footer' . get_option('template_extension', TRUE)); ?>
