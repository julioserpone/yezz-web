<?php require_once('header' . get_option('template_extension', TRUE)); ?>

		<div class="container-fluid">
			
			<div class="row-fluid">
				
				<div class="span12">
					
					<ul class="breadcrumb">
						<li><a href="index.php"><?php translate('Home'); ?></a> <span class="divider"><?php translate('/'); ?></span></li>
						<li><a href="languages.php"><?php translate('Languages'); ?></a> <span class="divider"><?php translate('/'); ?></span></li>
						<li class="active"><?php translate('Add language'); ?></li>
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
							
							<label for="language_name"><?php translate('Language name'); ?></label>
							<input type="text" class="span5" id="language_name" name="language_name" value="<?php if (!empty($_POST['language_name'])) echo filter_var($_POST['language_name'], FILTER_SANITIZE_STRING); ?>">

							<label for="language_iso_code"><?php translate('Language code'); ?></label>
							<input type="text" class="span5" id="language_iso_code" name="language_iso_code" value="<?php if (!empty($_POST['language_iso_code'])) echo filter_var($_POST['language_iso_code'], FILTER_SANITIZE_STRING); ?>">

							<p><button type="submit" class="btn btn-primary" name="submit"><?php translate('Save'); ?></button></p>

						</form>
						
					</div>
					
				</div>
				
			</div>
			
		</div>
		
<?php require_once('footer' . get_option('template_extension', TRUE)); ?>
