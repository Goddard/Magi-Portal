<?php
defined('LOAD_SAFE') or die('Server Error');

	include("application/language/".$language."/page.lang.php");

	$page_name = NULL;

if($_SESSION['userlevel']>=200 && !isset($_REQUEST['Submit']) && !isset($_REQUEST['logout']) && isset($_GET['name']) && !isset($_POST['pagename'])){

	$page_name = $_GET['name'];

	$pageget = "SELECT * FROM page WHERE page='$page_name'";
	$query = $DB->query($pageget) or trigger_error($lang_error['SELECT_ERROR'], E_USER_ERROR);
	$pagecount = $DB->num_rows($query);

	if($pagecount==1){

		$file_contents = file_get_contents(__SITE_PATH . "/" . $configuration->config_values['template']['template_dir'] . "/static/" . $page_name . ".tpl") or trigger_error($lang_error['READ_ERROR'], E_USER_ERROR);

		$t_ = array(
			'PAGE_EDIT_TITLE' 		=> $lang['pageedittitle'],
			'PAGE_EDIT_SUB_TITLE' 	=> $lang['pageeditsubtitle'],
			'PAGE_NAME' 			=> $page_name,
			'PAGE_CONTENT_TITLE' 	=> $lang['contenttitle'],
			'PAGE_CONTENT' 		=> $file_contents,
			'RESET'				=> $lang['reset'],
			'SUBMIT'				=> $lang['submit'],
			'REQUIRED'			=> $lang['require']
		);

		$TEMPLATE->load("pageedit.tpl");
			$TEMPLATE->assign($t_);
				$TEMPLATE->publish();
	}

}elseif($_SESSION['userlevel']>=200 && isset($_REQUEST['Submit']) && !isset($_REQUEST['logout'], $_GET['name']) && isset($_POST['pagename'], $_POST['message'])){

		$page_name = $_POST['pagename'];
		$page_content = $_POST['message'];

		$file = __SITE_PATH . "/" . $configuration->config_values['template']['template_dir'] . "/static/" . $page_name . ".tpl";

		file_put_contents($file, $page_content) or trigger_error($lang_error['WRITE_ERROR'], E_USER_ERROR);		

		$sql = "UPDATE page SET modified='$date_time' WHERE page='$page_name'";
		$query = $DB->query($sql) or trigger_error($lang_error['UPDATE_ERROR'], E_USER_ERROR);

		header('Location: ?page=page&name='.$page_name);
}else{

	$t_ = array(
		'MESSAGE'	 => $lang['permissiondenied'],
	);

	$TEMPLATE->load("permission.tpl");
		$TEMPLATE->assign($t_);
			$TEMPLATE->publish();

}
?>
