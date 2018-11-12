<?php require_once('header' . get_option('template_extension', TRUE)); ?>

		<script type="text/javascript">			
			$(function() {

				setInterval(get_pending_chat, <?php echo get_option('console_interval', TRUE) * 1000; ?>);
				setInterval(get_online_visitors, <?php echo get_option('console_interval', TRUE) * 1000; ?>);
				setInterval(get_operator_status, <?php echo get_option('console_interval', TRUE) * 1000; ?>);

			});
		</script>
		
		<div class="container-fluid">
			
			<div class="row-fluid">
				
				<div class="span12">
					
					<ul class="breadcrumb">
						<li class="active"><?php translate('Home'); ?></li>
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
					
					<div class="row-fluid">
						
						<div class="span8">
							
							<div class="well">
								
								<div id="chat_messages">
									
									<div class="messages">
										<div class="message_content">
										</div>
									</div>
									<div class="user_typing">
										<span><?php translate('User is typing now...'); ?></span>
									</div>
									
								</div>

								<form id="form_1" style="display: none;">
									
									<input type="hidden" name="token" value="<?php echo generate_token('form'); ?>">
									
									<textarea rows="3" id="message" name="message" class="span12"></textarea>

									<label><?php translate('Select message'); ?></label>
									<select id="canned_messages" name="canned_messages">
										<option value="">--</option>
										<?php foreach ($canned_messages as $value): ?>
											<option value="<?php echo $value['canned_message']; ?>"><?php echo $value['canned_message']; ?></option>
										<?php endforeach; ?>
									</select>
									
									<br>
									
									<button class="btn btn-primary" id="send_message"><?php translate('Send'); ?></button>
									<button class="btn btn-danger" id="stop_chat"><?php translate('Close chat'); ?></button>

									<div class="btn-group">
										<a href="#" id="update_online_departments" class="btn dropdown-toggle">
											<?php translate('Transfer chat'); ?>
											 <span class="caret"></span>
										</a>
										
										<ul id="online_departments" class="dropdown-menu"></ul>

									</div>
									
								</form>
								
							</div>

						</div>
						
						<div class="span4">
							
							<div class="well">
								
								<div class="alert alert-success" id="alert_1" style="display: none;">
									<a href="#" class="close">&times;</a>
									<?php translate('Message sent successfully!'); ?>
								</div>
								
								<form id="form_2" style="display: none;">
									
									<input type="hidden" name="token" value="<?php echo generate_token('form'); ?>">
									
									<div class="input-append">
										<input type="text" name="invitation_message" id="invitation_message" class="span10">
										<input type="hidden" name="ip_address" id="ip_address">
										<button class="btn" type="button" id="send_invitation"><?php translate('Send'); ?></button>
									</div>
									
								</form>
								
								<div id="online_visitors"><?php translate('Loading...'); ?></div>
							
							</div>
							
						</div>
					
					</div>
					
					<div class="row-fluid">
						
						<div class="span12">
							
							<div class="well" id="pending_chat"><?php translate('Loading...'); ?></div>
							
						</div>
						
					</div>
				
				</div>
				
			</div>
			
		</div>
		
<?php require_once('footer' . get_option('template_extension', TRUE)); ?>
