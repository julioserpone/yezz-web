<?php 

//Include the common file
require_once('../common.php');

//Include the administration file
require_once('admin.php');

//Check if the form has been submitted
if (isset($_POST['submit'])) {
	
	$validate->required($_POST['canned_message'], translate('Please enter a canned message.', TRUE));
	
	if (!$error->has_errors()) {
		
		$values = array(
			'canned_message' => filter_var($_POST['canned_message'], FILTER_SANITIZE_STRING)
		); 			

		$db->insert(config_item('database', 'table_prefix') . 'canned_messages', $values);
		
		$tpl->set('success', TRUE);
		
	}

}

//Display the template
$tpl->display('admin/add_canned_message');

?>
