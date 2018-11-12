<?php require_once('header' . get_option('template_extension', TRUE)); ?>

		<script type="text/javascript">
			$(function() {
				
				$('#background_color_1').minicolors({
					<?php if (get_option('background_color_1', TRUE)): ?>
					defaultValue: '<?php get_option('background_color_1'); ?>',
					<?php endif; ?>
					theme: 'bootstrap',
					letterCase: 'uppercase'
				});
				
				$('#background_color_2').minicolors({
					<?php if (get_option('background_color_2', TRUE)): ?>
					defaultValue: '<?php get_option('background_color_2'); ?>',
					<?php endif; ?>
					theme: 'bootstrap',
					letterCase: 'uppercase'
				});
				
				$('#background_color_3').minicolors({
					<?php if (get_option('background_color_3', TRUE)): ?>
					defaultValue: '<?php get_option('background_color_3'); ?>',
					<?php endif; ?>
					theme: 'bootstrap',
					letterCase: 'uppercase'
				});
				
				$('#color_1').minicolors({
					<?php if (get_option('color_1', TRUE)): ?>
					defaultValue: '<?php get_option('color_1'); ?>',
					<?php endif; ?>
					theme: 'bootstrap',
					letterCase: 'uppercase'
				});
				
				$('#color_3').minicolors({
					<?php if (get_option('color_3', TRUE)): ?>
					defaultValue: '<?php get_option('color_3'); ?>',
					<?php endif; ?>
					theme: 'bootstrap',
					letterCase: 'uppercase'
				});
				
				$('#color_2').minicolors({
					<?php if (get_option('color_2', TRUE)): ?>
					defaultValue: '<?php get_option('color_2'); ?>',
					<?php endif; ?>
					theme: 'bootstrap',
					letterCase: 'uppercase'
				});
				
				$('#tab a:first').tab('show');
				
				$('#tab a').click(function (event) {
					
					event.preventDefault();

					if ($(event.target).attr('href') == '#embed_code') {
						
						$("button[name='submit']").hide();
						
					} else {
					
						$("button[name='submit']").show();
					
					}
					
					$(this).tab('show');
					
				});
				
			});
		</script>

		<div class="container-fluid">
			
			<div class="row-fluid">
				
				<div class="span12">
					
					<ul class="breadcrumb">
						<li><a href="index.php"><?php translate('Home'); ?></a> <span class="divider"><?php translate('/'); ?></span></li>
						<li class="active"><?php translate('Settings'); ?></li>
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
							<?php translate('Record edited successfully!'); ?>
						</div>
					<?php endif; ?>

					<div class="well">
						
						<ul class="nav nav-tabs" id="tab">
							<li><a href="#general"><?php translate('General'); ?></a></li>
							<li><a href="#server"><?php translate('Server'); ?></a></li>
							<li><a href="#authentication"><?php translate('Authentication'); ?></a></li>
							<li><a href="#style"><?php translate('Style'); ?></a></li>
							<li><a href="#embed_code"><?php translate('Embed code'); ?></a></li>
						</ul>
						
						<form method="post">
							
							<input type="hidden" name="token" value="<?php echo generate_token('form'); ?>">
							
							<div class="tab-content">
								
								<div class="tab-pane active" id="general">
									
									<div class="row-fluid">
										
										<div class="span6">

											<label for="site_title"><?php translate('Site title'); ?></label>
											<input type="text" class="span10" id="site_title" name="site_title" value="<?php if (!empty($_POST['site_title'])) echo filter_var($_POST['site_title'], FILTER_SANITIZE_STRING); else get_option('site_title'); ?>">

											<label for="console_interval"><?php translate('Console interval'); ?> <?php translate('(seconds)'); ?></label>
											<input type="text" class="span10" id="console_interval" name="console_interval" value="<?php if (!empty($_POST['console_interval'])) echo filter_var($_POST['console_interval'], FILTER_SANITIZE_STRING); else get_option('console_interval'); ?>">

											<label for="online_timeout"><?php translate('Operator time as online'); ?> <?php translate('(seconds)'); ?></label>
											<input type="text" class="span10" id="online_timeout" name="online_timeout" value="<?php if (!empty($_POST['online_timeout'])) echo filter_var($_POST['online_timeout'], FILTER_SANITIZE_STRING); else get_option('online_timeout'); ?>">

											<label for="max_connections"><?php translate('Number of connections from one address'); ?></label>
											<input type="text" class="span10" id="max_connections" name="max_connections" value="<?php if (!empty($_POST['max_connections'])) echo filter_var($_POST['max_connections'], FILTER_SANITIZE_STRING); else get_option('max_connections'); ?>">

											<label for="admin_email"><?php translate('Email'); ?></label>
											<input type="text" class="span10" id="admin_email" name="admin_email" value="<?php if (!empty($_POST['admin_email'])) echo filter_var($_POST['admin_email'], FILTER_SANITIZE_EMAIL); else get_option('admin_email'); ?>">

											<label for="max_visitors"><?php translate('Number of visitors at one time'); ?></label>
											<input type="text" class="span10" id="max_visitors" name="max_visitors" value="<?php if (!empty($_POST['max_visitors'])) echo filter_var($_POST['max_visitors'], FILTER_SANITIZE_STRING); else get_option('max_visitors'); ?>">

										</div>
										
										<div class="span6">

											<label for="ip_tracker_url"><?php translate('IP tracker url'); ?></label>
											<input type="text" class="span10" id="ip_tracker_url" name="ip_tracker_url" value="<?php if (!empty($_POST['ip_tracker_url'])) echo filter_var($_POST['ip_tracker_url'], FILTER_SANITIZE_STRING); else get_option('ip_tracker_url'); ?>">

											<label for="chat_interval"><?php translate('Chat interval'); ?> <?php translate('(seconds)'); ?></label>
											<input type="text" class="span10" id="chat_interval" name="chat_interval" value="<?php if (!empty($_POST['chat_interval'])) echo filter_var($_POST['chat_interval'], FILTER_SANITIZE_STRING); else get_option('chat_interval'); ?>">
									
											<label for="chat_expire"><?php translate('Chat lifetime'); ?> <?php translate('(seconds)'); ?></label>
											<input type="text" class="span10" id="chat_expire" name="chat_expire" value="<?php if (!empty($_POST['chat_expire'])) echo filter_var($_POST['chat_expire'], FILTER_SANITIZE_STRING); else get_option('chat_expire'); ?>">

											<label for="records_per_page"><?php translate('Records per page'); ?></label>
											<input type="text" class="span10" id="records_per_page" name="records_per_page" value="<?php if (!empty($_POST['records_per_page'])) echo filter_var($_POST['records_per_page'], FILTER_SANITIZE_STRING); else get_option('records_per_page'); ?>">
										
											<label for="charset"><?php translate('Charset'); ?></label>
											<input type="text" class="span10" id="charset" name="charset" value="<?php if (!empty($_POST['charset'])) echo filter_var($_POST['charset'], FILTER_SANITIZE_STRING); else get_option('charset'); ?>">
									
										</div>
										
									</div>

								</div>
								
								<div class="tab-pane" id="server">

									<label for="timezone"><?php translate('Timezone'); ?></label>
									<select name="timezone" id="timezone">
										<?php foreach ($timezone as $key => $value): ?>
											<option value="<?php echo $value; ?>" <?php if (get_option('timezone', TRUE) == $value) echo 'selected'; ?>><?php echo $key; ?></option>
										<?php endforeach; ?>
									</select>
									
									<label for="date_format"><?php translate('Date format'); ?> <a href="http://php.net/manual/en/function.date.php" target="_blank"><i class="icon-info-sign"></i></a></label>
									<input type="text" class="span5" id="date_format" name="date_format" value="<?php if (!empty($_POST['date_format'])) echo filter_var($_POST['date_format'], FILTER_SANITIZE_STRING); else get_option('date_format'); ?>">

									<label for="time_format"><?php translate('Time format'); ?> <a href="http://php.net/manual/en/function.date.php" target="_blank"><i class="icon-info-sign"></i></a></label>
									<input type="text" class="span5" id="time_format" name="time_format" value="<?php if (!empty($_POST['time_format'])) echo filter_var($_POST['time_format'], FILTER_SANITIZE_STRING); else get_option('time_format'); ?>">
									
								</div>
								
								<div class="tab-pane" id="authentication">

									<label for="user_expire"><?php translate('Session lifetime'); ?></label>
									<input type="text" class="span5" id="user_expire" name="user_expire" value="<?php if (!empty($_POST['user_expire'])) echo filter_var($_POST['user_expire'], FILTER_SANITIZE_STRING); else get_option('user_expire'); ?>">
									
									<label for="access_logs"><?php translate('Access logs'); ?></label>
									<select name="access_logs" id="access_logs">
										<?php if (get_option('access_logs', TRUE)): ?>
											<option value="1" selected><?php translate('Yes'); ?></option>
											<option value="0"><?php translate('No'); ?></option>
										<?php else: ?>
											<option value='1'><?php translate('Yes'); ?></option>
											<option value='0' selected><?php translate('No'); ?></option>
										<?php endif; ?>
									</select>
	
								</div>
								
								<div class="tab-pane" id="style">

									<div class="row-fluid">
										
										<div class="span6">
											
											<label for="background_color_1"><?php translate('Header background color'); ?></label>
											<input type="text" class="span10" id="background_color_1" name="background_color_1">

											<label for="color_1"><?php translate('Header text color'); ?></label>
											<input type="text" class="span10" id="color_1" name="color_1">

											<label for="background_color_2"><?php translate('Content background color'); ?></label>
											<input type="text" class="span10" id="background_color_2" name="background_color_2">

											<label for="color_2"><?php translate('Content text color'); ?></label>
											<input type="text" class="span10" id="color_2" name="color_2">
									
										</div>
										
										<div class="span6">

											<label for="background_color_3"><?php translate('Button background color'); ?></label>
											<input type="text" class="span10" id="background_color_3" name="background_color_3">

											<label for="color_3"><?php translate('Button text color'); ?></label>
											<input type="text" class="span10" id="color_3" name="color_3">

										</div>
										
									</div>
									
								</div>
								
								<div class="tab-pane" id="embed_code">
									
									<p><?php echo htmlspecialchars(translate('Copy and paste the following code on your website pages, just before the closing </body> tag.', TRUE)); ?></p>

									<?php embed_code(); ?>

								</div>
								
							</div>
							
							<p>
								<button type="submit" class="btn btn-primary" name="submit"><?php translate('Save'); ?></button>
							</p>
							
						</form>
						
					</div>
					
				</div>
				
			</div>
			
		</div>
		
<?php require_once('footer' . get_option('template_extension', TRUE)); ?>
