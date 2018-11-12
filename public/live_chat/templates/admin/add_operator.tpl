<?php require_once('header' . get_option('template_extension', TRUE)); ?>

		<div class="container-fluid">
			
			<div class="row-fluid">
				
				<div class="span12">
					
					<ul class="breadcrumb">
						<li><a href="index.php"><?php translate('Home'); ?></a> <span class="divider"><?php translate('/'); ?></span></li>
						<li><a href="operators.php"><?php translate('Operators'); ?></a> <span class="divider"><?php translate('/'); ?></span></li>
						<li class="active"><?php translate('Add operator'); ?></li>
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

					<?php if (isset($success) && !$success): ?>
						<div class="alert alert-error">
							<?php translate('This email address is already taken!'); ?>
						</div>
					<?php endif; ?>

					<div class="well">
						
						<form method="post">
							
							<input type="hidden" name="token" value="<?php echo generate_token('form'); ?>">
							
							<label for="first_name"><?php translate('First name'); ?></label>
							<input type="text" class="span5" id="first_name" name="first_name" value="<?php if (!empty($_POST['first_name'])) echo filter_var($_POST['first_name'], FILTER_SANITIZE_STRING); ?>">

							<label for="last_name"><?php translate('Last name'); ?></label>
							<input type="text" class="span5" id="last_name" name="last_name" value="<?php if (!empty($_POST['last_name'])) echo filter_var($_POST['last_name'], FILTER_SANITIZE_STRING); ?>">

							<label for="user_email"><?php translate('Operator email'); ?></label>
							<input type="text" class="span5" id="user_email" name="user_email" value="<?php if (!empty($_POST['user_email'])) echo filter_var($_POST['user_email'], FILTER_SANITIZE_EMAIL); ?>">

							<label for="password"><?php translate('Password'); ?></label>
							<input type="password" class="span5" id="password" name="password">

							<label for="confirm_password"><?php translate('Confirm password'); ?></label>
							<input type="password" class="span5" id="confirm_password" name="confirm_password">

							<label for="group_id"><?php translate('Permissions'); ?></label>
							<select id="group_id" name="group_id">
								<?php foreach ($groups as $value): ?>
									<option value="<?php echo $value['group_id']; ?>"><?php echo $value['group_name']; ?></option>
								<?php endforeach; ?>
							</select>

							<label for="departments"><?php translate('Departments'); ?></label>
							<select id="departments" name="departments[]" multiple="multiple">
								<?php foreach ($departments as $value): ?>
									<option value="<?php echo $value['department_id']; ?>"><?php echo $value['department_name']; ?></option>
								<?php endforeach; ?>
							</select>

							<label class="radio">
								<input type="radio" name="user_status" value="1" checked="checked">
								<?php translate('Active'); ?>
							</label>

							<label class="radio">
								<input type="radio" name="user_status" value="0">
								<?php translate('Inactive'); ?>
							</label>
							
							<label class="checkbox">
								<input type="checkbox" name="hide_online" value="1">
								<?php translate('Hide online'); ?>
							</label>

							<p><button type="submit" class="btn btn-primary" name="submit"><?php translate('Save'); ?></button></p>

						</form>
						
					</div>
					
				</div>
				
			</div>
			
		</div>
		
<?php require_once('footer' . get_option('template_extension', TRUE)); ?>
