<?php
defined('LOAD_SAFE') or die('Server Error');

include("application/language/".$language."/delete.lang.php");

$news_id = NULL;

if($_SESSION['logged']=="true" && $_SESSION['userlevel']>=200 && !isset($_POST['message'], $_REQUEST['Submit'], $_POST['referenceid']) && is_numeric($_GET['newsid']))
{

	$news_id = $_GET['newsid'];

	$query = $DB->query("SELECT * FROM news WHERE id='" . $news_id . "'");
   $newsfound = $query->rowCount();
   
	$t_ = array(
		'NEWS_DELETE_TITLE'			=> $lang['deletetitle'],
		'NEWS_DELETE_SUB_TITLE'		=> $lang['confirmationmsg'],
		'NEWS_DELETE_ID' 			   => $_GET['newsid'],
		'NEWS_DELETE_FOUND' 		   => $newsfound,
		'CONFIRM'					   => $lang['confirm'],
	);

	$TEMPLATE->load("newsdelete.tpl");
		$TEMPLATE->assign($t_);
			$TEMPLATE->publish();

}elseif($_POST['newsfound']==1 && $_SESSION['logged']=="true" && $_SESSION['userlevel']>=200 && isset($_REQUEST['Submit'], $_POST['referenceid']) && is_numeric($_POST['referenceid']))
{

	$news_id = $_POST['referenceid'];	

	$query1 = $DB->query("DELETE FROM news WHERE id=$news_id") or trigger_error($lang_error['DELETE_ERROR'], E_USER_ERROR);

	$t_ = array(
		'MESSAGE'	=> $lang['deletionsuccess']
	);

	$TEMPLATE->load("message.tpl");
	$TEMPLATE->assign($t_);
	$TEMPLATE->publish();

}else{

	$t_ = array(
		'MESSAGE'	=> $lang['permissiondenied']
	);

	$TEMPLATE->load("permission.tpl");
	$TEMPLATE->assign($t_);
	$TEMPLATE->publish();

}
?>