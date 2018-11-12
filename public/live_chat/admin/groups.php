<?php 

//Include the common file
require_once('../common.php');

//Include the administration file
require_once('admin.php');

//Delete session
if ($session->get('group_id')) {
	
	$session->delete('group_id');
	
}

//Returns the number of rows
$row_count = $db->row_count("SELECT group_id FROM " . config_item('database', 'table_prefix') . "user_groups");

//Groups
$user_groups = array();

foreach ($db->query("SELECT group_id, group_name FROM " . config_item('database', 'table_prefix') . "user_groups") as $row) {
	
	$user_groups[] = array(
		'group_id'		=> $row['group_id'],
		'group_name'	=> $row['group_name']
	);

}

//Check if the form has been submitted
if (isset($_POST['cb_group'])) {
	
	foreach ($_POST['cb_group'] as $value) {

		if ($db->row_count("SELECT group_id FROM " . config_item('database', 'table_prefix') . "users WHERE group_id = '" . filter_var($value, FILTER_SANITIZE_STRING) . "'") > 0) {
			
			$result = $db->fetch_row_assoc("SELECT group_name FROM " . config_item('database', 'table_prefix') . "user_groups WHERE group_id = '" . filter_var($value, FILTER_SANITIZE_STRING) . "'");
			$error->set_error($result['group_name'] . ' - ' . translate('Cannot be deleted is currently assigned.', TRUE));
			
		} else {
			
			$where = array(
				'group_id' => filter_var($value, FILTER_SANITIZE_STRING)
			);
			
			$db->where($where);
			$db->delete(config_item('database', 'table_prefix') . 'user_groups');
			
			header("Location: groups.php");
			
		}
		
	}

}

//Template values
$tpl->set('row_count', $row_count);
$tpl->set('user_groups', $user_groups);

//Display the template
$tpl->display('admin/groups');

?>
