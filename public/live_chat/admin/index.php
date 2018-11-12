<?php 

//Include the common file
require_once('../common.php');

//Include the administration file
require_once('admin.php');

//Canned messages
$canned_messages = array();

foreach ($db->query("SELECT canned_message FROM " . config_item('database', 'table_prefix') . "canned_messages") as $row) {

	$canned_messages[] = array(
		'canned_message' => $row['canned_message']
	);
	
}

//Template values
$tpl->set('canned_messages', $canned_messages);

//Display the template
$tpl->display('admin/index');

?>
