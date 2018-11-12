<?php 

//Include the common file
require_once('../common.php');

//Include the administration file
require_once('admin.php');

//Check session
if (isset($_GET['group_id'])) {
	
	$session->set('group_id', $_GET['group_id']);
	
} else {

	header("Location: groups.php");

}

//Returns the number of rows
$row_count = $db->row_count("SELECT group_id FROM " . config_item('database', 'table_prefix') . "user_groups WHERE group_id = '" . $session->get('group_id') . "'");

//Group details
$group_details = array();

foreach ($db->query("SELECT * FROM " . config_item('database', 'table_prefix') . "user_groups WHERE group_id = '" . $session->get('group_id') . "'") as $row) {
	
	$group_details[] = array(
		'group_id' 			=> $row['group_id'],
		'group_name' 		=> $row['group_name'],
		'group_permissions' => unserialize($row['group_permissions'])
	);
	
}

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

		$where = array(
			'group_id' => $session->get('group_id')
		);

		$db->where($where);
		$db->update(config_item('database', 'table_prefix') . 'user_groups', $values);
		
		$session->set('success', TRUE);

		header("Location: groups.php");
		
	}

}

//Template values
$tpl->set('row_count', $row_count);
$tpl->set('group_details', $group_details);

//Display the template
$tpl->display('admin/edit_group');

?>
