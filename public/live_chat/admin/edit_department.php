<?php 

//Include the common file
require_once('../common.php');

//Include the administration file
require_once('admin.php');

//Check session
if (isset($_GET['department_id'])) {

	$session->set('department_id', $_GET['department_id']);
	
} else {

	header("Location: departments.php");
	
}

//Returns the number of rows
$row_count = $db->row_count("SELECT department_id FROM " . config_item('database', 'table_prefix') . "departments WHERE department_id = '" . $session->get('department_id') . "'");

//Department details
$department_details = array();

foreach ($db->query("SELECT * FROM " . config_item('database', 'table_prefix') . "departments WHERE department_id = '" . $session->get('department_id') . "'") as $row) {
	
	$department_details[] = $row;

}

//Check if the form has been submitted
if (isset($_POST['submit'])) {
	
	$validate->required($_POST['department_name'], translate('Please enter a department name.', TRUE));
	$validate->email($_POST['department_email'], translate('Please enter a department email address.', TRUE));
	
	if (!$error->has_errors()) {

		$values = array(
			'department_name'	=> filter_var($_POST['department_name'], FILTER_SANITIZE_STRING),
			'department_email'	=> filter_var($_POST['department_email'], FILTER_SANITIZE_EMAIL)
		); 			

		$where = array(
			'department_id' => $session->get('department_id')
		);

		$db->where($where);
		$db->update(config_item('database', 'table_prefix') . 'departments', $values);
		
		$session->set('success', TRUE);

		header("Location: departments.php");
		
	}

}

//Template values
$tpl->set('row_count', $row_count);
$tpl->set('department_details', $department_details);

//Display the template
$tpl->display('admin/edit_department');

?>
