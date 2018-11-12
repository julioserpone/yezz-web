<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) exit('No direct access allowed.');

/** 
 * Chat class
 */ 
class Chat {

	/**
	 * Database
	 * 
	 * @access private
	 */
	private $db;

	/**
	 * Session
	 * 
	 * @access private
	 */
	private $session;

	/**
	 * Template
	 * 
	 * @access private
	 */
	private $tpl;

	/**
	 * Constructor
	 * 
	 * @access public
	 */
	public function __construct() {
		
		$this->db = new Database();
		$this->session = new Session();
		$this->tpl = new Template();
		
	}

	/**
	 * Visitor get chat status
	 * 
	 * @access public
	 */
	public function visitor_get_chat_status($json = FALSE) {

		$result = $this->db->fetch_row_assoc("SELECT MAX(last_activity) AS last_activity FROM " . config_item('database', 'table_prefix') . "operators WHERE hide_online = 0");
		
		$total = time() - $result['last_activity'];

		if ($this->session->get('visitor_chat_id')) {
			
			$result = $this->db->fetch_row_assoc("SELECT department_name FROM " . config_item('database', 'table_prefix') . "chat WHERE chat_id = '" . $this->session->get('visitor_chat_id') . "'");
			
			$data = array(
				'success' => TRUE, 
				'content' => translate('Chat started with -', TRUE) . $result['department_name']
			);

		} elseif ($total > get_option('online_timeout', TRUE)  || $this->count_visitors() >= get_option('max_visitors', TRUE)) {

			$data = array(
				'success' => FALSE, 
				'content' => translate('Contact us - Offline', TRUE)
			);

		} else {

			$data = array(
				'success' => TRUE, 
				'content' => translate('We are online, chat with us!', TRUE)
			);

		}
		
		if ($json) {
			
			echo json_encode($data);
			
		} else {
		
			return $data;
			
		}

	}

	/**
	 * Visitor get invitation message
	 * 
	 * @access public
	 */
	public function visitor_get_invitation_message($json = FALSE) {

		$result = $this->db->fetch_row_assoc("SELECT invitation_message FROM " . config_item('database', 'table_prefix') . "online_visitors WHERE ip_address = '" . $_SERVER['REMOTE_ADDR'] . "'");

		if (!empty($result['invitation_message'])) {
			
			$data = array(
				'success' 				=> TRUE, 
				'invitation_message' 	=> $result['invitation_message']
			);
			
		} else {

			$data = array(
				'success' => FALSE
			);
			
		}

		if ($json) {
			
			echo json_encode($data);
			
		} else {
		
			return $data;
			
		}

	}

	/**
	 * Visitor delete invitation message
	 * 
	 * @access public
	 */
	public function visitor_delete_invitation_message($json = FALSE) {
		
		if ($this->db->row_count("SELECT ip_address FROM " . config_item('database', 'table_prefix') . "online_visitors WHERE ip_address = '" . $_SERVER['REMOTE_ADDR'] . "'") > 0) {
			
			$values = array(
				'invitation_message' => ''
			); 			

			$where = array(
				'ip_address' => $_SERVER['REMOTE_ADDR']
			);

			$this->db->where($where);
			$this->db->update(config_item('database', 'table_prefix') . 'online_visitors', $values);
			
			$data = array(
				'success' => TRUE
			);
		
		} else {
			
			$data = array(
				'success' => FALSE
			);
			
		}
	
		if ($json) {
			
			echo json_encode($data);
			
		} else {
		
			return $data;
			
		}

	}

	/**
	 * Visitor contact operator
	 * 
	 * @access public
	 */
	public function visitor_contact_operator($json = FALSE) {

		if ($this->db->row_count("SELECT ip_address FROM " . config_item('database', 'table_prefix') . "blocked_visitors WHERE ip_address = '" . $_SERVER['REMOTE_ADDR'] . "'") > 0) {

			$data = array(
				'success' => FALSE, 
				'content' => $this->tpl->display('ban', TRUE)
			);

		} else {

			$result = $this->db->fetch_row_assoc("SELECT MAX(last_activity) AS last_activity FROM " . config_item('database', 'table_prefix') . "operators WHERE hide_online = 0");
			
			$total = time() - $result['last_activity'];

			if ($this->session->get('visitor_chat_id')) {

				$result = $this->db->fetch_row_assoc("SELECT department_name FROM " . config_item('database', 'table_prefix') . "chat WHERE chat_id = '" . $this->session->get('visitor_chat_id') . "'");

				$data = array(
					'success' => TRUE,
					'content' => $this->tpl->display('chat', TRUE),
					'department_name' => translate('Chat started with -', TRUE) . $result['department_name']
				);

			} elseif ($total > get_option('online_timeout', TRUE) || $this->count_visitors() >= get_option('max_visitors', TRUE)) {

				$sql = "SELECT d.department_id, d.department_name FROM " . config_item('database', 'table_prefix') . "departments d JOIN " . config_item('database', 'table_prefix') . "department_operators do ON d.department_id = do.department_id GROUP BY d.department_name ORDER BY d.department_name ASC";
				
				$departments = array();
				
				foreach ($this->db->query($sql) as $row) {
					
					$departments[] = array(
						'department_id'		=> $row['department_id'],
						'department_name'	=> $row['department_name']
					);
					
				}

				$this->tpl->set('departments', $departments);

				$data = array(
					'success' => FALSE, 
					'content' => $this->tpl->display('offline', TRUE)
				);

			} else {

				$sql = "SELECT MAX(o.last_activity) AS last_activity, d.department_id, d.department_name FROM " . config_item('database', 'table_prefix') . "operators o JOIN " . config_item('database', 'table_prefix') . "department_operators do ON o.operator_id = do.operator_id JOIN " . config_item('database', 'table_prefix') . "departments d ON do.department_id = d.department_id WHERE o.hide_online = 0 GROUP BY d.department_name ORDER BY o.last_activity DESC";
				
				$departments = array();
				
				foreach ($this->db->query($sql) as $row) {
					
					$total = time() - $row['last_activity'];
					
					$departments[] = array(
						'total'				=> $total,
						'online_timeout'	=> get_option('online_timeout', TRUE),
						'department_id'		=> $row['department_id'],
						'department_name'	=> $row['department_name']
					);
					
				}
				
				$this->tpl->set('departments', $departments);

				$data = array(
					'success' => FALSE, 
					'content' => $this->tpl->display('online', TRUE)
				);

			}
			
		}

		if ($json) {
			
			echo json_encode($data);
			
		} else {
		
			return $data;
			
		}

	}

