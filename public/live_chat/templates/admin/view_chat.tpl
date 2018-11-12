<?php require_once('header' . get_option('template_extension', TRUE)); ?>

		<div class="container-fluid">
			
			<div class="row-fluid">
				
				<div class="span12">
					
					<ul class="breadcrumb">
						<li><a href="index.php"><?php translate('Home'); ?></a> <span class="divider"><?php translate('/'); ?></span></li>
						<li><a href="chat_history.php"><?php translate('Chat history'); ?></a> <span class="divider"><?php translate('/'); ?></span></li>
						<li class="active"><?php translate('View chat'); ?></li>
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
							
							<div class="row-fluid">
								
								<div class="span3">
									
									<?php foreach ($chat_details as $value): ?>
										<p><small><strong><?php translate('Email'); ?>:</strong> <?php echo $value['email']; ?></small></p>
										<p><small><strong><?php translate('Department name'); ?>:</strong> <?php echo $value['department_name']; ?></small></p>
										<p>
											<small><strong><?php translate('Referer'); ?>:</strong>
												<a href="<?php echo $value['referer']; ?>" target="_blank">
													<?php if (strlen($value['referer']) > 30): ?>
														<?php echo substr($value['referer'], 0, 25) . '...'; ?>
													<?php else: ?>
														<?php echo $value['referer']; ?>
													<?php endif; ?>
												</a>
											</small>
										</p>
										<p>
											<small>
												<strong><?php translate('IP address'); ?>:</strong>
												<?php if (get_option('ip_tracker_url', TRUE)): ?>
													<a href="<?php echo get_option('ip_tracker_url', TRUE) . $value['ip_address']; ?>" target="_blank"><?php echo $value['ip_address']; ?></a>
												<?php else: ?>
													<?php echo $value['ip_address']; ?>
												<?php endif; ?>
											</small>
										</p>
									<?php endforeach; ?>
									
								</div>
								
								<div class="span9">
									
									<div id="chat_messages">
										
										<div class="messages">
											<div class="message_content">
												<?php foreach ($messages as $value): ?>
													<div class="message_row">
														<div class="time"><?php echo $value['time']; ?></div>
														<span class="username"><?php echo $value['name']; ?>:&nbsp;</span>
														<?php echo $value['message']; ?>
													</div>
												<?php endforeach; ?>
											</div>
										</div>
										
									</div>
									
								</div>
								
							</div>

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
