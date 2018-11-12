<?php 

//Include the common file
require_once('../common.php');

//Include the administration file
require_once('admin.php');

//Returns the number of rows
$row_count = $db->row_count("SELECT chat_id FROM " . config_item('database', 'table_prefix') . "chat");

//Pagination
if (isset($_GET['page'])) {
	
	$current_page = trim($_GET['page']);
	
} else {

	$current_page = 1;
	
}

$start = ($current_page - 1) * get_option('records_per_page', TRUE); 	

$sql = "SELECT chat_id, username, department_name, ip_address, time_start, time_end FROM " . config_item('database', 'table_prefix') . "chat WHERE time_end != 0";

$sql .= " ORDER BY chat_id DESC";

$sql .= " LIMIT " . $start . ", " . get_option('records_per_page', TRUE);

$pages = ceil($db->row_count("SELECT chat_id FROM " . config_item('database', 'table_prefix') . "chat ") / get_option('records_per_page', TRUE));

//Chat history
$chat_history = array();
 
foreach ($db->query($sql) as $row) {
	
	$chat_history[] = array(
		'chat_id'			=> $row['chat_id'],
		'username'			=> $row['username'],
		'ip_address'		=> $row['ip_address'],
		'elapsed_time'		=> elapsed_time($row['time_end'], $row['time_start']),
		'department_name'	=> $row['department_name']
	);

}

//Check if the form has been submitted
if (isset($_POST['cb_chat'])) {
	
	foreach ($_POST['cb_chat'] as $value) {

		$where = array(
			'chat_id' => filter_var($value, FILTER_SANITIZE_STRING)
		);
		
		$db->where($where);
		$db->delete(config_item('database', 'table_prefix') . 'chat');
		$db->delete(config_item('database', 'table_prefix') . 'messages');
		
	}
	
	header("Location: chat_history.php");
	
}

//Template values
$tpl->set('row_count', $row_count);
$tpl->set('current_page', $current_page);
$tpl->set('pages', $pages);
$tpl->set('chat_history', $chat_history);

//Display the template
$tpl->display('admin/chat_history');

?>