	/**
	 * Visitor start chat
	 * 
	 * @access public
	 */
	public function visitor_start_chat($department_id, $username, $email, $message, $json = FALSE) {
		
		$department_id = filter_var($department_id, FILTER_SANITIZE_STRING);
		$username = filter_var($username, FILTER_SANITIZE_STRING);
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		$message = filter_var($message, FILTER_SANITIZE_STRING);
		
		$result = $this->db->fetch_row_assoc("SELECT MAX(o.last_activity) AS last_activity FROM " . config_item('database', 'table_prefix') . "operators o JOIN " . config_item('database', 'table_prefix') . "department_operators do ON do.department_id = '" . $department_id . "' WHERE o.hide_online = 0 AND do.operator_id = o.operator_id");

		$total = time() - $result['last_activity'];

		if ($total > get_option('online_timeout', TRUE) || $this->count_visitors() >= get_option('max_visitors', TRUE)) {

			$sql = "SELECT d.department_id, d.department_name FROM " . config_item('database', 'table_prefix') . "departments d JOIN " . config_item('database', 'table_prefix') . "department_operators do ON d.department_id = do.department_id GROUP BY d.department_name ORDER BY d.department_name ASC";
			
			$departments = array();
			
			foreach ($this->db->query($sql) as $row) {
				
				$departments[] = array(
					'department_id'		=> $row['department_id'],
					'department_name'	=> $row['department_name']
				);
				
			}

			$this->tpl->set('departments', $departments);
			
			$data = array(
				'success' => FALSE, 
				'content' => $this->tpl->display('offline', TRUE), 
				'message' => translate('Contact us - Offline', TRUE)
			);

		} elseif ($this->db->row_count("SELECT ip_address FROM " . config_item('database', 'table_prefix') . "chat WHERE ip_address = '" . $_SERVER['REMOTE_ADDR'] . "' AND chat_status = 0 OR chat_status = 2") >= get_option('max_connections', TRUE)) {

			$data = array(
				'success' => FALSE, 
				'content' => translate('Too many requests are being made from your IP address.', TRUE), 
				'message' => translate('We are online, chat with us!', TRUE)
			);

		} else {

			if ($this->session->get('chat_hash')) {

				$chat_hash = $this->session->get('chat_hash');
				
			} else { 

				$chat_hash = uniqid();
				$this->session->set('chat_hash', $chat_hash);
				
			}

			if (!$this->session->get('username')) {
				
				$this->session->set('username', $username);
				
			}
			
			if ($this->db->row_count("SELECT chat_hash FROM " . config_item('database', 'table_prefix') . "chat WHERE chat_hash = '" . $chat_hash . "'") > 0) {

				$result = $this->db->fetch_row_assoc("SELECT chat_id FROM " . config_item('database', 'table_prefix') . "chat WHERE chat_hash = '" . $chat_hash . "'");
				
				$values = array(
					'chat_id'	=> $result['chat_id'],
					'message'	=> $message,
					'time'		=> time()
				); 			

				$this->db->insert(config_item('database', 'table_prefix') . 'messages', $values);
				
			} else {
				
				$result = $this->db->fetch_row_assoc("SELECT department_name FROM " . config_item('database', 'table_prefix') . "departments WHERE department_id = '" . $department_id . "'");
				
				$values = array(
					'chat_status'			=> 0,
					'chat_hash'				=> $chat_hash,
					'time_start'			=> time(),
					'last_activity'			=> time(),
					'ip_address'			=> $_SERVER['REMOTE_ADDR'],
					'email'					=> $email,
					'username'				=> $this->session->get('username'),
					'referer'				=> $_SERVER['HTTP_REFERER'],
					'department_name'		=> $result['department_name'],
					'department_id'			=> $department_id
				); 			

				$this->db->insert(config_item('database', 'table_prefix') . 'chat', $values);

				$chat_id = $this->db->last_insert_id();

				$values = array(
					'chat_id'	=> $chat_id,
					'message'	=> $message,
					'time'		=> time()
				); 			

				$this->db->insert(config_item('database', 'table_prefix') . 'messages', $values);

			}

			if (!$this->session->get('visitor_chat_id')) {
				
				$this->session->set('visitor_chat_id', $chat_id);
				
			}
			
			$result = $this->db->fetch_row_assoc("SELECT department_name FROM " . config_item('database', 'table_prefix') . "departments WHERE department_id = '" . $department_id . "'");

			$data = array(
				'success' => TRUE,
				'content' => $this->tpl->display('chat', TRUE),
				'department_name' => translate('Chat started with -', TRUE) . $result['department_name']
			);

		}

		if ($json) {
			
			echo json_encode($data);
			
		} else {
		
			return $data;
			
		}

	}

