<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) exit('No direct access allowed.');

//Check if the user is logged in
if (!$authentication->logged_in() && basename($_SERVER["PHP_SELF"]) != 'login.php') {
	
	header("Location: login.php");
	
} elseif ($authentication->logged_in() && basename($_SERVER["PHP_SELF"]) == 'login.php') {

	header("Location: index.php");

}

//Check permissions
if ($authentication->logged_in()) {

	$pages = array(
		'Home page' 		=> array('index.php'),
		'Chat history' 		=> array('chat_history.php', 'view_chat.php'),
		'Canned messages' 	=> array('canned_messages.php', 'add_canned_message.php', 'edit_canned_message.php'),
		'Departments' 		=> array('departments.php', 'add_department.php', 'edit_department.php'),
		'Operators' 		=> array('operators.php', 'add_operator.php', 'edit_operator.php'),
		'Groups' 			=> array('groups.php', 'add_group.php', 'edit_group.php'),
		'Languages' 		=> array('languages.php', 'add_language.php', 'edit_language.php'),
		'Translations' 		=> array('translations.php', 'edit_translation.php'),
		'Blocked visitors'	=> array('blocked_visitors.php'),
		'Access logs' 		=> array('access_logs.php'),
		'Settings' 			=> array('settings.php')
	);
	
	$result = $db->fetch_row_assoc("SELECT group_name FROM " . config_item('database', 'table_prefix') . "users u JOIN " . config_item('database', 'table_prefix') . "user_groups ug ON u.group_id = ug.group_id WHERE u.user_id = '" . $session->get('user_id') . "'");
	
	foreach ($pages as $key => $value1) {
		
		foreach ($value1 as $value2) {

			if ($value2 == basename($_SERVER["PHP_SELF"])) {

				$result = $db->fetch_row_assoc("SELECT group_permissions FROM " . config_item('database', 'table_prefix') . "user_groups WHERE group_name = '" . $result['group_name'] . "'");
				
				$permissions = unserialize($result['group_permissions']);

				if (!in_array($key, $permissions)) {

					header("Location: permission_denied.php");
					
				}
				
			}
			
		}

	}

	$tpl->set('pages', $pages);
	
}

//Check token
if (!empty($_POST)) {
	
	if (!check_token('form')) {
		
		die(translate('Invalid security token!', TRUE));
		
	}
	
}

//Logout
if (isset($_GET['logout']) && !$_POST) {
	
	$authentication->logout();

	header("Location: login.php");

}

?>
