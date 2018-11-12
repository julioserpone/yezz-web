<?php

require_once('libraries/Error.php');
//Turn off all error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

//Initialize core objects
$db = new Database();
$authentication = new Authentication();
$session = new Session();
$error = new ErrorClass();
$validate = new Validate();
$chat = new Chat();
$tpl = new Template();

//Set the default timezone
date_default_timezone_set(get_option('timezone', TRUE));

//Template values
$tpl->set('error', $error);
$tpl->set('session', $session);
$tpl->set('authentication', $authentication);
$tpl->set('chat', $chat);

//Get option
function get_option($option_name, $return_string = FALSE) {
	
	global $db;
	
	$result = $db->fetch_row_assoc("SELECT option_value FROM " . config_item('database', 'table_prefix') . "options WHERE option_name = '" . $option_name . "'");
	
	if ($return_string) {
		
		return $result['option_value'];
		
	} else {
		
		echo $result['option_value'];
		
	}
	
}

//Translate

function translate($key, $return_string = FALSE) {
	
	global $db;

	$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
	
	$sql = "SELECT t.translation_text FROM " . config_item('database', 'table_prefix') . "translations t JOIN " . config_item('database', 'table_prefix') . "languages l ON t.language_id = l.language_id WHERE l.language_iso_code = '" . $lang . "' AND t.translation_key = '" . $key . "'";
	
	if ($db->row_count($sql) > 0) {
		
		$result = $db->fetch_row_assoc($sql);
		
		if (empty($result['translation_text'])) {

			$result = $db->fetch_row_assoc("SELECT t.translation_text FROM " . config_item('database', 'table_prefix') . "translations t JOIN " . config_item('database', 'table_prefix') . "languages l ON t.language_id = l.language_id WHERE l.language_iso_code = 'en' AND t.translation_key = '" . $key . "'");

			$translation_text = $result['translation_text'];
			
		} else {
			
			$translation_text = $result['translation_text'];
			
		}
		
	} else {

		$result = $db->fetch_row_assoc("SELECT t.translation_text FROM " . config_item('database', 'table_prefix') . "translations t JOIN " . config_item('database', 'table_prefix') . "languages l ON t.language_id = l.language_id WHERE l.language_iso_code = 'en' AND t.translation_key = '" . $key . "'");

		$translation_text = $result['translation_text'];
		
	}
	
	if ($return_string) {
		
		return $translation_text;
		
	} else {
		
		echo $translation_text;
		
	}
	
}

//Elapsed time
function elapsed_time($start, $end, $full_string = FALSE) {
	
	$diff = $start - $end;
	
	if (1 > $diff) {
		
		return '--';
		
	} else {
		
		$periods = array(
			'week'		=> floor($diff / 86400 / 7),
			'day'		=> floor($diff / 86400 % 7),
			'hour'		=> floor($diff / 3600 % 24),
			'minute' 	=> floor($diff / 60 % 60),
			'second' 	=> floor($diff % 60)
		);

		$output = '';
		
		$i = 1;
		
		$count = count($periods);
		
		foreach ($periods as $key => $value) {
			
			if ($full_string) {
				
				if ($count == $i) {
					
					$output .= $value;
					
				} else {
					
					$output .= $value . ':';
					
				}
				
				$i++;
				
			} else {
				
				if ($value > 0 && $value == 1) {
					
					$output .= $value . ' ' . $key . ' ';
					
				} elseif ($value > 0 && $value != 1) {
					
					$output .= $value . ' ' . $key . 's ';
					
				}
				
			}

		}
		
		return $output;
		
	}

}

//Embed code
function embed_code($return_string = FALSE) {
	
	$output  = '<pre>';
	$output .= '&lt;!-- Start Live Chat Code --&gt;';
	$output .= '<br>';
	$output .= '&lt;script type="text/javascript" src="' . get_option('absolute_url', TRUE) . 'templates/js/jquery.min.js"&gt;&lt;/script&gt;';
	$output .= '<br>';
	$output .= '&lt;script type="text/javascript" src="' . get_option('absolute_url', TRUE) . 'templates/js/bootstrap.min.js"&gt;&lt;/script&gt;';
	$output .= '<br>';
	$output .= '&lt;script type="text/javascript" src="' . get_option('absolute_url', TRUE) . 'templates/js/jquery.validate.min.js"&gt;&lt;/script&gt;';
	$output .= '<br>';
	$output .= '&lt;script type="text/javascript" src="' . get_option('absolute_url', TRUE) . 'templates/js/main.min.js"&gt;&lt;/script&gt;';
	$output .= '<br>';
	$output .= '&lt;script type="text/javascript"&gt;';
	$output .= '$(function(){';
	$output .= '$("&lt;link&gt;").attr({href: "' . get_option('absolute_url', TRUE) . 'templates/css/live_chat.css", rel: "stylesheet"}).appendTo("head");';
	$output .= '$("body").append($("&lt;div&gt;").load("' . dirname(dirname($_SERVER['PHP_SELF'])) . '/live_chat.php",function(){live_chat("' . dirname(dirname($_SERVER['PHP_SELF'])) . '/");}));';
	$output .= '});';
	$output .= '&lt;/script&gt;';
	$output .= '<br>';
	$output .= '&lt;!-- End Live Chat Code --&gt;';
	$output .= '</pre>';
	
	if ($return_string) {
		
		return $output;
		
	} else {
		
		echo $output;
	
	}

}

//Generate token
function generate_token($name) {
	
	global $session;

	if ($session->get($name . '_token')) {
		
		return $session->get($name . '_token');
		
	} else {
		
		$token = md5(uniqid());
		
		$session->set($name . '_token', $token);
		
		return $token;
	
	}
	
}

//Check token
function check_token($name) {
	
	global $session;
	
	if (!$session->get($name . '_token')) {
		
		return FALSE;
		
	}
	
	if (isset($_POST['token']) && $session->get($name . '_token') == $_POST['token']) {

		return TRUE;
		
	}
	
	return FALSE;
	
}

//Load a config file
function config_load($name) {
	
	$configuration = array();

	if (file_exists(dirname(__FILE__) . '/config/' . $name . '.php')) {
		
		require(dirname(__FILE__) . '/config/' . $name . '.php');
		
	} else {
	
		die('The file ' . dirname(__FILE__) . '/config/' . $name . '.php does not exist.');
		
	}
	
	if (!isset($config) OR !is_array($config)) {
		
		die('The file ' . dirname(__FILE__) . '/config/' . $name . '.php does not appear to be formatted correctly.');
	
	}
	
	if (isset($config) AND is_array($config)) {
		
		$configuration = array_merge($configuration, $config);
		
	}
	
	return $configuration;

}

//Load a config item
function config_item($name, $item) {
	
	static $config_item = array();

	if (!isset($config_item[$item])) {
	
		$config = config_load($name);

		if (!isset($config[$item])) {
			
			return FALSE;
			
		}
		
		$config_item[$item] = $config[$item];
		
	}
	
	return $config_item[$item];

}

//Autoloading classes
function __autoload($class_name) {
		
	if (file_exists(dirname(__FILE__) . '/libraries/' . $class_name . '.php')) {
		
		require_once(dirname(__FILE__) . '/libraries/' . $class_name . '.php');
		
	} else {
	
		die('The file ' . dirname(__FILE__) . '/libraries/' . $class_name . '.php does not exist.');
		
	}
	
}

?>
