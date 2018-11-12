<?php 

//Include the common file
require_once('../common.php');

//Include the administration file
require_once('admin.php');

//Check if the form has been submitted
if (isset($_POST['submit'])) {
	
	$validate->required($_POST['language_name'], translate('Please enter a language name.', TRUE));
	$validate->required($_POST['language_iso_code'], translate('Please enter a language code.', TRUE));
	
	if (!$error->has_errors()) {
		
		$values = array(
			'language_name'		=> filter_var($_POST['language_name'], FILTER_SANITIZE_STRING),
			'language_iso_code' => strtolower(filter_var($_POST['language_iso_code'], FILTER_SANITIZE_STRING))
		);		

		$db->insert(config_item('database', 'table_prefix') . 'languages', $values);
		
		$language_id = $db->last_insert_id();
		
		$values = array();
			
		foreach ($db->query("SELECT * FROM " . config_item('database', 'table_prefix') . "translations WHERE language_id = 1") as $row){
			
			$values = array(
				'language_id'		=> $language_id,
				'translation_key'	=> $row['translation_key'],
				'translation_text'	=> $row['translation_text']
			);
			
			$db->insert(config_item('database', 'table_prefix') . 'translations', $values);
			
		}
		
		$tpl->set('success', TRUE);
		
	}

}

//Display the template
$tpl->display('admin/add_language');

?>
