<?php require_once('header' . get_option('template_extension', TRUE)); ?>

		<div class="container-fluid">
			
			<div class="row-fluid">
				
				<div class="span12">
					
					<ul class="breadcrumb">
						<li><a href="index.php"><?php translate('Home'); ?></a> <span class="divider"><?php translate('/'); ?></span></li>
						<li><a href="languages.php"><?php translate('Languages'); ?></a> <span class="divider"><?php translate('/'); ?></span></li>
						<li class="active"><?php translate('Edit language'); ?></li>
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

					<div class="well">
						
						<?php if (isset($_GET['language_id']) && $row_count > 0): ?>
							
							<?php foreach ($language_details as $value): ?>
							
								<form method="post">
									
									<input type="hidden" name="token" value="<?php echo generate_token('form'); ?>">
									
									<label for="language_name"><?php translate('Language name'); ?></label>
									<input type="text" class="span5" id="language_name" name="language_name" value="<?php echo $value['language_name']; ?>">

									<label for="language_iso_code"><?php translate('Language code'); ?></label>
									<input type="text" class="span5" id="language_iso_code" name="language_iso_code" value="<?php echo $value['language_iso_code']; ?>">
									
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
