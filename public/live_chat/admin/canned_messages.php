<?php 

//Include the common file
require_once('../common.php');

//Include the administration file
require_once('admin.php');

//Delete session
if ($session->get('message_id')) {
	
	$session->delete('message_id');
	
}

//Returns the number of rows
$row_count = $db->row_count("SELECT message_id FROM " . config_item('database', 'table_prefix') . "canned_messages");

//Canned messages
$canned_messages = array();

foreach ($db->query("SELECT message_id, canned_message FROM " . config_item('database', 'table_prefix') . "canned_messages") as $row) {
	
	$canned_messages[] = array(
		'message_id'		=> $row['message_id'],
		'canned_message'	=> $row['canned_message']
	);

}

//Check if the form has been submitted
if (isset($_POST['cb_message'])) {
	
	foreach ($_POST['cb_message'] as $value) {
		
		if ($value != 1) {
			
			$where = array(
				'message_id' => filter_var($value, FILTER_SANITIZE_STRING)
			);
			
			$db->where($where);
			$db->delete(config_item('database', 'table_prefix') . 'canned_messages');

		}
		
	}
	
	header("Location: canned_messages.php");
	
}

//Template values
$tpl->set('row_count', $row_count);
$tpl->set('canned_messages', $canned_messages);

//Display the template
$tpl->display('admin/canned_messages');

?>
