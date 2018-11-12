<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) exit('No direct access allowed.');

/** 
 * Authentication class
 */ 
class Authentication {

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
	 * Constructor
	 * 
	 * @access public 
	 */	  
	public function __construct() {
		
		$this->db = new Database();
		$this->session = new Session();
		
		$this->auto_login();
		
	}

	/**
	 * Create user
	 * 
	 * @access public 
	 */		
	public function create_user($email, $password, $additional_data = NULL, $parameters = NULL) {

		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		$password = filter_var($password, FILTER_SANITIZE_STRING);

		$values = array(
			'user_email'	=> $email, 
			'user_password' => sha1($password),
			'user_created' 	=> time()
		);

		if (isset($parameters)) {
			
			if (isset($parameters['user_status'])) {
				
				$values['user_status'] = $parameters['user_status'];
			
			}
			
			$values['user_approved'] = 1;
			
			if (isset($parameters['group_id'])) {
				
				$values['group_id'] = $parameters['group_id'];
				
			}
			
		}

		$this->db->insert(config_item('database', 'table_prefix') . 'users', $values);
		
		$user_id = $this->db->last_insert_id();

		if ($additional_data) {

			$this->db->insert(config_item('database', 'table_prefix') . 'user_profiles', $additional_data);
			
			$values = array(
				'user_id' => $user_id
			);
			
			$where = array(
				'profile_id' => $this->db->last_insert_id()
			);
			
			$this->db->where($where);
			$this->db->update(config_item('database', 'table_prefix') . 'user_profiles', $values);

		}	
		
	}

	/**
	 * Update user
	 * 
	 * @access public 
	 */		
	public function update_user($user_id, $email, $password = FALSE, $additional_data = NULL, $parameters = NULL) {

		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		$password = filter_var($password, FILTER_SANITIZE_STRING);

		$values = array(
			'user_email' => $email
		); 

        if ($password) {
			
			$values['user_password'] = sha1($password);
			
		}
		
		if (isset($parameters)) {

			if (isset($parameters['user_status'])) {
				
				$values['user_status'] = $parameters['user_status'];
				$values['user_approved'] = $parameters['user_status'];
				
			}
				
			if (isset($parameters['group_id'])) {
				
				$values['group_id'] = $parameters['group_id'];
				
			}
			
		}
		
		$where = array(
			'user_id' => $user_id
		);

		$this->db->where($where);
		$this->db->update(config_item('database', 'table_prefix') . 'users', $values);
		
		if (isset($additional_data)) {

			$where = array(
				'user_id' => $user_id
			);

			$this->db->where($where);
			$this->db->update(config_item('database', 'table_prefix') . 'user_profiles', $additional_data);
	
 		}

	}

	/**
	 * Delete user
	 * 
	 * @access public 
	 */	
	public function delete_user($user_id) {

		$where = array(
			'user_id' => $user_id
		);
		
		$this->db->where($where);
		$this->db->delete(config_item('database', 'table_prefix') . 'users');
		$this->db->delete(config_item('database', 'table_prefix') . 'user_profiles');
	
	}

