<?php
defined('LOAD_SAFE') or die('Server Error');

include("application/language/".$language."/delete.lang.php");

$messages_id = NULL;

if($_SESSION['logged']=="true" && $_SESSION['userlevel']>=1 && !isset($_REQUEST['Submit'], $_POST['referenceid'], $_POST['referenceuid']) && is_numeric($_GET['messagesid']))
{

	$messages_id = $_GET['messagesid'];

	$query = $DB->query("SELECT * FROM messages WHERE id='" . $messages_id . "'");
   $messagesfound = $query->rowCount();
   
	$t_ = array(
		'MESSAGES_DELETE_TITLE'			   => $lang['deletetitle'],
		'MESSAGES_DELETE_SUB_TITLE'		=> $lang['confirmationmsg'],
		'MESSAGES_DELETE_ID' 			   => $_GET['messagesid'],
		'MESSAGES_DELETE_UID' 			   => $_SESSION['uid'],
		'MESSAGES_DELETE_FOUND' 		   => $messagesfound,
		'CONFIRM'					         => $lang['confirm'],
	);

	$TEMPLATE->load("messagesdelete.tpl");
	$TEMPLATE->assign($t_);
	$TEMPLATE->publish();

}elseif($_POST['messagesfound']==1 && $_SESSION['logged']=="true" && $_SESSION['userlevel']>=200 && isset($_REQUEST['Submit'], $_POST['referenceid'], $_POST['referenceuid']) && is_numeric($_POST['referenceid']) && is_numeric($_POST['referenceuid']) && $_POST['referenceuid'] == $_SESSION['uid'])
{

	$messages_id  = $_POST['referenceid'];	
   $messages_uid = $_POST['referenceuid'];
   
	$query1 = $DB->query("DELETE FROM messages WHERE id=$messages_id") or trigger_error($lang_error['DELETE_ERROR'], E_USER_ERROR);

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