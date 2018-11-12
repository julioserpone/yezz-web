<?php require_once('header' . get_option('template_extension', TRUE)); ?>

		<div class="container-fluid">
			
			<div class="row-fluid">
				
				<div class="span12">
					
					<ul class="breadcrumb">
						<li><a href="index.php"><?php translate('Home'); ?></a> <span class="divider"><?php translate('/'); ?></span></li>
						<li><a href="departments.php"><?php translate('Departments'); ?></a> <span class="divider"><?php translate('/'); ?></span></li>
						<li class="active"><?php translate('Add department'); ?></li>
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

					<div class="well">
						
						<form method="post">
							
							<input type="hidden" name="token" value="<?php echo generate_token('form'); ?>">
							
							<label for="department_name"><?php translate('Department name'); ?></label>
							<input type="text" class="span5" id="department_name" name="department_name" value="<?php if (!empty($_POST['department_name'])) echo filter_var($_POST['department_name'], FILTER_SANITIZE_STRING); ?>">

							<label for="department_email"><?php translate('Department email'); ?></label>
							<input type="text" class="span5" id="department_email" name="department_email" value="<?php if (!empty($_POST['department_email'])) echo filter_var($_POST['department_email'], FILTER_SANITIZE_EMAIL); ?>">

							<p><button type="submit" class="btn btn-primary" name="submit"><?php translate('Save'); ?></button></p>

						</form>
						
					</div>
					
				</div>
				
			</div>
			
		</div>

<?php require_once('footer' . get_option('template_extension', TRUE)); ?>
