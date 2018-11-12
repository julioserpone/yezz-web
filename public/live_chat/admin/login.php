<?php 
//Include the common file
require_once('../common.php');

//Include the administration file
require_once('admin.php');

//Check if the form has been submitted
if (isset($_POST['login'])) {
	
	$validate->email($_POST['email1'], translate('Email address not valid.', TRUE));
	$validate->required($_POST['password'], translate('Please enter a password.', TRUE));

	if (!$error->has_errors()) {

		$remember = FALSE;
		
		if (isset($_POST['remember'])) {
			
			$remember = TRUE;
			
		}
		
		if ($authentication->login($_POST['email1'], $_POST['password'], $remember)) {
			
			header("Location: index.php");
			
		} else {
			
			$tpl->set('success', FALSE);
			
		}
		
	}
	
}

//Check if the form has been submitted
if (isset($_POST['reset_password'])) {

	$validate->email($_POST['email2'], translate('Email address not valid.', TRUE));
	
	if (!$error->has_errors()) {
		
		if ($authentication->new_password($_POST['email2'])) {

			$tpl->set('success', TRUE);
			
		} else {
			
			$tpl->set('success', FALSE);
			
		}
		
	}

}

//Display the template
$tpl->display('admin/login');

?>
