<?php 

//Include the common file
require_once('../common.php');

//Include the administration file
require_once('admin.php');

//Returns the number of rows
$row_count = $db->row_count("SELECT blocked_visitor_id FROM " . config_item('database', 'table_prefix') . "blocked_visitors");

//Pagination
if (isset($_GET['page'])) {
	
	$current_page = trim($_GET['page']);
	
} else {

	$current_page = 1;
	
}

$start = ($current_page - 1) * get_option('records_per_page', TRUE); 	

$sql = "SELECT blocked_visitor_id, ip_address, description, time FROM " . config_item('database', 'table_prefix') . "blocked_visitors";

$sql .= " ORDER BY blocked_visitor_id DESC";

$sql .= " LIMIT " . $start . ", " . get_option('records_per_page', TRUE);

$pages = ceil($db->row_count("SELECT blocked_visitor_id FROM " . config_item('database', 'table_prefix') . "blocked_visitors ") / get_option('records_per_page', TRUE));
	
//Blocked visitors
$blocked_visitors = array();

foreach ($db->query($sql) as $row) {
	
	$blocked_visitors[] = array(
		'blocked_visitor_id'	=> $row['blocked_visitor_id'],
		'ip_address'			=> $row['ip_address'],
		'description'			=> $row['description'],
		'time'					=> $row['time']
	);
	
}

//Check if the form has been submitted
if (isset($_POST['submit'])) {
	
	if ($db->row_count("SELECT ip_address FROM " . config_item('database', 'table_prefix') . "blocked_visitors WHERE ip_address = '" . filter_var($_POST['ip_address'], FILTER_SANITIZE_STRING) . "'") > 0) {
		
		$error->set_error(translate('The Ip address is already in use.', TRUE));
		
	} else {

		$validate->ip($_POST['ip_address'], translate('Please enter a IP address.', TRUE));
		$validate->required($_POST['description'], translate('Please enter a description.', TRUE));

		if (!$error->has_errors()) {

			$values = array(
				'ip_address'	=> filter_var($_POST['ip_address'], FILTER_SANITIZE_STRING),
				'description'	=> filter_var($_POST['description'], FILTER_SANITIZE_STRING),
				'time'			=> time()
			);

			$db->insert(config_item('database', 'table_prefix') . 'blocked_visitors', $values);
			
			header("Refresh: 1; url=" . $_SERVER["PHP_SELF"]);

			$tpl->set('success', TRUE);
			
		}
		
	}
	
}

//Delete blocked visitors
if (isset($_GET['blocked_visitor_id'])) {
	
	$where = array(
		'blocked_visitor_id' => $_GET['blocked_visitor_id']
	);

	$db->where($where);
	$db->delete(config_item('database', 'table_prefix') . 'blocked_visitors');
	
	header("Location: blocked_visitors.php");
	
}

//Template values
$tpl->set('row_count', $row_count);
$tpl->set('current_page', $current_page);
$tpl->set('pages', $pages);
$tpl->set('blocked_visitors', $blocked_visitors);

//Display the template
$tpl->display('admin/blocked_visitors');

?>
