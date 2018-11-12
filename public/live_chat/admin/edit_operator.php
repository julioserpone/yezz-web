<?php 

//Include the common file
require_once('../common.php');

//Include the administration file
require_once('admin.php');

//Check session
if (isset($_GET['operator_id'])) {

	$session->set('operator_id', $_GET['operator_id']);
	
} else {

	header("Location: operators.php");

}

//Returns the number of rows
$row_count = $db->row_count("SELECT operator_id FROM " . config_item('database', 'table_prefix') . "operators WHERE operator_id = '" . $session->get('operator_id') . "'");

//Groups
$groups = array();

foreach ($db->query("SELECT group_id, group_name FROM " . config_item('database', 'table_prefix') . "user_groups") as $row) {
	
	$groups[] = array(
		'group_id'		=> $row['group_id'],
		'group_name'	=> $row['group_name']
	);

}

//Departments
$departments = array();

foreach ($db->query("SELECT department_id, department_name FROM " . config_item('database', 'table_prefix') . "departments") as $row) {

	$departments[] = array(
		'department_id'		=> $row['department_id'],
		'department_name'	=> $row['department_name']
	);
	
}

//Department operators
$department_operators = array();

foreach ($db->query("SELECT department_id FROM " . config_item('database', 'table_prefix') . "department_operators WHERE operator_id = '" . $session->get('operator_id') . "'") as $row) {
	
	array_push($department_operators, $row['department_id']);

}

//Operator details
$operator_details = array();

foreach ($db->query("SELECT * FROM " . config_item('database', 'table_prefix') . "operators o JOIN " . config_item('database', 'table_prefix') . "users u ON o.user_id = u.user_id WHERE o.operator_id = '" . $session->get('operator_id') . "'") as $row) {
	
	$operator_details[] = $row;

}
	
//Check if the form has been submitted
if (isset($_POST['submit'])) {
	
	$validate->required($_POST['first_name'], translate('Please enter a operator name.', TRUE));

	if (!empty($_POST['password'])) {
		
		$validate->required($_POST['password'], translate('Please enter a password.', TRUE));
		$validate->matches($_POST['password'], $_POST['confirm_password'], translate('The password field does not match the confirm password field.', TRUE));
	
	}

	if (empty($_POST['departments'])) {
		
		$error->set_error(translate('Please select a department.', true));
		
	}
	
	if (!$error->has_errors()) {

		$result = $db->fetch_row_assoc("SELECT o.user_id, u.user_email FROM " . config_item('database', 'table_prefix') . "operators o JOIN " . config_item('database', 'table_prefix') . "users u ON o.user_id = u.user_id WHERE o.operator_id = '" . $session->get('operator_id') . "'");
		
		if ($result['user_email'] == filter_var($_POST['user_email'], FILTER_SANITIZE_EMAIL)) {
			
			$success = TRUE;
			
		} elseif (!$authentication->check_email($_POST['user_email'])) {
			
			$tpl->set('success', FALSE);
			
			$success = FALSE;
			
		} else {
			
			$success = TRUE;
			
		}
		
		if ($success) {
			
			$additional_data = array(
				'first_name'	=> filter_var($_POST['first_name'], FILTER_SANITIZE_STRING),
				'last_name' 	=> filter_var($_POST['last_name'], FILTER_SANITIZE_STRING)
			);

			$parameters = array(
				'user_status' 	=> filter_var($_POST['user_status'], FILTER_SANITIZE_STRING),
				'group_id'		=> filter_var($_POST['group_id'], FILTER_SANITIZE_STRING)
			);
			
			if (!empty($_POST['password'])) {
				
				$password = $_POST['password'];
				
			} else {
			
				$password = FALSE;
			
			}

			$authentication->update_user($result['user_id'], $_POST['user_email'], $password, $additional_data, $parameters);
			
			$values = array(
				'first_name'	=> filter_var($_POST['first_name'], FILTER_SANITIZE_STRING),
				'last_name'		=> filter_var($_POST['last_name'], FILTER_SANITIZE_STRING)
			); 			

			if (isset($_POST['hide_online'])) {
				
				$values['hide_online'] = 1;
				
			} else {
			
				$values['hide_online'] = 0;
				
			}
			
			$where = array(
				'user_id' => $result['user_id']
			);

			$db->where($where);
			$db->update(config_item('database', 'table_prefix') . 'operators', $values);

			if (isset($_POST['departments'])) {

				$where = array(
					'operator_id' => $session->get('operator_id')
				);
				
				$db->where($where);
				$db->delete(config_item('database', 'table_prefix') . 'department_operators', $values);
				
				foreach ($_POST['departments'] as $value) {

					$values = array(
						'department_id'	=> filter_var($value, FILTER_SANITIZE_STRING),
						'operator_id'	=> $session->get('operator_id')
					); 				
					
					$db->insert(config_item('database', 'table_prefix') . 'department_operators', $values);
					
				}
				
			}

			$session->set('success', TRUE);

			header("Location: operators.php");

		}
		
	}

}

//Template values
$tpl->set('row_count', $row_count);
$tpl->set('groups', $groups);
$tpl->set('departments', $departments);
$tpl->set('department_operators', $department_operators);
$tpl->set('operator_details', $operator_details);

//Display the template
$tpl->display('admin/edit_operator');

?>