	/**
	 * Visitor stop chat
	 * 
	 * @access public
	 */
	public function visitor_stop_chat($json = FALSE) {

		$result = $this->db->fetch_row_assoc("SELECT chat_status FROM " . config_item('database', 'table_prefix') . "chat WHERE chat_id = '" . $this->session->get('visitor_chat_id') . "'");

		$values = array(
			'chat_status' => 3
		); 			

		if ($result['chat_status'] != 3) {
			
			$values['time_end'] = time();
			
		}
		
		$where = array(
			'chat_id' => $this->session->get('visitor_chat_id')
		);

		$this->db->where($where);
		$this->db->update(config_item('database', 'table_prefix') . 'chat', $values);

		$values = array(
			'chat_id'	=> $this->session->get('visitor_chat_id'),
			'message'	=> translate('User has left the chat', TRUE),
			'time'		=> time()
		); 			

		$this->db->insert(config_item('database', 'table_prefix') . 'messages', $values);

		$this->session->delete('username');
		$this->session->delete('chat_hash');
		$this->session->delete('operator_last_message_id[' . $this->session->get('visitor_chat_id') . ']');
		$this->session->delete('visitor_chat_id');
		
		$data = array('success' => TRUE);
		
		if ($json) {
			
			echo json_encode($data);
			
		} else {
		
			return $data;
			
		}

	}

	/**
	 * Visitor send message
	 * 
	 * @access public
	 */
	public function visitor_send_message($message, $json = FALSE) {

		$message = filter_var($message, FILTER_SANITIZE_STRING);
		
		if ($this->session->get('visitor_chat_id')) {
			
			$values = array(
				'chat_id'	=> $this->session->get('visitor_chat_id'),
				'message'	=> $message,
				'time'		=> time()
			); 			

			$this->db->insert(config_item('database', 'table_prefix') . 'messages', $values);

			$values = array(
				'user_typing'	=> 0,
				'last_activity'	=> time()
			); 			

			$where = array(
				'chat_id' => $this->session->get('visitor_chat_id')
			);

			$this->db->where($where);
			$this->db->update(config_item('database', 'table_prefix') . 'chat', $values);
			
			$data = array(
				'success' => TRUE
			);
			
		} else {
			
			$data = array(
				'success' => FALSE
			);
			
		}

		if ($json) {
			
			echo json_encode($data);
			
		} else {
		
			return $data;
			
		}

	}

	/**
	 * Visitor typing
	 * 
	 * @access public
	 */
	public function visitor_typing($visitor_typing, $json = FALSE) {
		
		$visitor_typing = filter_var($visitor_typing, FILTER_SANITIZE_STRING);
		
		if ($this->session->get('visitor_chat_id')) {
			
			$values = array(
				'user_typing' => $visitor_typing
			); 			

			$where = array(
				'chat_id' => $this->session->get('visitor_chat_id')
			);

			$this->db->where($where);
			$this->db->update(config_item('database', 'table_prefix') . 'chat', $values);
			
			$data = array(
				'success' => TRUE
			);
			
		} else {
			
			$data = array(
				'success' => FALSE
			);
			
		}

		if ($json) {
			
			echo json_encode($data);
			
		} else {
		
			return $data;
			
		}

	}

