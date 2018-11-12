<?php require_once('header' . get_option('template_extension', TRUE)); ?>

		<div class="container-fluid">
			
			<div class="row-fluid">
				
				<div class="span12">
					
					<ul class="breadcrumb">
						<li><a href="index.php"><?php translate('Home'); ?></a> <span class="divider"><?php translate('/'); ?></span></li>
						<li><a href="groups.php"><?php translate('Groups'); ?></a> <span class="divider"><?php translate('/'); ?></span></li>
						<li class="active"><?php translate('Add group'); ?></li>
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
							
							<label for="group_name"><?php translate('Group name'); ?></label>
							<input type="text" class="span5" id="group_name" name="group_name" value="<?php if (!empty($_POST['group_name'])) echo filter_var($_POST['group_name'], FILTER_SANITIZE_STRING); ?>">

							<label for="group_permissions"><?php translate('Permissions'); ?></label>
							<select id="group_permissions" name="group_permissions[]" multiple="multiple" style="min-height: 200px;">
								<?php foreach ($pages as $key => $value): ?>
									<option value="<?php echo $key; ?>"><?php echo $key; ?></option>
								<?php endforeach; ?>
							</select>

							<p><button type="submit" class="btn btn-primary" name="submit"><?php translate('Save'); ?></button></p>

						</form>
						
					</div>
					
				</div>
				
			</div>
			
		</div>
		
<?php require_once('footer' . get_option('template_extension', TRUE)); ?>
