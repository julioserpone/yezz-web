<?php

//Include the common file
require_once('../common.php');

//Include the administration file
require_once('admin.php');

//Check session
if (isset($_GET['message_id'])) {
	
	$session->set('message_id', $_GET['message_id']);
	
} else {

	header("Location: canned_messages.php");
	
}

//Returns the number of rows
$row_count = $db->row_count("SELECT message_id FROM " . config_item('database', 'table_prefix') . "canned_messages WHERE message_id = '" . $session->get('message_id') . "'");

//Canned message details
$canned_message_details = array();

foreach ($db->query("SELECT * FROM " . config_item('database', 'table_prefix') . "canned_messages WHERE message_id = '" . $session->get('message_id') . "'") as $row) {
	
	$canned_message_details[] = $row;

}
	
//Check if the form has been submitted
if (isset($_POST['submit'])) {
	
	$validate->required($_POST['canned_message'], translate('Please enter a canned message.', TRUE));
	
	if (!$error->has_errors()) {

		$values = array(
			'canned_message' => filter_var($_POST['canned_message'], FILTER_SANITIZE_STRING)
		); 			

		$where = array(
			'message_id' => $session->get('message_id')
		);

		$db->where($where);
		$db->update(config_item('database', 'table_prefix') . 'canned_messages', $values);
		
		$session->set('success', TRUE);

		header("Location: canned_messages.php");
		
	}

}

//Template values
$tpl->set('row_count', $row_count);
$tpl->set('canned_message_details', $canned_message_details);

//Display the template
$tpl->display('admin/edit_canned_message');

?>