	/**
	 * Visitor get chat
	 * 
	 * @access public
	 */
	public function visitor_get_chat($json = FALSE) {

		$result = $this->db->fetch_row_assoc("SELECT last_activity FROM " . config_item('database', 'table_prefix') . "chat WHERE chat_id = '" . $this->session->get('visitor_chat_id') . "'");
		
		$total = time() - $result['last_activity'];
		
		if ($total > get_option('chat_expire', TRUE)) {

			$this->session->delete('username');
			$this->session->delete('chat_hash');
			$this->session->delete('operator_last_message_id[' . $this->session->get('visitor_chat_id') . ']');
			$this->session->delete('visitor_chat_id');
			
			$data = array(
				'success' => FALSE
			);
			
		} else {

			$sql = "SELECT m.message, m.time, m.operator_name, c.username, c.email FROM " . config_item('database', 'table_prefix') . "messages m JOIN " . config_item('database', 'table_prefix') . "chat c ON m.chat_id = c.chat_id WHERE m.chat_id = '" . $this->session->get('visitor_chat_id') . "' ORDER BY m.message_id ASC";

			if ($this->db->row_count($sql) > 0) {
				
				$messages = array();
				
				foreach ($this->db->query($sql) as $row) {
					
					if ($row['operator_name'] == '') {
						
						$name = $row['username'] . ' (' . $row['email'] . ')';
						
					} else {
					
						$name = $row['operator_name'];
						
					}
					
					$messages[] = array(
						'message'	=> $row['message'],
						'name'		=> $name,
						'time'		=> date(get_option('time_format', TRUE), $row['time'])
					);
					
				}
				
				$this->tpl->set('messages', $messages);

				$data = array(
					'success' => TRUE, 
					'content' => $this->tpl->display('chat_messages', TRUE)
				);
				
			} else {
				
				$data = array(
					'success' => FALSE
				);
				
			}

			$result = $this->db->fetch_row_assoc("SELECT chat_status, operator_typing FROM " . config_item('database', 'table_prefix') . "chat WHERE chat_id = '" . $this->session->get('visitor_chat_id') . "'");

			if ($result['chat_status'] == 0) {
				
				$data['queue'] = 0;
				
			} else {
			
				$data['queue'] = 1;
				
			}

			if ($result['operator_typing']) {
				
				$data['operator_typing'] = 1;
				
			} else {
				
				$data['operator_typing'] = 0;
				
			}
			
			$result = $this->db->fetch_row_assoc("SELECT message_id FROM " . config_item('database', 'table_prefix') . "messages WHERE chat_id = '" . $this->session->get('visitor_chat_id') . "' ORDER BY message_id DESC LIMIT 1");
		
			$data['last_id'] = $result['message_id'];

			if (!$this->session->get('operator_last_message_id[' . $this->session->get('visitor_chat_id') . ']')) {
				
				$this->session->set('operator_last_message_id[' . $this->session->get('visitor_chat_id') . ']', 0);
			
			}
			
			if ($result['message_id'] > $this->session->get('operator_last_message_id[' . $this->session->get('visitor_chat_id') . ']')) {
				
				$data['new_message'] = 1;
				$this->session->set('operator_last_message_id[' . $this->session->get('visitor_chat_id') . ']', $result['message_id']);

			}
			
		}

		if ($json) {
			
			echo json_encode($data);
			
		} else {
		
			return $data;
			
		}

	}

	/**
	 * Visitor send email
	 * 
	 * @access public
	 */
	public function visitor_send_email($department_id, $username, $email, $message, $json = FALSE) {

		$department_id = filter_var($department_id, FILTER_SANITIZE_STRING);
		$username = filter_var($username, FILTER_SANITIZE_STRING);
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		$message = filter_var($message, FILTER_SANITIZE_STRING);

		if ($department_id) {
			
			$result = $this->db->fetch_row_assoc("SELECT department_name, department_email FROM " . config_item('database', 'table_prefix') . "departments WHERE department_id = '" . $department_id . "'");
			
			$values = array(
				'chat_status'			=> 1,
				'chat_hash'				=> uniqid(),
				'time_start'			=> time(),
				'time_end'				=> time(),
				'ip_address'			=> $_SERVER['REMOTE_ADDR'],
				'email'					=> $email,
				'username'				=> $username,
				'referer'				=> $_SERVER['HTTP_REFERER'],
				'department_name'		=> $result['department_name']
			); 			

			$this->db->insert(config_item('database', 'table_prefix') . 'chat', $values);

			$chat_id = $this->db->last_insert_id();

			$values = array(
				'chat_id'	=> $chat_id,
				'message'	=> $message,
				'time'		=> time()
			); 			

			$this->db->insert(config_item('database', 'table_prefix') . 'messages', $values);

			$headers  = 'From: ' . get_option('site_title', TRUE) . '<' . $result['department_email'] . '>' . "\r\n";
			$headers .=	'Reply-To: ' . $email . "\r\n";
			$headers .=	'X-Mailer: PHP/' . phpversion() . "\r\n";
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=' . get_option('charset', TRUE) . "\r\n";
			
			$to = $result['department_email'];
			
		} else {

			$headers  = 'From: ' . get_option('site_title', TRUE) . '<' . get_option('admin_email', TRUE) . '>' . "\r\n";
			$headers .=	'Reply-To: ' . $email . "\r\n";
			$headers .=	'X-Mailer: PHP/' . phpversion() . "\r\n";
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=' . get_option('charset', TRUE) . "\r\n";
			
			$to = get_option('admin_email', TRUE);
			
		}
		
		$email_message = '<html><head></head><body>' . sprintf(translate('<p>You have a message from %s:</p><p>%s</p><p>Name: %s<br>Email: %s<br>IP: %s</p><p>Regards,<br><br>%s</p>', TRUE), $username, $message, $username, $email, $_SERVER['REMOTE_ADDR'], get_option('site_title', TRUE)) . '</body></html>';

		if (mail($to, translate('Question from', TRUE) . $username, html_entity_decode($email_message, ENT_QUOTES), $headers)) {
			
			$data = array(
				'success' => TRUE, 
				'content' => translate('Thank you for your message. We will answer your question by email as soon as possible.', TRUE)
			);
			
		} else {
			
			$data = array(
				'success' => FALSE, 
				'content' => translate('Error sending email, try again later.', TRUE)
			);

		}	

		if ($json) {
			
			echo json_encode($data);
			
		} else {
		
			return $data;
			
		}

	}

