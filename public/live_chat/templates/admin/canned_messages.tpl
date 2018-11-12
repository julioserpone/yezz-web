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
						<li class="active"><?php translate('Canned messages'); ?></li>
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
					
					<?php if ($session->get('success')): ?>
						<div class="alert alert-success">
							<?php translate('Record edited successfully!'); ?>
						</div>
					<?php $session->delete('success'); endif; ?>
					
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
								
								<a href="add_canned_message.php" class="btn btn-default"><?php translate('Add message'); ?></a>
								<button class="btn btn-primary" id="delete"><?php translate('Delete'); ?></button>
								
								<table class="table">
									<thead>
										<tr>
											<th><input type="checkbox" value="cb_message" class="select_all"></th>
											<th><?php translate('Message'); ?></th>
											<th><?php translate('Action'); ?></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($canned_messages as $value): ?>
											<tr>
												<td><input type="checkbox" value="<?php echo $value['message_id']; ?>" name="cb_message[]"></td>
												<td><?php echo $value['canned_message']; ?></td>
												<td><a href="edit_canned_message.php?message_id=<?php echo $value['message_id']; ?>" title="<?php translate('Edit message'); ?>"><i class="icon-edit"></i></a></td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
								
							</form>
							
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
