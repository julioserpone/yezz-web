<?php

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {

	require_once('common.php');

	if (isset($_POST['action'])) {
		
		switch($_POST['action']) {

			case 'visitor_get_chat_status':

				$chat->visitor_get_chat_status(TRUE);

			break;

			case 'visitor_get_invitation_message':
				
				$chat->visitor_get_invitation_message(TRUE);
				
			break;

			case 'visitor_delete_invitation_message':

				$chat->visitor_delete_invitation_message(TRUE);

			break;

			case 'visitor_contact_operator':
				
				$chat->visitor_contact_operator(TRUE);
				
			break;
			
			case 'visitor_start_chat':
				
				if (check_token('form')) {
					
					$chat->visitor_start_chat($_POST['department_id'], $_POST['username'], $_POST['email'], $_POST['message'], TRUE);

				} else {
					
					$data = array(
						'success' => FALSE, 
						'content' => translate('Invalid security token!', TRUE)
					);
					
					echo json_encode($data);
					
				}

			break;
			
			case 'visitor_stop_chat':

				$chat->visitor_stop_chat(TRUE);
				
			break;
			
			case 'visitor_send_message':
				
				if (check_token('form')) {
					
					$chat->visitor_send_message($_POST['message'], TRUE);
					
				} else {
					
					$data = array(
						'success' => FALSE, 
						'content' => translate('Invalid security token!', TRUE)
					);
					
					echo json_encode($data);
					
				}
				
			break;

			case 'visitor_typing':

				$chat->visitor_typing($_POST['visitor_typing'], TRUE);
				
			break;

			case 'visitor_get_chat':
			
				$chat->visitor_get_chat(TRUE);
				
			break;
			
			case 'visitor_send_email':
				
				if (check_token('form')) {
					
					if (isset($_POST['department_id'])) {
						
						$chat->visitor_send_email($_POST['department_id'], $_POST['username'], $_POST['email'], $_POST['message'], TRUE);
					
					} else {
						
						$chat->visitor_send_email(FALSE, $_POST['username'], $_POST['email'], $_POST['message'], TRUE);
					
					}
					
				} else {
					
					$data = array(
						'success' => FALSE, 
						'content' => translate('Invalid security token!', TRUE)
					);
					
					echo json_encode($data);
					
				}
				
			break;
			
			case 'get_unique_id':
				
				$chat->get_unique_id($_POST['prefix'], TRUE);
				
			break;

		}
		
	}

} else {
	
	exit('No direct access allowed.');
	
}

?>
