<?php 

//Include the common file
require_once('../common.php');

//Include the administration file
require_once('admin.php');

//Returns the number of rows
$row_count = $db->row_count("SELECT chat_id FROM " . config_item('database', 'table_prefix') . "chat WHERE chat_id = '" . $_GET['chat_id'] . "'");

//Chat details
$chat_details[] = $db->fetch_row_assoc("SELECT ip_address, email, referer, department_name FROM " . config_item('database', 'table_prefix') . "chat WHERE chat_id = '" . $_GET['chat_id'] . "'");

//Messages
$messages = array();

foreach ($db->query("SELECT m.message, m.operator_name, m.time, c.username FROM " . config_item('database', 'table_prefix') . "messages m JOIN " . config_item('database', 'table_prefix') . "chat c ON m.chat_id = c.chat_id WHERE m.chat_id = '" . $_GET['chat_id'] . "' ORDER BY m.message_id ASC") as $row) {
	
	if ($row['operator_name'] == '') {
		
		$name = $row['username'];
		
	} else {
	
		$name = $row['operator_name'];
	
	}

	$messages[] = array(
		'time'		=> date(get_option('time_format', true), $row['time']),
		'name'		=> $name,
		'message'	=> $row['message']
	);
	
}

//Template values
$tpl->set('row_count', $row_count);
$tpl->set('chat_details', $chat_details);
$tpl->set('messages', $messages);

//Display the template
$tpl->display('admin/view_chat');

?>
