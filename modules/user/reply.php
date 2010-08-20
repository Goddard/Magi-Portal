<?php
////////////////////////////////////
// page load security
////////////////////////////////////
defined('LOAD_SAFE') or die('Server Error');

include("application/language/".$language."/news.lang.php");

if($_SESSION['logged'] == true && !isset($_REQUEST['Submit']) && !isset($_REQUEST['logout']) && is_numeric($_GET['userid']))
{

   $user_id = $_GET['userid'];

	$userget = $DB->query("SELECT id FROM users WHERE id='" . $user_id . "'");
	$usercount = $userget->rowCount();

   if($usercount != 0){

	   $t_ = array(
		   'NEWS_ADD_TITLE' 	      => "send message"
	   );

	   $TEMPLATE->load("messagesend.tpl");
	   $TEMPLATE->assign($t_);
	   $TEMPLATE->publish();
	
	}else{
	   
	   $t_ = array(
	   	'MESSAGE'	=> $lang['permissiondenied'],
	   );

	   $TEMPLATE->load("permission.tpl");
	   $TEMPLATE->assign($t_);
	   $TEMPLATE->publish();
	
	}

}elseif($_SESSION['logged'] == true && isset($_POST['Submit']) && !isset($_REQUEST['logout']) && is_numeric($_POST['userid']) && $_POST['userid'] != 0)
{

   $title       = $_POST['title'];
   $message     = $_POST['message'];
   $category    = $_POST['category'];
	$commentable = $_POST['commentable'];
	$userid      = $_SESSION['uid']; 
      
   $sql1 = "INSERT INTO news (title, category, message, date, author, ip, commentable)VALUES(?, ?, ?, ?, ?, ?, ?)";
	$query1 = $DB->prepare($sql1) or trigger_error($lang_error['INSERT_ERROR'], E_USER_ERROR);
   $query1->execute(array($title, $category, $message, $date_time, $userid, $ip, $commentable));
      
	//dirty fast version probably wont work with all browsers and server settings
	$post_id = $DB->lastInsertId();
	header('Location: ?page=newsview&newsid='.$post_id);

}else{

	$t_ = array(
		'MESSAGE'	=> $lang['permissiondenied'],
	);

	$TEMPLATE->load("permission.tpl");
	$TEMPLATE->assign($t_);
	$TEMPLATE->publish();

}

?>