<?php 

//Include the common file
require_once('../common.php');

//Include the administration file
require_once('admin.php');

//Delete session
if ($session->get('department_id')) {

	$session->delete('department_id');

}

//Returns the number of rows
$row_count = $db->row_count("SELECT department_id FROM " . config_item('database', 'table_prefix') . "departments");

//Departments
$departments = array();

foreach ($db->query("SELECT * FROM " . config_item('database', 'table_prefix') . "departments") as $row) {
	
	$departments[] = array(
		'department_id'		=> $row['department_id'],
		'department_name'	=> $row['department_name'],
		'department_email'	=> $row['department_email']
	);

}

//Check if the form has been submitted
if (isset($_POST['cb_department'])) {
	
	foreach ($_POST['cb_department'] as $value) {
		
		if ($db->row_count("SELECT department_id FROM " . config_item('database', 'table_prefix') . "department_operators WHERE department_id = '" . filter_var($value, FILTER_SANITIZE_STRING) . "'") > 0) {
			
			$result = $db->fetch_row_assoc("SELECT department_name FROM " . config_item('database', 'table_prefix') . "departments WHERE department_id = '" . filter_var($value, FILTER_SANITIZE_STRING) . "'");
			$error->set_error($result['department_name'] . ' - ' . translate('Cannot be deleted is currently assigned.', TRUE));
			
		} else {
			
			$where = array(
				'department_id' => filter_var($value, FILTER_SANITIZE_STRING)
			);
			
			$db->where($where);
			$db->delete(config_item('database', 'table_prefix') . 'departments');
			
			header("Location: departments.php");
			
		}

	}
	
}

//Template values
$tpl->set('row_count', $row_count);
$tpl->set('departments', $departments);

//Display the template
$tpl->display('admin/departments');

?>
