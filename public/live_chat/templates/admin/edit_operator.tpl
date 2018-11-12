<?php require_once('header' . get_option('template_extension', TRUE)); ?>

		<div class="container-fluid">
			
			<div class="row-fluid">
				
				<div class="span12">
					
					<ul class="breadcrumb">
						<li><a href="index.php"><?php translate('Home'); ?></a> <span class="divider"><?php translate('/'); ?></span></li>
						<li><a href="operators.php"><?php translate('Operators'); ?></a> <span class="divider"><?php translate('/'); ?></span></li>
						<li class="active"><?php translate('Edit operator'); ?></li>
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

					<?php if (isset($success) && !$success): ?>
						<div class="alert alert-error">
							<?php translate('This email address is already taken!'); ?>
						</div>
					<?php endif; ?>
					
					<div class="well">
						
						<?php if (isset($_GET['operator_id']) && $row_count > 0): ?>
							
							<?php foreach ($operator_details as $value1): ?>
							
								<form method="post">
									
									<input type="hidden" name="token" value="<?php echo generate_token('form'); ?>">
									
									<label for="first_name"><?php translate('First name'); ?></label>
									<input type="text" class="span5" id="first_name" name="first_name" value="<?php echo $value1['first_name']; ?>">

									<label for="last_name"><?php translate('Last name'); ?></label>
									<input type="text" class="span5" id="last_name" name="last_name" value="<?php echo $value1['last_name']; ?>">

									<label for="user_email"><?php translate('Operator email'); ?></label>
									<input type="text" class="span5" id="user_email" name="user_email" value="<?php echo $value1['user_email']; ?>">

									<label for="password"><?php translate('Password'); ?></label>
									<input type="password" class="span5" id="password" name="password">

									<label for="confirm_password"><?php translate('Confirm password'); ?></label>
									<input type="password" class="span5" id="confirm_password" name="confirm_password">

									<label for="group_id"><?php translate('Permissions'); ?></label>
									<select id="group_id" name="group_id">
										<?php foreach ($groups as $value2): ?>
											<?php if ($value1['group_id'] == $value2['group_id']): ?>
												<option value="<?php echo $value2['group_id']; ?>" selected><?php echo $value2['group_name']; ?></option>
											<?php else: ?>
												<option value="<?php echo $value2['group_id']; ?>"><?php echo $value2['group_name']; ?></option>
											<?php endif; ?>
										<?php endforeach; ?>
									</select>

									<label for="departments"><?php translate('Departments'); ?></label>
									<select id="departments" name="departments[]" multiple="multiple">
										<?php foreach ($departments as $value3): ?>
											<?php if (in_array($value3['department_id'], $department_operators)): ?>
												<option value="<?php echo $value3['department_id']; ?>" selected><?php echo $value3['department_name']; ?></option>
											<?php else: ?>
												<option value="<?php echo $value3['department_id']; ?>"><?php echo $value3['department_name']; ?></option>
											<?php endif; ?>
										<?php endforeach; ?>
									</select>

									<label class="radio">
										<?php if ($value1['user_status']): ?>
											<input type="radio" name="user_status" value="1" checked="checked">
											<?php translate('Active'); ?>
										<?php else: ?>
											<input type="radio" name="user_status" value="1">
											<?php translate('Active'); ?>
										<?php endif; ?>
									</label>

									<label class="radio">
										<?php if (!$value1['user_status']): ?>
											<input type="radio" name="user_status" value="0" checked="checked">
											<?php translate('Inactive'); ?>
										<?php else: ?>
											<input type="radio" name="user_status" value="0">
											<?php translate('Inactive'); ?>
										<?php endif; ?>
									</label>
									
									<label class="checkbox">
										<input type="checkbox" name="hide_online" value="1" <?php if ($value1['hide_online']) echo 'checked'; ?>>
										<?php translate('Hide online'); ?>
									</label>
									
									<p><button type="submit" class="btn btn-primary" name="submit"><?php translate('Save'); ?></button></p>

								</form>
							
							<?php endforeach; ?>
							
						<?php else: ?>
						
							<div class="alert alert-info">
								<?php translate('Records not found.'); ?>
							</div>
						
						<?php endif; ?>
						
					</div>
					
				</div>
				
			</div>
			
		</div>
		
<?php require_once('footer' . get_option('template_extension', TRUE)); ?>
