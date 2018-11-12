<?php require_once('header' . get_option('template_extension', TRUE)); ?>
		
		<script type="text/javascript">
			$(function () {
				
				$('#tab a:first').tab('show');
				
				$('#tab a').click(function (event) {
					
					event.preventDefault();
					
					$(this).tab('show');
					
				});
				
			});
		</script>
		<div class="container-fluid">
			
			<div class="row-fluid">
				
				<div id="login_form" class="span5">
					
					<?php if ($error->has_errors()): ?>
						<div class="alert alert-block alert-error">
							<p><strong><?php translate('An error occurred while processing request:'); ?></strong></p>
							<?php foreach ($error->display_errors() as $value): ?>		
								<p><?php echo $value; ?></p>
							<?php endforeach; ?>
						</div>
					<?php $error->clear_errors(); endif; ?>

					<?php if (isset($success) && isset($_POST['login']) && !$success): ?>
						<div class="alert alert-error">
							<?php translate('The email address or password you entered is incorrect.'); ?>
						</div>
					<?php endif; ?>

					<?php if (isset($success) && isset($_POST['reset_password']) && $success): ?>
						<div class="alert alert-success">
							<?php translate('A new password has been sent to your email address!'); ?>
						</div>
					<?php endif; ?>

					<?php if (isset($success) && isset($_POST['reset_password']) && !$success): ?>
						<div class="alert alert-error">
							<?php translate('The email address was not found in our records, please try again!'); ?>
						</div>
					<?php endif; ?>

					<div class="well">

						<ul class="nav nav-tabs" id="tab">
							<li><a href="#login"><?php translate('Login'); ?></a></li>
							<li><a href="#reset_password"><?php translate('Lost your password?'); ?></a></li>
						</ul>

						<form method="post">
							
							<input type="hidden" name="token" value="<?php echo generate_token('form'); ?>">
							
							<div class="tab-content">
								
								<div class="tab-pane" id="login">

									<label for="email1"><?php translate('Email'); ?></label>
									<input type="text" class="span8" id="email1" name="email1">

									<label for="password"><?php translate('Password'); ?></label>
									<input type="password" class="span8" id="password" name="password">
									
									<label class="checkbox">
										<input type="checkbox" name="remember" value="1">
										<?php translate('Remember me'); ?>
									</label>
									
									<p><button type="submit" class="btn btn-primary" name="login"><?php translate('Login'); ?></button></p>
							
								</div>
								
								<div class="tab-pane" id="reset_password">

									<label for="email2"><?php translate('Email'); ?></label>
									<input type="text" class="span8" id="email2" name="email2">
									
									<p><button type="submit" class="btn btn-primary" name="reset_password"><?php translate('Reset password'); ?></button></p>

								</div>
								
							</div>

						</form>
						
					</div>
					
				</div>
				
			</div>
			
		</div>
		
<?php require_once('footer' . get_option('template_extension', TRUE)); ?>
