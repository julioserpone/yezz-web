<?php require_once('header' . get_option('template_extension', TRUE)); ?>

		<div class="container-fluid">
			
			<div class="row-fluid">
				
				<div class="span12">
					
					<ul class="breadcrumb">
						<li><a href="index.php"><?php translate('Home'); ?></a> <span class="divider"><?php translate('/'); ?></span></li>
						<li class="active"><?php translate('Translations'); ?></li>
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
					
					<?php if ($session->get('success')): ?>
						<div class="alert alert-success">
							<?php translate('Record edited successfully!'); ?>
						</div>
					<?php $session->delete('success'); endif; ?>
					
					<?php if ($row_count > 0): ?>
						
						<div class="well">

							<table class="table">
								<thead>
									<tr>
										<th><?php translate('Language name'); ?></th>
										<th><?php translate('Action'); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($languages as $value): ?>
										<tr>
											<td><?php echo $value['language_name']; ?></td>
											<td><a href="edit_translation.php?language_id=<?php echo $value['language_id']; ?>" title="<?php translate('Edit translation'); ?>"><i class="icon-edit"></i></a></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
							
						</div>
					
					<?php else: ?>
					
						<div class="alert alert-info">
							<?php translate('Records not found.'); ?>
						</div>
					
					<?php endif; ?>
					
				</div>
				
			</div>
			
		</div>
		
<?php require_once('footer' . get_option('template_extension', TRUE)); ?>