	/**
	 * Operator get pending chat
	 * 
	 * @access public
	 */
	public function operator_get_pending_chat($json = FALSE) {

		$this->db->query("UPDATE " . config_item('database', 'table_prefix') . "chat SET chat_status = 3, time_end = UNIX_TIMESTAMP() WHERE chat_status != 3 AND chat_status != 1 AND last_activity < (UNIX_TIMESTAMP() - " . get_option('chat_expire', TRUE) . ")");

		$sql = "SELECT * FROM " . config_item('database', 'table_prefix') . "chat c JOIN " . config_item('database', 'table_prefix') . "department_operators do ON c.department_id = do.department_id JOIN " . config_item('database', 'table_prefix') . "operators o ON do.operator_id = o.operator_id WHERE c.chat_status != 3 AND c.chat_status != 1 AND o.user_id = '" . $this->session->get('user_id') . "'";

		if ($this->db->row_count($sql) > 0) {
			
			$pending_chat = array();
			
			foreach ($this->db->query($sql) as $row) {
				
				$pending_chat[] = array(
					'chat_id'			=> $row['chat_id'],
					'chat_status'		=> $row['chat_status'],
					'username'			=> $row['username'],
					'ip_address'		=> $row['ip_address'],
					'department_name'	=> $row['department_name'],
					'elapsed_time'		=> elapsed_time(time(), $row['time_start'])
				);
				
			}
			
			$this->tpl->set('pending_chat', $pending_chat);

			$data = array(
				'success' => TRUE, 
				'content' => $this->tpl->display('admin/pending_chat', TRUE)
			);
			
		} else {
			
			$data = array(
				'success' => FALSE, 
				'content' => translate('The list of awaiting visitors is empty.', TRUE)
			);
			
		}

		$result = $this->db->fetch_row_assoc("SELECT chat_id FROM " . config_item('database', 'table_prefix') . "chat ORDER BY chat_id DESC LIMIT 1");

		$data['last_chat_id'] = $result['chat_id'];

		if (!$this->session->get('last_chat_id')) {
			
			$this->session->set('last_chat_id', 0);
			
		}
		
		if ($result['chat_id'] > $this->session->get('last_chat_id')) {
			
			$data['new_chat'] = 1;
			$this->session->set('last_chat_id', $result['chat_id']);
			
		}

		if ($json) {
			
			echo json_encode($data);
			
		} else {
		
			return $data;
			
		}

	}

	/**
	 * Operator get online visitors
	 * 
	 * @access public
	 */
	public function operator_get_online_visitors($json = FALSE) {

		foreach ($this->db->query("SELECT visitor_id, time FROM " . config_item('database', 'table_prefix') . "online_visitors") as $row) {
			
			$total = time() - $row['time'];
			
			if ($total > 60) {
				
				$where = array(
					'visitor_id' => $row['visitor_id']
				);
				
				$this->db->where($where);
				$this->db->delete(config_item('database', 'table_prefix') . 'online_visitors');
				
			}
			
		}

		$sql = "SELECT DISTINCT ip_address, referer FROM " . config_item('database', 'table_prefix') . "online_visitors";

		if ($this->db->row_count($sql) > 0) {
			
			$online_visitors = array();
			
			foreach ($this->db->query($sql) as $row) {

				$online_visitors[] = array(
					'ip_address'	=> $row['ip_address'],
					'referer'		=> $row['referer']
				);
				
			}
			
			$this->tpl->set('online_visitors', $online_visitors);
			
			$data = array(
				'success' => TRUE, 
				'content' => $this->tpl->display('admin/online_visitors', TRUE)
			);
			
		} else {
			
			$data = array(
				'success' => FALSE, 
				'content' => translate('No visitors.', TRUE)
			);
			
		}

		if ($json) {
			
			echo json_encode($data);
			
		} else {
		
			return $data;
			
		}

	}
	
	/**
	 * Operator get status
	 * 
	 * @access public
	 */
	public function operator_get_status($json = FALSE) {

		$sql = "SELECT last_activity FROM " . config_item('database', 'table_prefix') . "operators WHERE user_id = '" . $this->session->get('user_id') . "'";

		if ($this->db->row_count($sql) > 0) {
			
			$result = $this->db->fetch_row_assoc($sql);
			
			$total = time() - $result['last_activity'];
			
			if ($total > get_option('online_timeout', TRUE)) {

				$data = array(
					'success' => TRUE, 
					'content' => translate('You are offline', TRUE)
				);
				
			} else {
				
				$data = array(
					'success' => FALSE, 
					'content' => translate('You are online', TRUE)
				);
				
			}
		
		} else {
			
			$data = array(
				'success' => FALSE, 
				'content' => ''
			);
			
		}

		if ($json) {
			
			echo json_encode($data);
			
		} else {
		
			return $data;
			
		}

	}
	
	/**
	 * Operator get online departments
	 * 
	 * @access public
	 */
	public function operator_get_online_departments($json = FALSE) {
		
		$departments = array();

		foreach ($this->db->query("SELECT MAX(o.last_activity) AS last_activity, d.department_id, d.department_name FROM " . config_item('database', 'table_prefix') . "operators o JOIN " . config_item('database', 'table_prefix') . "department_operators do ON o.operator_id = do.operator_id JOIN " . config_item('database', 'table_prefix') . "departments d ON do.department_id = d.department_id WHERE o.hide_online = 0 GROUP BY d.department_name ORDER BY d.department_name ASC") as $row) {

			$total = time() - $row['last_activity'];

			if ($total > get_option('online_timeout', TRUE)) {
				
				$this->tpl->set('departments', $departments);
				
				$data = array(
					'success' => FALSE,
					'content' => $this->tpl->display('admin/online_departments', TRUE)
				);			

			} else {

				$departments[] = array(
					'department_id'		=> $row['department_id'],
					'department_name'	=> $row['department_name']
				);
				
				$this->tpl->set('departments', $departments);
				
				$data = array(
					'success' => TRUE, 
					'content' => $this->tpl->display('admin/online_departments', TRUE)
				);
			
			}

		}
			
		if ($json) {
			
			echo json_encode($data);
			
		} else {
		
			return $data;
			
		}

	}
	
