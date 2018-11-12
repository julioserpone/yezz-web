<?php 

//Include the common file
require_once('../common.php');

//Include the administration file
require_once('admin.php');

//Returns the number of rows
$row_count = $db->row_count("SELECT log_id FROM " . config_item('database', 'table_prefix') . "access_logs");

//Pagination
if (isset($_GET['page'])) {
	
	$current_page = trim($_GET['page']);
	
} else {

	$current_page = 1;
	
}

$start = ($current_page - 1) * get_option('records_per_page', TRUE); 	

$sql = "SELECT a.log_ip, a.time, u.user_email, CONCAT_WS(' ', up.first_name, up.last_name) AS full_name FROM " . config_item('database', 'table_prefix') . "access_logs a JOIN " . config_item('database', 'table_prefix') . "users u ON a.user_id = u.user_id JOIN " . config_item('database', 'table_prefix') . "user_profiles up ON a.user_id = up.user_id";

$sql .= " ORDER BY a.log_id DESC";

$sql .= " LIMIT " . $start . ", " . get_option('records_per_page', TRUE);

$pages = ceil($db->row_count("SELECT log_id FROM " . config_item('database', 'table_prefix') . "access_logs") / get_option('records_per_page', TRUE));
	
//Access logs
$access_logs = array();

foreach ($db->query($sql) as $row) {
	
	$access_logs[] = array(
		'user_email'	=> $row['user_email'],
		'log_ip'		=> $row['log_ip'],
		'time'			=> date(get_option('date_format', TRUE) . ' ' . get_option('time_format', TRUE), $row['time']),
		'full_name'		=> $row['full_name']
	);
	
}

//Template values
$tpl->set('row_count', $row_count);
$tpl->set('current_page', $current_page);
$tpl->set('pages', $pages);
$tpl->set('access_logs', $access_logs);

//Display the template
$tpl->display('admin/access_logs');

?>
