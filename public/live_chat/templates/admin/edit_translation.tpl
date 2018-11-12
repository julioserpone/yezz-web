<?php require_once('header' . get_option('template_extension', TRUE)); ?>

		<div class="container-fluid">
			
			<div class="row-fluid">
				
				<div class="span12">
					
					<ul class="breadcrumb">
						<li><a href="index.php"><?php translate('Home'); ?></a> <span class="divider"><?php translate('/'); ?></span></li>
						<li><a href="translations.php"><?php translate('Translations'); ?></a> <span class="divider"><?php translate('/'); ?></span></li>
						<li><a href="translations.php"><?php translate('Edit translation'); ?></a> <span class="divider"><?php translate('/'); ?></span></li>
						<li class="active"><?php echo $language_name; ?></li>
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
						
						<?php if ($row_count > 0): ?>
							
							<form method="post">
								
								<input type="hidden" name="token" value="<?php echo generate_token('form'); ?>">
								
								<table class="table">
									<thead>
										<tr>
											<th><?php translate('Key'); ?></th>
											<th><?php translate('Text'); ?></th>
											<th>&nbsp;</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><input type="text" name="filter[key]"></td>
											<td><input type="text" name="filter[text]"></td>
											<td><button type="submit" class="btn btn-primary"><?php translate('Filter'); ?></button></td>
										</tr>
									<?php foreach ($translation_details as $value): ?>
										<tr>
											<td><?php echo $value['translation_key']; ?></td>
											<td><textarea rows="4" name="translation[<?php echo htmlspecialchars($value['translation_key'], ENT_QUOTES); ?>]" class="span12"><?php echo $value['translation_text']; ?></textarea></td>
											<td>&nbsp;</td>
										</tr>
									<?php endforeach; ?>
									</tbody>
								</table>
								
								<?php if (count($translation_details) == 0): ?>
									<div class="alert alert-info">
										<?php translate('Records not found.'); ?>
									</div>
								<?php endif; ?>
								
								<ul class="pager">
									<?php if ($current_page > 1 && ($current_page - 1) < $pages): ?>
										<li><a href="?page=<?php echo ($current_page - 1); ?>"><?php translate('Previous'); ?></a></li>
									<?php endif; ?>
									<?php if ($pages > $current_page && ($current_page - 1) < $pages): ?>
										<li><a href="?page=<?php echo ($current_page + 1); ?>"><?php translate('Next'); ?></a></li>
									<?php endif; ?>
								</ul>
								
								<?php if (count($translation_details) > 0): ?>
									<p><button type="submit" class="btn btn-primary" name="submit"><?php translate('Save'); ?></button></p>
								<?php endif; ?>
								
							</form>
							
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
