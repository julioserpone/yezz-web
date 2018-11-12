<?php 

//Include the common file
require_once('../common.php');

//Include the administration file
require_once('admin.php');

//Check session
if (isset($_GET['language_id'])) {
	
	$session->set('language_id', $_GET['language_id']);
	
} else {

	header("Location: languages.php");
	
}

//Returns the number of rows
$row_count = $db->row_count("SELECT language_id FROM " . config_item('database', 'table_prefix') . "languages WHERE language_id = '" . $session->get('language_id') . "'");

//Language details
$language_details = array();

foreach ($db->query("SELECT * FROM " . config_item('database', 'table_prefix') . "languages WHERE language_id = '" . $session->get('language_id') . "'") as $row) {
	
	$language_details[] = $row;

}

//Check if the form has been submitted
if (isset($_POST['submit'])) {
	
	$validate->required($_POST['language_name'], translate('Please enter a language name.', TRUE));
	$validate->required($_POST['language_iso_code'], translate('Please enter a language code.', TRUE));
	
	if (!$error->has_errors()) {

		$values = array(
			'language_name'		=> filter_var($_POST['language_name'], FILTER_SANITIZE_STRING),
			'language_iso_code'	=> strtolower(filter_var($_POST['language_iso_code'], FILTER_SANITIZE_STRING))
		); 			

		$where = array(
			'language_id' => $session->get('language_id')
		);

		$db->where($where);
		$db->update(config_item('database', 'table_prefix') . 'languages', $values);
		
		$session->set('success', TRUE);

		header("Location: languages.php");
		
	}

}

//Template values
$tpl->set('row_count', $row_count);
$tpl->set('language_details', $language_details);

//Display the template
$tpl->display('admin/edit_language');

?>
