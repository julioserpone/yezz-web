<?php 

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {

	//Include the common file
	require_once('common.php');

	//Template values
	$tpl->set('form_1', $chat->unique_id('form_1', TRUE));
	$tpl->set('form_2', $chat->unique_id('form_2', TRUE));
	
	//Display the template
	$tpl->display('live_chat');
	
	$chat->online_visitors();
	
} else {
	
	exit('No direct access allowed.');
	
}

?>

