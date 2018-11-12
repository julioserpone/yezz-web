<?php 

//Include the common file
require_once('../common.php');

//Include the administration file
require_once('admin.php');

//Check session
if (isset($_GET['language_id'])) {
	
	$session->set('language_id', $_GET['language_id']);
	
} elseif (!$session->get('language_id')) {

	header("Location: translations.php");

}

//Returns the number of rows
$row_count = $db->row_count("SELECT translation_id FROM " . config_item('database', 'table_prefix') . "translations WHERE language_id = '" . $session->get('language_id') . "'");

//Language name
$language = $db->fetch_row_assoc("SELECT language_name FROM " . config_item('database', 'table_prefix') . "languages WHERE language_id = '" . $session->get('language_id') . "'");

//Pagination
if (isset($_GET['page'])) {
	
	$current_page = trim($_GET['page']);
	
} else {

	$current_page = 1;
	
}

$start = ($current_page - 1) * get_option('records_per_page', TRUE); 	

$sql = "SELECT translation_key, translation_text FROM " . config_item('database', 'table_prefix') . "translations WHERE language_id = '" . $session->get('language_id') . "'";

$counter = 0;

if (isset($_POST['filter'])) {
	
	foreach ($_POST['filter'] as $key => $value) {

		if ($counter == 0) {
			
			$operator = " AND";
			
		} else {
		
			$operator = " OR";
		
		}
		
		if (!empty($_POST['filter']['key']) && $key == 'key') {
			
			$sql .=  $operator . " LCASE(translation_key) LIKE '%" . strtolower(filter_var($_POST['filter']['key'], FILTER_SANITIZE_STRING)) . "%'";
		
		}
		
		if (!empty($_POST['filter']['text']) && $key == 'text') {
			
			$sql .= $operator . " LCASE(translation_text) LIKE '%" . strtolower(filter_var($_POST['filter']['text'], FILTER_SANITIZE_STRING)) . "%'";
		
		}
		
		if (!empty($_POST['filter']['key']) && !empty($_POST['filter']['text'])) {
			
			$counter++;
			
		}
		
	}
	
}

$sql .= " LIMIT " . $start . ", " . get_option('records_per_page', TRUE);

if (!empty($_POST['filter']['key']) || !empty($_POST['filter']['text'])) {
	
	$pages = 0;
	
} else {
	
	$pages = ceil($db->row_count("SELECT translation_id FROM " . config_item('database', 'table_prefix') . "translations WHERE language_id = '" . $session->get('language_id') . "'") / get_option('records_per_page', TRUE));

}

//Translation details
$translation_details = array();

foreach ($db->query($sql) as $row) {
	
	$translation_details[] = array(
		'translation_key'	=> $row['translation_key'],
		'translation_text'	=> $row['translation_text']
	);

}
	
//Check if the form has been submitted
if (isset($_POST['submit'])) {
	
	foreach ($_POST['translation'] as $key => $value) {
		
		$values = array(
			'translation_text' => filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS)
		);
		
		$where = array(
			'translation_key'	=> $key,
			'language_id'		=> $session->get('language_id')
		);

		$db->where($where);
		$db->update(config_item('database', 'table_prefix') . 'translations', $values);
		
		$session->set('success', TRUE);

		header("Location: translations.php");
		
	}
	
}

//Template values
$tpl->set('row_count', $row_count);
$tpl->set('language_name', $language['language_name']);
$tpl->set('current_page', $current_page);
$tpl->set('pages', $pages);
$tpl->set('translation_details', $translation_details);

//Display the template
$tpl->display('admin/edit_translation');

?>
