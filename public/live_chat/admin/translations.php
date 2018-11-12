<?php 

//Include the common file
require_once('../common.php');

//Include the administration file
require_once('admin.php');

//Delete session
if ($session->get('language_id')) {
	
	$session->delete('language_id');

}

//Returns the number of rows
$row_count = $db->row_count("SELECT language_id FROM " . config_item('database', 'table_prefix') . "languages");

//Languages
$languages = array();

foreach ($db->query("SELECT * FROM " . config_item('database', 'table_prefix') . "languages") as $row) {
	
	$languages[] = array(
		'language_id'		=> $row['language_id'],
		'language_name'		=> $row['language_name']
	);

}

//Template values
$tpl->set('row_count', $row_count);
$tpl->set('languages', $languages);

//Display the template
$tpl->display('admin/translations');

?>
