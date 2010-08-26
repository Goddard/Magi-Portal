<?php
defined('LOAD_SAFE') or die('Server Error');

$user_id = NULL;

if($_SESSION['uid']!=0 && !isset($_REQUEST['Submit']) && is_numeric($_SESSION['uid']) && ($_SESSION['logged']=='true'))
{

	$user_id = $_SESSION['uid'];

//get current message listing information
	$messagesget = "SELECT * FROM messages WHERE rid='$user_id'";
	$query1 = $DB->query($messagesget) or trigger_error($lang_error['SELECT_ERROR'], E_USER_ERROR);
	
	foreach($query1 as $r)
	{
	
		$id			   =	$r["id"];
		$postid		   =	$r["pid"];
		$recieverid	   =	$r["rid"];
		$clanid		   =	$r["cid"];
		$teamid		   =	$r["tid"];
		$messagedate	=	$r["date"];
		$subject		   =	$r["subject"];
		$message		   =	$r["message"];
		$fileid		   =	$r["fid"];

	$userget = "SELECT * FROM users WHERE id='$postid'";
	$query2 = $DB->query($userget);

	foreach($query2 as $r)
	{
	
		$displayname		=	$r["displayname"];
		
	}

	$t_ = array(
		'MESSAGE_SENDER' 		=> $displayname,
		'MESSAGE_DATE' 		=> $messagedate,
		'MESSAGE_SUBJECT' 	=> $subject,
		'MESSAGE_BODY' 		=> $message,
		'MESSAGE_DELETE' 		=> "<a href=\"index.php?page=userpanel&amp;user=messagesdelete&amp;messagesid=".$id."\">" . $lang['delete'] . "</a>",
		'MESSAGE_REPLY' 		=> "<a href=\"index.php?page=userpanel&amp;user=sendmessage&amp;userid=".$postid."\">" . $lang['reply'] . "</a>",
	);

	$TEMPLATE->load("messages.tpl");
	$TEMPLATE->assign($t_);
	$TEMPLATE->publish();

	}

}
?>