	/**
	 * Operator start chat
	 * 
	 * @access public
	 */
	public function operator_start_chat($chat_id, $json = FALSE) {
		
		$chat_id = filter_var($chat_id, FILTER_SANITIZE_STRING);
		
		if ($this->db->row_count("SELECT chat_id FROM " . config_item('database', 'table_prefix') . "chat WHERE chat_id = '" . $chat_id . "'") > 0) {
			
			$values = array(
				'chat_id'		=> $chat_id,
				'message'		=> translate('Operator joined the chat', TRUE),
				'operator_name'	=> $this->operator_get_full_name($this->session->get('user_id'), TRUE),
				'time'			=> time()
			); 			

			$this->db->insert(config_item('database', 'table_prefix') . 'messages', $values);

			$values = array(
				'chat_status'	=> 2,
				'last_activity'	=> time()
			); 			

			$where = array(
				'chat_id' => $chat_id
			);

			$this->db->where($where);
			$this->db->update(config_item('database', 'table_prefix') . 'chat', $values);
			
			$this->session->set('chat_id', $chat_id);

			$data = array(
				'success' => TRUE
			);
		
		} else {
			
			$data = array(
				'success' => FALSE
			);
			
		}
	
		if ($json) {
			
			echo json_encode($data);
			
		} else {
		
			return $data;
			
		}

	}
	
	/**
	 * Operator open chat
	 * 
	 * @access public
	 */
	public function operator_open_chat($chat_id, $json = FALSE) {
		
		$chat_id = filter_var($chat_id, FILTER_SANITIZE_STRING);
		
		if ($this->db->row_count("SELECT chat_id FROM " . config_item('database', 'table_prefix') . "chat WHERE chat_id = '" . $chat_id . "'") > 0) {
			
			$this->session->set('chat_id', $chat_id);

			$data = array(
				'success' => TRUE
			);
			
		} else {
			
			$data = array(
				'success' => FALSE
			);
			
		}
		
		if ($json) {
			
			echo json_encode($data);
			
		} else {
		
			return $data;
			
		}

	}
	
	/**
	 * Operator watch chat
	 * 
	 * @access public
	 */
	public function operator_watch_chat($chat_id, $json = FALSE) {
		
		$chat_id = filter_var($chat_id, FILTER_SANITIZE_STRING);
		
		if ($this->db->row_count("SELECT chat_id FROM " . config_item('database', 'table_prefix') . "chat WHERE chat_id = '" . $chat_id . "'") > 0) {
			
			$this->session->set('chat_id', $chat_id);

			$data = array(
				'success' => TRUE
			);
		
		} else {
			
			$data = array(
				'success' => FALSE
			);
			
		}
		
		if ($json) {
			
			echo json_encode($data);
			
		} else {
		
			return $data;
			
		}

	}
	
	/**
	 * Operator stop chat
	 * 
	 * @access public
	 */
	public function operator_stop_chat($json = FALSE) {
		
		if ($this->session->get('chat_id')) {
			
			$result = $this->db->fetch_row_assoc("SELECT chat_status FROM " . config_item('database', 'table_prefix') . "chat WHERE chat_id = '" . $this->session->get('chat_id') . "'");
			
			$values = array(
				'chat_status' => 3
			); 			

			if ($result['chat_status'] != 3) {
				
				$values['time_end'] = time();
				
			}
			
			$where = array(
				'chat_id' => $this->session->get('chat_id')
			);

			$this->db->where($where);
			$this->db->update(config_item('database', 'table_prefix') . 'chat', $values);

			$values = array(
				'chat_id'		=> $this->session->get('chat_id'),
				'message'		=> translate('Operator has left the chat', TRUE),
				'operator_name' => $this->operator_get_full_name($this->session->get('user_id'), TRUE),
				'time'			=> time()
			); 			

			$this->db->insert(config_item('database', 'table_prefix') . 'messages', $values);
			
			$this->session->delete('visitor_last_message_id[' . $this->session->get('chat_id') . ']');
			$this->session->delete('chat_id');

			$data = array(
				'success' => TRUE
			);
			
		} else {
			
			$data = array(
				'success' => FALSE
			);
			
		}
		
		if ($json) {
			
			echo json_encode($data);
			
		} else {
		
			return $data;
			
		}

	}
	
	/**
	 * Operator send message
	 * 
	 * @access public
	 */
	public function operator_send_message($message, $json = FALSE) {

		$message = filter_var($message, FILTER_SANITIZE_STRING);
		
		$values = array(
			'chat_id'		=> $this->session->get('chat_id'),
			'message'		=> $message,
			'operator_name'	=> $this->operator_get_full_name($this->session->get('user_id'), TRUE),
			'time'			=> time()
		); 			
			
		$this->db->insert(config_item('database', 'table_prefix') . 'messages', $values);

		$values = array(
			'last_activity'	=> time()
		); 			

		$where = array(
			'user_id' => $this->session->get('user_id')
		);

		$this->db->where($where);
		$this->db->update(config_item('database', 'table_prefix') . 'operators', $values);

		$values = array(
			'operator_typing'	=> 0,
			'last_activity'		=> time()
		); 			

		$where = array(
			'chat_id' => $this->session->get('chat_id')
		);

		$this->db->where($where);
		$this->db->update(config_item('database', 'table_prefix') . 'chat', $values);

		$data = array(
			'success' => TRUE
		);

		if ($json) {
			
			echo json_encode($data);
			
		} else {
		
			return $data;
			
		}

	}
	
