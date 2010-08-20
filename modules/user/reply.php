<?php
////////////////////////////////////
// page load security
////////////////////////////////////
defined('LOAD_SAFE') or die('Server Error');

if($_SESSION['logged'] == true && !isset($_REQUEST['Submit']) && !isset($_REQUEST['logout']) && is_numeric($_GET['userid']) && !isset($_POST['replyid']))
{

   $user_id = $_GET['userid'];

	$userget = $DB->query("SELECT id FROM users WHERE id='" . $user_id . "'");
	$usercount = $userget->rowCount();

   if($usercount != 0){

	   $t_ = array(
		   'PM_SEND_TITLE' 	      => "Private Message",
		   'PM_SEND_SUB_TITLE' 	   => "Send a message to a individual user or group.",
		   'PM_SUBJECT' 	         => "Subject",
		   'PM_MESSAGE' 	         => "Message",
		   'USERID'    	         => $user_id,
		   'REQUIRED' 	            => $lang['require'],
		   'SUBMIT' 	            => $lang['submit'],
		   'RESET' 	               => $lang['reset'],
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

}elseif($_SESSION['logged'] == true && isset($_POST['Submit']) && !isset($_REQUEST['logout']) && is_numeric($_POST['replyid']) && $_POST['replyid'] != 0)
{

   $subject     = $_POST['subject'];
   $message     = $_POST['message'];
	$replyid     = $_POST['replyid'];
	$userid      = $_SESSION['uid'];      
      
   $sql1 = "INSERT INTO messages (pid, rid, date, subject, message)VALUES(?, ?, ?, ?, ?)";
	$query1 = $DB->prepare($sql1) or trigger_error($lang_error['INSERT_ERROR'], E_USER_ERROR);
   $query1->execute(array($userid, $replyid, $date_time, $subject, $message));
      
	   $t_ = array(
		   'MESSAGE_HEADING' 	      => "Message Sent",
		   'MESSAGE_DESCRIPTION' 	   => "Private message was sent.",
		   'MESSAGE' 	               => "Your private message was sent successfully."
	   );

	   $TEMPLATE->load("message.tpl");
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

?>