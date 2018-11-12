<?php 

//Include the common file
require_once('../common.php');

//Include the administration file
require_once('admin.php');

//Check if the form has been submitted
if (isset($_POST['submit'])) {
	
	$validate->required($_POST['department_name'], translate('Please enter a department name.', TRUE));
	$validate->email($_POST['department_email'], translate('Please enter a department email address.', TRUE));
	
	if (!$error->has_errors()) {
		
		$values = array(
			'department_name'	=> filter_var($_POST['department_name'], FILTER_SANITIZE_STRING),
			'department_email'	=> filter_var($_POST['department_email'], FILTER_SANITIZE_EMAIL)
		);
		
		$db->insert(config_item('database', 'table_prefix') . 'departments', $values);
		
		$tpl->set('success', TRUE);
		
	}

}

//Display the template
$tpl->display('admin/add_department');

?>
