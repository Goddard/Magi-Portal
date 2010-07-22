<?php
defined('LOAD_SAFE') or die('Server Error');

include("application/language/".$language."/delete.lang.php");

$page_name = NULL;

if($_SESSION['logged']=="true" && $_SESSION['userlevel']>=200 && !isset($_REQUEST['Submit'], $_POST['pagename'], $_POST['pagefound']) && isset($_GET['name']))
{

	$page_name = $_GET['name'];

	$query = $DB->query("SELECT * FROM page WHERE page='$page_name'");
		$pagefound = $DB->num_rows($query);

	$t_ = array(
		'PAGE_DELETE_TITLE'		=> $lang['deletetitle'],
		'PAGE_DELETE_SUB_TITLE'	=> $lang['confirmationmsg'],
		'PAGE_DELETE_NAME' 		=> $page_name,
		'PAGE_DELETE_FOUND' 		=> $pagefound,
		'CONFIRM'					=> $lang['confirm'],
	);

	$TEMPLATE->load("pagedelete.tpl");
		$TEMPLATE->assign($t_);
			$TEMPLATE->publish();

}elseif($_POST['pagefound']==1 && $_SESSION['logged']=="true" && $_SESSION['userlevel']>=200 && isset($_REQUEST['Submit'], $_POST['pagename'])){

	$page_name = $_POST['pagename'];

	$file = __SITE_PATH . "/" . $configuration->config_values['template']['template_dir'] . "/static/" . $page_name . ".tpl";

	unlink($file) or trigger_error($lang_error['DELETE_ERROR'], E_USER_ERROR);

	$query1 = $DB->query("DELETE FROM page WHERE page='$page_name'") or trigger_error($lang_error['DELETE_ERROR'], E_USER_ERROR);

	$t_ = array(
		'MESSAGE'		=> $lang['deletionsuccess']
	);

	$TEMPLATE->load("message.tpl");
		$TEMPLATE->assign($t_);
			$TEMPLATE->publish();

}else{

	$t_ = array(
		'MESSAGE'		=> $lang['permissiondenied']
	);

	$TEMPLATE->load("permission.tpl");
		$TEMPLATE->assign($t_);
			$TEMPLATE->publish();

}
?>