	/**
	 * Token
	 * 
	 * @access private 
	 */	
	private function token() {

		return md5(get_option('secret_word', TRUE) . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
		
	}
	
	/**
	 * Login
	 * 
	 * @access public 
	 */	
	public function login($email, $password, $remember = FALSE) {

		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		$password = filter_var($password, FILTER_SANITIZE_STRING);
		
		$sql = "SELECT u.user_id, ug.group_name FROM " . config_item('database', 'table_prefix') . "users u JOIN " . config_item('database', 'table_prefix') . "user_groups ug ON u.group_id = ug.group_id WHERE u.user_email = '" . $email . "' AND u.user_password = '" . sha1($password) . "' AND u.user_status = 1 AND u.user_approved = 1";

		if ($this->db->row_count($sql)) {
			
			session_regenerate_id(TRUE);
			$this->session->set('token', $this->token());
			$this->session->set('logged_in', TRUE);
			
			$result = $this->db->fetch_row_assoc($sql);

			$this->session->set('user_id', $result['user_id']);

			$values = array(
				'last_login'	=> time(), 
				'last_ip'		=> $_SERVER['REMOTE_ADDR']
			);
			
			$where = array(
				'user_id' => $result['user_id']
			);
			
			$this->db->where($where);
			$this->db->update(config_item('database', 'table_prefix') . 'users', $values);

			if ($remember) {
				
				$this->remember_user($result['user_id'], $email, $password);
				
			}
			
			if (get_option('access_logs', TRUE)) {

				$values = array(
					'user_id'	=> $result['user_id'],
					'log_ip'	=> $_SERVER['REMOTE_ADDR'],
					'time'		=> time()
				);
		
				$this->db->insert(config_item('database', 'table_prefix') . 'access_logs', $values);
			
			}

			return TRUE;
			
		} else {

			return FALSE;

		}
		
	}

	/**
	 * Remember user
	 * 
	 * @access public 
	 */		
	public function remember_user($user_id, $email, $password) {

		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		$password = filter_var($password, FILTER_SANITIZE_STRING);

		$key = $email . $password;

		$values = array(
			'remember_code' => sha1($key)
		);
			
		$where = array(
			'user_id' => $user_id
		);
		
		$this->db->where($where);
		$this->db->update(config_item('database', 'table_prefix') . 'users', $values);

		setcookie('remember_code', sha1($key), time() + get_option('user_expire', TRUE));
		
	}

	/**
	 * Logged in
	 * 
	 * @access public 
	 */	
	public function logged_in() {

		if ($this->session->get('logged_in') && $this->session->get('token') == $this->token()) {
			
			return TRUE;
		
		}
		
		return FALSE;
		
	}

	/**
	 * Auto login
	 * 
	 * @access public 
	 */	
	public function auto_login() {
	
		if (!$this->logged_in() AND !$this->logged_in(FALSE)) {
			
			if (isset($_COOKIE['remember_code'])) {

				$sql = "SELECT u.user_id, ug.group_name FROM " . config_item('database', 'table_prefix') . "users u JOIN " . config_item('database', 'table_prefix') . "user_groups ug ON u.group_id = ug.group_id WHERE u.remember_code = '" . $_COOKIE['remember_code'] . "' AND u.user_status = 1 AND u.user_approved = 1";
				
				if ($this->db->row_count($sql)) {

					session_regenerate_id(TRUE);
					$this->session->set('token', $this->token());
					$this->session->set('logged_in', TRUE);
				
					$result = $this->db->fetch_row_assoc($sql);
					
					$this->session->set('user_id', $result['user_id']);

				}

			}
			
		}
		
		return FALSE;		
	
	}

	/**
	 * Logout
	 * 
	 * @access public 
	 */		
	public function logout() {
		
		$this->session->destroy();
		unset($_COOKIE['remember_code']);
		setcookie('remember_code', '', time() - 1);
		
	}

	/**
	 * New password
	 * 
	 * @access public 
	 */	
	public function new_password($email) {

		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ($this->db->row_count("SELECT user_email FROM " . config_item('database', 'table_prefix') . "users WHERE user_email = '" . $email . "'")) {

			$password = substr(md5(uniqid(rand())), 0, 8);
			
			$values = array(
				'user_password' => sha1($password)
			);
			
			$where = array(
				'user_email' => $email
			);
			
			$this->db->where($where);
			$this->db->update(config_item('database', 'table_prefix') . 'users', $values);

			$headers  = 'From: ' . get_option('site_title', TRUE) . '<' . get_option('admin_email', TRUE) . '>' . "\r\n";
			$headers .=	'Reply-To: ' . get_option('admin_email', TRUE) . "\r\n";
			$headers .=	'X-Mailer: PHP/' . phpversion() . "\r\n";
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=' . get_option('charset', TRUE) . "\r\n";
			
			$email_message = '<html><head></head><body>' . sprintf(translate('<p>A new password was requested from %s.</p><p>Your new password is:</p><p>%s</p><p><a href="%s" target="_blank">%s</a></p>', TRUE), get_option('site_title', TRUE), $password, get_option('absolute_url', TRUE), get_option('site_title', TRUE)) . '</body></html>';
			
			if (mail($email, translate('New Password', TRUE), html_entity_decode($email_message, ENT_QUOTES), $headers)) {
				
				return TRUE;
				
			} else {
			
				return FALSE;
				
			}

		} else {
		
			return FALSE;
			
		}
	
	}

	/**
	 * Check email
	 * 
	 * @access public 
	 */	
	public function check_email($email) {

		$email = filter_var($email, FILTER_SANITIZE_EMAIL);

		if ($this->db->row_count("SELECT user_email FROM " . config_item('database', 'table_prefix') . "users WHERE user_email = '" . $email . "'")) {
			
			return FALSE;
			
		} else {
			
			return TRUE;
			
		}
		
	}
	
}

?>