	/**
	 * Operator typing
	 * 
	 * @access public
	 */
	public function operator_typing($operator_typing, $json = FALSE) {
		
		$operator_typing = filter_var($operator_typing, FILTER_SANITIZE_STRING);
		
		$values = array(
			'operator_typing' => $operator_typing
		); 			

		$where = array(
			'chat_id' => $this->session->get('chat_id')
		);

		$this->db->where($where);
		$this->db->update(config_item('database', 'table_prefix') . 'chat', $values);

		$data = array(
			'success' => TRUE
		);

		if ($json) {
			
			echo json_encode($data);
			
		} else {
		
			return $data;
			
		}

	}
	
	/**
	 * Operator get chat
	 * 
	 * @access public
	 */
	public function operator_get_chat($json = FALSE) {

		$result = $this->db->fetch_row_assoc("SELECT last_activity FROM " . config_item('database', 'table_prefix') . "chat WHERE chat_id = '" . $this->session->get('chat_id') . "'");
		
		$total = time() - $result['last_activity'];
		
		if ($total > get_option('chat_expire', TRUE)) {

			$this->session->delete('visitor_last_message_id[' . $this->session->get('chat_id') . ']');
			$this->session->delete('chat_id');
			
			$data = array(
				'success' => FALSE
			);
			
		} else {
			
			$sql = "SELECT m.message, m.time, m.operator_name, c.username, c.email FROM " . config_item('database', 'table_prefix') . "messages m JOIN " . config_item('database', 'table_prefix') . "chat c ON m.chat_id = c.chat_id WHERE m.chat_id = '" . $this->session->get('chat_id') . "' ORDER BY m.message_id ASC";

			if ($this->db->row_count($sql) > 0) {
				
				$messages = array();
				
				foreach ($this->db->query($sql) as $row) {
					
					if ($row['operator_name'] == '') {
						
						$name = $row['username'] . ' (' . $row['email'] . ')';
						
					} else {
					
						$name = $row['operator_name'];
						
					}
					
					$messages[] = array(
						'message'	=> $row['message'],
						'name'		=> $name,
						'time'		=> date(get_option('time_format', TRUE), $row['time'])
					);
					
				}
				
				$this->tpl->set('messages', $messages);
				
				$data = array(
					'success' => TRUE, 
					'content' => $this->tpl->display('admin/chat_messages', TRUE)
				);
				
			} else {
				
				$data = array(
					'success' => FALSE
				);
				
			}

			$result = $this->db->fetch_row_assoc("SELECT user_typing FROM " . config_item('database', 'table_prefix') . "chat WHERE chat_id = '" . $this->session->get('chat_id') . "'");

			if ($result['user_typing']) {
				
				$data['user_typing'] = 1;
				
			} else {
			
				$data['user_typing'] = 0;
				
			}
			
			$result = $this->db->fetch_row_assoc("SELECT message_id FROM " . config_item('database', 'table_prefix') . "messages WHERE chat_id = '" . $this->session->get('chat_id') . "' ORDER BY message_id DESC LIMIT 1");

			$data['last_id'] = $result['message_id'];
			
			if (!$this->session->get('visitor_last_message_id[' . $this->session->get('chat_id') . ']')) {
				
				$this->session->set('visitor_last_message_id[' . $this->session->get('chat_id') . ']', 0);
				
			}
			
			if ($result['message_id'] > $this->session->get('visitor_last_message_id[' . $this->session->get('chat_id') . ']')) {
				
				$data['new_message'] = 1;
				$this->session->set('visitor_last_message_id[' . $this->session->get('chat_id') . ']', $result['message_id']);

			}

		}

		if ($json) {
			
			echo json_encode($data);
			
		} else {
		
			return $data;
			
		}

	}
	
	/**
	 * Operator update status
	 * 
	 * @access public
	 */
	public function operator_update_status($json = FALSE) {
		
		if ($this->session->get('user_id')) {
			
			$result = $this->db->fetch_row_assoc("SELECT last_activity FROM " . config_item('database', 'table_prefix') . "operators WHERE user_id = '" . $this->session->get('user_id') . "'");
			
			$total = time() - $result['last_activity'];
			
			$values = array();

			if ($total > get_option('online_timeout', TRUE)) {
				
				$values['last_activity'] = time();
				
			} else {
				
				$values['last_activity'] = 0;
				
			}
			
			$where = array(
				'user_id' => $this->session->get('user_id')
			);

			$this->db->where($where);
			$this->db->update(config_item('database', 'table_prefix') . 'operators', $values);

			$data = array(
				'success' => TRUE
			);
			
		} else {
			
			$data = array(
				'success' => FALSE
			);
			
		}
		
		if ($json) {
			
			echo json_encode($data);
			
		} else {
		
			return $data;
			
		}

	}
	
