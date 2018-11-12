<?php 

//Include the common file
require_once('../common.php');

//Include the administration file
require_once('admin.php');

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

//Check if the form has been submitted
if (isset($_POST['submit'])) {

	$validate->required($_POST['first_name'], translate('Please enter a operator name.', TRUE));
	$validate->email($_POST['user_email'], translate('Email address not valid.', TRUE));
	$validate->required($_POST['password'], translate('Please enter a password.', TRUE));
	$validate->matches($_POST['password'], $_POST['confirm_password'], translate('The password field does not match the confirm password field.', TRUE));
	
	if (empty($_POST['departments'])) {
		
		$error->set_error(translate('Please select a department.', TRUE));
		
	}
	
	if (!$error->has_errors()) {
		
		if ($authentication->check_email($_POST['user_email'])) {

			$additional_data = array(
				'first_name'	=> filter_var($_POST['first_name'], FILTER_SANITIZE_STRING),
				'last_name'		=> filter_var($_POST['last_name'], FILTER_SANITIZE_STRING)
			);

			$parameters = array(
				'user_status'	=> filter_var($_POST['user_status'], FILTER_SANITIZE_STRING),
				'group_id'		=> filter_var($_POST['group_id'], FILTER_SANITIZE_STRING)
			);	

			$authentication->create_user($_POST['user_email'], $_POST['password'], $additional_data, $parameters);
			
			$result = $db->fetch_row_assoc("SELECT user_id FROM " . config_item('database', 'table_prefix') . "users WHERE user_email = '" . filter_var($_POST['user_email'], FILTER_SANITIZE_EMAIL) . "'");
			
			$values = array(
				'user_id'		=> $result['user_id'],
				'first_name'	=> filter_var($_POST['first_name'], FILTER_SANITIZE_STRING),
				'last_name'		=> filter_var($_POST['last_name'], FILTER_SANITIZE_STRING)
			); 		

			if (isset($_POST['hide_online'])) {
				
				$values['hide_online'] = 1;
				
			} else {
			
				$values['hide_online'] = 0;
				
			}
			
			$db->insert(config_item('database', 'table_prefix') . 'operators', $values);
			
			$operator_id = $db->last_insert_id();
			
			if (isset($_POST['departments'])) {
				
				foreach ($_POST['departments'] as $value) {

					$values = array(
						'department_id'	=> filter_var($value, FILTER_SANITIZE_STRING),
						'operator_id'	=> $operator_id
					); 				
					
					$db->insert(config_item('database', 'table_prefix') . 'department_operators', $values);
					
				}
				
			}
			
			$tpl->set('success', TRUE);
		
		} else {
		
			$tpl->set('success', FALSE);
		
		}
		
	}

}

//Template values
$tpl->set('groups', $groups);
$tpl->set('departments', $departments);

//Display the template
$tpl->display('admin/add_operator');

?>
