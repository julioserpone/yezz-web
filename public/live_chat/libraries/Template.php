<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) exit('No direct access allowed.');

/** 
 * Template class
 */ 
class Template {

	/**
	 * Path templates
	 * 
	 * @access private
	 */
	private $tpl_path;
	
	/**
	 * Values
	 * 
	 * @access private
	 */
	private $values = array();

	/**
	 * Constructor
	 *
	 * @access public
	 */	
	public function __construct() {
		
		$this->tpl_path = get_option('absolute_path', TRUE) . 'templates/';

	}

	/**
	 * Set a template variable
	 * 
	 * @access public
	 */
	public function set($name, $value = null) {
		
		if (is_array($name)) {
		
			foreach ($name as $key => $value) {
			
				$this->values[$key] = $value;
			
			}
		
		} else {
			
			$this->values[$name] = $value;
			
		}
		
    }

	/**
	 * Display the template file
	 * 
	 * @access public
	 */
	public function display($template, $return_string = false) {

		if ($this->values) {
			
			extract($this->values);
			
		}
		
		if (file_exists($this->tpl_path . $template . get_option('template_extension', true))) {

			ob_start();

			include($this->tpl_path . $template . get_option('template_extension', true));

			$output = ob_get_contents();

			ob_end_clean();
			
		} else {
			
			die('Template file '. $this->tpl_path . $template . get_option('template_extension', true) . ' not found.');
			
		}

		if ($return_string) {
			
			return $output;
			
		} else {
			
			echo $output;
			
		}
		
	} 

}
    
?>
