<?php 

//Include the common file
require_once('../common.php');

//Include the administration file
require_once('admin.php');

//Delete session
if ($session->get('operator_id')) {
	
	$session->delete('operator_id');

}

//Returns the number of rows
$row_count = $db->row_count("SELECT operator_id FROM " . config_item('database', 'table_prefix') . "operators");

//Operators
$operators = array();

foreach ($db->query("SELECT *, CONCAT_WS(' ', first_name, last_name) AS full_name FROM " . config_item('database', 'table_prefix') . "operators") as $row) {
	
	if ($row['last_activity'] == 0) {
		
		$last_activity = '--';
		
	} else {
		
		$last_activity = date(get_option('date_format', TRUE) . ' ' . get_option('time_format', TRUE), $row['last_activity']);
	
	}
	
	$operators[] = array(
		'operator_id'	=> $row['operator_id'],
		'full_name'		=> $row['full_name'],
		'last_activity'	=> $last_activity
	);

}

//Check if the form has been submitted
if (isset($_POST['cb_operator'])) {
	
	foreach ($_POST['cb_operator'] as $value) {
		
		if ($value == $session->get('user_id')) {
			
			$error->set_error(translate('You can not delete your account!', TRUE));

		} else {
			
			$where = array(
				'operator_id' => filter_var($value, FILTER_SANITIZE_STRING)
			);
			
			$db->where($where);
			$db->delete(config_item('database', 'table_prefix') . 'operators');
			$db->delete(config_item('database', 'table_prefix') . 'department_operators');
			
			$authentication->delete_user($value);
			
			header("Location: operators.php");
			
		}
		
	}

}

//Template values
$tpl->set('row_count', $row_count);
$tpl->set('operators', $operators);

//Display the template
$tpl->display('admin/operators');

?>
