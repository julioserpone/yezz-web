<?php

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {

	require_once('../common.php');
	
	if (isset($_POST['action'])) {
		
		switch($_POST['action']) {

			case 'operator_get_online_departments':

				$chat->operator_get_online_departments(TRUE);
				
			break;

			case 'operator_get_online_visitors':
				
				$chat->operator_get_online_visitors(TRUE);
				
			break;

			case 'operator_get_pending_chat':
				
				$chat->operator_get_pending_chat(TRUE);
				
			break;
			
			case 'operator_get_status':

				$chat->operator_get_status(TRUE);
				
			break;

			case 'operator_start_chat':
			
				$chat->operator_start_chat($_POST['chat_id'], TRUE);

			break;
			
			case 'operator_open_chat':
				
				$chat->operator_open_chat($_POST['chat_id'], TRUE);
				
			break;
			
			case 'operator_watch_chat':
				
				$chat->operator_watch_chat($_POST['chat_id'], TRUE);
				
			break;

			case 'operator_stop_chat':
				
				$chat->operator_stop_chat(TRUE);
				
			break;
			
			case 'operator_send_message':
				
				if (check_token('form')) {
					
					$chat->operator_send_message($_POST['message'], TRUE);
					
				} else {
					
					$data = array(
						'success' => FALSE, 
						'content' => translate('Invalid security token!', TRUE)
					);
					
					echo json_encode($data);
					
				}
				
			break;
			
			case 'operator_typing':
				
				$chat->operator_typing($_POST['operator_typing'], TRUE);
				
			break;
			
			case 'operator_get_chat':

				$chat->operator_get_chat(TRUE);

			break;
			
			case 'operator_update_status':

				$chat->operator_update_status(TRUE);
				
			break;

			case 'operator_send_invitation':
				
				if (check_token('form')) {
					
					$chat->operator_send_invitation($_POST['ip_address'], $_POST['invitation_message'], TRUE);
					
				} else {
					
					$data = array(
						'success' => FALSE, 
						'content' => translate('Invalid security token!', TRUE)
					);
					
					echo json_encode($data);
					
				}
				
			break;
			
			case 'operator_transfer_chat':

				$chat->operator_transfer_chat($_POST['department_id'], TRUE);

			break;
			
		}
		
	}

} else {
	
	exit('No direct access allowed.');
	
}

?>
