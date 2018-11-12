<?php require_once('header' . get_option('template_extension', TRUE)); ?>

		<div class="container-fluid">
			
			<div class="row-fluid">
				
				<div class="span12">
					
					<ul class="breadcrumb">
						<li><a href="index.php"><?php translate('Home'); ?></a> <span class="divider"><?php translate('/'); ?></span></li>
						<li class="active"><?php translate('Access logs'); ?></li>
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
						
						<div class="well">

							<table class="table">
								<thead>
									<tr>
										<th><?php translate('Full name'); ?></th>
										<th><?php translate('Email'); ?></th>
										<th><?php translate('IP address'); ?></th>
										<th><?php translate('Last login'); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($access_logs as $value): ?>
										<tr>
											<td><?php echo $value['full_name']; ?></td>
											<td><?php echo $value['user_email']; ?></td>
											<?php if (get_option('ip_tracker_url', TRUE)): ?>
												<td><a href="<?php echo get_option('ip_tracker_url', TRUE) . $value['log_ip']; ?>" target="_blank"><?php echo $value['log_ip']; ?></a></td>
											<?php else: ?>
												<td><?php echo $value['log_ip']; ?></td>
											<?php endif; ?>
											<td><?php echo $value['time']; ?></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>

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
