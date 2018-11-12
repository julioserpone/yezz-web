<?php require_once('header' . get_option('template_extension', TRUE)); ?>

		<div class="container-fluid">
			
			<div class="row-fluid">
				
				<div class="span12">
					
					<ul class="breadcrumb">
						<li><a href="index.php"><?php translate('Home'); ?></a> <span class="divider"><?php translate('/'); ?></span></li>
						<li class="active"><?php translate('Blocked visitors'); ?></li>
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

					<?php if ($error->has_errors()): ?>
						<div class="alert alert-block alert-error">
							<p><strong><?php translate('An error occurred while processing request:'); ?></strong></p>
							<?php foreach ($error->display_errors() as $value): ?>		
								<p><?php echo $value; ?></p>
							<?php endforeach; ?>
						</div>
					<?php $error->clear_errors(); endif; ?>

					<?php if (isset($success) && $success): ?>
						<div class="alert alert-success">
							<?php translate('Record added successfully!'); ?>
						</div>
					<?php endif; ?>
					
					<?php if (isset($_GET['ip_address'])): ?>

						<div class="well">
							
							<form method="post">
								
								<input type="hidden" name="token" value="<?php echo generate_token('form'); ?>">
								
								<label for="ip_address"><?php translate('IP address'); ?></label>
								<input type="text" id="ip_address" name="ip_address" class="span5" value="<?php if (isset($_GET['ip_address'])) echo $_GET['ip_address']; ?>">

								<label for="description"><?php translate('Description'); ?></label>
								<input type="text" id="description" name="description" class="span5">

								<p><button type="submit" class="btn btn-primary" name="submit"><?php translate('Save'); ?></button></p>
								
							</form>
							
						</div>
						
					<?php endif; ?>
						
					<?php if ($row_count > 0): ?>
						
						<div class="well">

							<table class="table">
								<thead>
									<tr>
										<th><?php translate('IP address'); ?></th>
										<th><?php translate('Description'); ?></th>
										<th><?php translate('Date'); ?></th>
										<th>&nbsp;</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($blocked_visitors as $value): ?>
										<tr>
											<?php if (get_option('ip_tracker_url', TRUE)): ?>
												<td><a href="<?php echo get_option('ip_tracker_url', TRUE) . $value['ip_address']; ?>" target="_blank"><?php echo $value['ip_address']; ?></a></td>
											<?php else: ?>
												<td><?php echo $value['ip_address']; ?></td>
											<?php endif; ?>
											<td><?php echo $value['description']; ?></td>
											<td><?php echo date(get_option('date_format', TRUE) . ' ' . get_option('time_format', TRUE), $value['time']); ?></td>
											<td><a href="?blocked_visitor_id=<?php echo $value['blocked_visitor_id']; ?>" title="Delete"><i class="icon-trash"></i></a></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
							
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