	/**
	 * Operator send invitation
	 * 
	 * @access public
	 */
	public function operator_send_invitation($ip_address, $invitation_message, $json = FALSE) {

		$ip_address = filter_var($ip_address, FILTER_SANITIZE_STRING);
		$invitation_message = filter_var($invitation_message, FILTER_SANITIZE_STRING);

		if ($this->db->row_count("SELECT ip_address FROM " . config_item('database', 'table_prefix') . "online_visitors WHERE ip_address = '" . $ip_address . "'") > 0) {
			
			$values = array(
				'invitation_message' => $invitation_message
			); 			

			$where = array(
				'ip_address' => $ip_address
			);

			$this->db->where($where);
			$this->db->update(config_item('database', 'table_prefix') . 'online_visitors', $values);

			$data = array(
				'success' => TRUE
			);
		
		} else {
			
			$data = array(
				'success' => FALSE
			);
			
		}
		
		if ($json) {
			
			echo json_encode($data);
			
		} else {
		
			return $data;
			
		}

	}
	
	/**
	 * Operator transfer chat
	 * 
	 * @access public
	 */
	public function operator_transfer_chat($department_id, $json = FALSE) {
		
		$department_id = filter_var($department_id, FILTER_SANITIZE_STRING);
		
		if ($this->db->row_count("SELECT department_id FROM " . config_item('database', 'table_prefix') . "departments WHERE department_id = '" . $department_id . "'") > 0) {
			
			$result = $this->db->fetch_row_assoc("SELECT department_name FROM " . config_item('database', 'table_prefix') . "departments WHERE department_id = '" . $department_id . "'");
		
			$values = array(
				'chat_status'		=> 0,
				'department_name'	=> $result['department_name'],
				'department_id'		=> $department_id
			); 			

			$where = array(
				'chat_id' => $this->session->get('chat_id')
			);

			$this->db->where($where);
			$this->db->update(config_item('database', 'table_prefix') . 'chat', $values);

			$values = array(
				'chat_id'		=> $this->session->get('chat_id'),
				'message'		=> translate('Chat transfered to another operator, please wait.', TRUE),
				'operator_name'	=> $this->operator_get_full_name($this->session->get('user_id'), TRUE),
				'time'			=> time()
			); 			

			$this->db->insert(config_item('database', 'table_prefix') . 'messages', $values);

			$data = array(
				'success' => TRUE
			);
		
		} else {

			$data = array(
				'success' => FALSE
			);
			
		}

		if ($json) {
			
			echo json_encode($data);
			
		} else {
		
			return $data;
			
		}

	}

	/**
	 * Operator get full name
	 * 
	 * @access public
	 */
	public function operator_get_full_name($user_id, $return_string = FALSE) {
		
		$user_id = filter_var($user_id, FILTER_SANITIZE_STRING);
		
		$result = $this->db->fetch_row_assoc("SELECT CONCAT_WS(' ', first_name, last_name) AS full_name FROM " . config_item('database', 'table_prefix') . "operators WHERE user_id = '" . $user_id . "'");
		 
		if ($return_string) {
			
			return rtrim($result['full_name']);
			
		} else {
			
			echo rtrim($result['full_name']);
			
		}
		
	}
	
	/**
	 * Unique id
	 * 
	 * @access public
	 */
	public function unique_id($prefix, $return_string = FALSE) {

		if (!$this->session->get($prefix)) {
			
			$this->session->set($prefix, uniqid($prefix));
			$unique_id = $this->session->get($prefix);
			
		} else {
			
			$unique_id = $this->session->get($prefix);
			
		}
		
		if ($return_string) {
			
			return $unique_id;
			
		} else {
			
			echo $unique_id;
			
		}
		
	}
	
	/**
	 * Get unique id
	 * 
	 * @access public
	 */
	public function get_unique_id($prefix, $json = FALSE) {
		
		if (!$this->session->get($prefix)) {

			$data = array(
				'success' => FALSE
			);
			
		} else {
			
			$data = array(
				'success'	=> TRUE,
				'unique_id' => $this->session->get($prefix)
			);

		}
		
		if ($json) {
			
			echo json_encode($data);
			
		} else {
		
			return $data;
			
		}

	}
	
	/**
	 * Online visitors
	 * 
	 * @access public
	 */
	public function online_visitors() {

		$sql = "SELECT ip_address FROM " . config_item('database', 'table_prefix') . "online_visitors WHERE ip_address = '" . $_SERVER['REMOTE_ADDR'] . "'";

		if ($this->db->row_count($sql) > 0) {
			
			$values = array(
				'time' => time()
			); 			

			$where = array(
				'ip_address' => $_SERVER['REMOTE_ADDR']
			);

			$this->db->where($where);
			$this->db->update(config_item('database', 'table_prefix') . 'online_visitors', $values);
			
		} else {
			
			$values = array(
				'ip_address'	=> $_SERVER['REMOTE_ADDR'],
				'referer'		=> $_SERVER['HTTP_REFERER'],
				'time'			=> time()
			); 			

			$this->db->insert(config_item('database', 'table_prefix') . 'online_visitors', $values);

		}

	}

	/**
	 * Count visitors
	 * 
	 * @access public
	 */
	public function count_visitors() {
		
		return $this->db->row_count("SELECT chat_id FROM " . config_item('database', 'table_prefix') . "chat WHERE chat_status = 0 OR chat_status = 2");
		
	}
	
}

?>
