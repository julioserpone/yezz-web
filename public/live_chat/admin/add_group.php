<?php 

//Include the common file
require_once('../common.php');

//Include the administration file
require_once('admin.php');

//Check if the form has been submitted
if (isset($_POST['submit'])) {

	$validate->required($_POST['group_name'], translate('Please enter a group name.', TRUE));

	if (empty($_POST['group_permissions'])) {
		
		$error->set_error(translate('Please select a page.', TRUE));
		
	}
	
	if (!$error->has_errors()) {
		
		$values = array(
			'group_name'		=> filter_var($_POST['group_name'], FILTER_SANITIZE_STRING),
			'group_permissions' => serialize($_POST['group_permissions'])
		);		

		$db->insert(config_item('database', 'table_prefix') . 'user_groups', $values);
		
		$tpl->set('success', TRUE);
		
	}

}

//Display the template
$tpl->display('admin/add_group');

?>
