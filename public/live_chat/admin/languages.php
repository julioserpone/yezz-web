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
		'language_name'		=> $row['language_name'],
		'language_iso_code'	=> $row['language_iso_code']
	);

}

//Check if the form has been submitted
if (isset($_POST['cb_language'])) {
	
	foreach ($_POST['cb_language'] as $value) {
		
		if ($value != 1) {
			
			$where = array(
				'language_id' => filter_var($value, FILTER_SANITIZE_STRING)
			);
			
			$db->where($where);
			$db->delete(config_item('database', 'table_prefix') . 'languages');
			
			$where = array(
				'language_id' => filter_var($value, FILTER_SANITIZE_STRING)
			);
			
			$db->where($where);
			$db->delete(config_item('database', 'table_prefix') . 'translations');
		
		}

	}
	
	header("Location: languages.php");
	
}

//Template values
$tpl->set('row_count', $row_count);
$tpl->set('languages', $languages);

//Display the template
$tpl->display('admin/languages');

?>
