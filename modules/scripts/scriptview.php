<?php
defined('LOAD_SAFE') or die('Server Error');

include("application/language/".$language."/news.lang.php");

$script_id = NULL;

	if($_SESSION['logged']=="true"){
		$_SESSION['key'] = NULL;
	}

if(!isset($_POST['message'], $_REQUEST['Submit'], $_POST['referenceid']) && is_numeric($_GET['scriptid'])){
	
	$script_id = $_GET['scriptid'];	
	
//get current news listing information
		$query1 = $DB->query("SELECT * FROM scripts WHERE id=$script_id");
	while($r=$DB->fetch_array($query1)){
		$id				=	$r["id"];
		$uid				=	$r["uid"];
		$scriptname		=	$r["name"];
		$contents			=	$r["contents"];
		$scriptdate		=	$r["date"];
		$flag			=	$r["flag"];
		$share			=	$r["share"];
		$scriptcomment		=	$r["comment"];
		$commentable		=	$r["commentable"];
	}

//identify user that posted news item
		$query2 = $DB->query("SELECT * FROM users WHERE id='$uid'");
	while($r=$DB->fetch_array($query2)){
		$scriptauthor		=	$r["displayname"];
	}

if($_SESSION['logged']=="true" && $_SESSION['userlevel']>=200 && !isset($_GET['logout']) || $_SESSION['logged']=="true" && !isset($_GET['logout']) && $_SESSION['username']==$scriptauthor){
	$editnews 	= "<a href=\"index.php?page=scriptedit&amp;scriptid=".$id."\">" . $lang['edit'] . "</a>";
	$deletenews 	= "<a href=\"index.php?page=scriptdelete&amp;scriptid=".$id."\">" . $lang['delete'] . "</a>";
}else{
	$editnews 	= "";
	$deletenews 	= "";
}

if($commentable==1){
	$comments = $lang['comments'];
}else{
	$comments = $lang['nocomments'];
}
	$t_ = array(
		'EDIT'	 		=> $editnews,
		'DELETE' 			=> $deletenews,
		'SCRIPT_DATE'	 	=> $scriptdate,
		'SCRIPT_AUTHOR'	=> $scriptauthor,
		'SCRIPT_NAME'	 	=> $scriptname,
		'SCRIPT_CONTENT'	=> $contents,
		'SCRIPT_COMMENT'	=> $scriptcomment,
		'COMMENTS'		=> $comments,
	);

	$TEMPLATE->load("scriptview.tpl");
		$TEMPLATE->assign($t_);
			$TEMPLATE->publish();

		$query3 = $DB->query("SELECT * FROM script_comments WHERE scriptid='$id'");
	while($r=$DB->fetch_array($query3)){
		$comment_date		=	$r["date"];
		$comment_author	=	$r["authorid"];
		$comment_message	=	$r["comment"];

if($_SESSION['logged']=="true" && $_SESSION['userlevel']>=200 && !isset($_GET['logout'])){
			$comment_ip	=	"(".$r["ip"].")";
}else{
			$comment_ip	=	"";
}

if($comment_author!=0){
//identify user that posted news item
		$query2 = $DB->query("SELECT * FROM users WHERE id='$comment_author'");
	while($r=$DB->fetch_array($query2)){
		$displayname		=	$r["displayname"];
	}
}else{
	$displayname = "Guest";
}


	$t_ = array(
		'COMMENT_DATE'	 			=> $comment_date,
		'COMMENT_AUTHOR' 			=> $displayname,
		'COMMENT_MESSAGE' 			=> $comment_message,
		'COMMENT_IP' 				=> $comment_ip
	);

	$TEMPLATE->load("comment.tpl");
		$TEMPLATE->assign($t_);
			$TEMPLATE->publish();

	}

if(($commentable==1 && $configuration->config_values['permissions']['guest_comments']==true) || ($commentable==1 && $_SESSION['logged']=="true" && $configuration->config_values['permissions']['guest_comments']==false)){

	if($configuration->config_values['permissions']['guest_captcha']==true && $_SESSION['logged']=="false"){
		$captchalink = $lang['spam'].":* <li><img src='/plugins/captcha/captcha.php'><br /><input name=\"number\" type=\"text\"></li>";
	}else{
		$captchalink = "";
	}

	$t_ = array(
		'ACTION'				=> "?page=scriptview",
		'NAME'				=> $lang['name'],
		'MESSAGE'				=> $lang['message'],
		'REQUIRED'			=> $lang['require'],
		'RESET'				=> $lang['reset'],
		'SUBMIT'				=> $lang['submit'],
		'EMAIL'				=> $lang['email'],
		'REFERENCE_ID'			=> $id,
		'CAPTCHA_LINK'			=> $captchalink,
	);


	$TEMPLATE->load("comment_form.tpl");
		$TEMPLATE->assign($t_);
			$TEMPLATE->publish();

}else{
if($commentable==1){
	echo "You must be logged into to post a comment";
}else{

}

}

}elseif(isset($_POST['message'], $_REQUEST['Submit'], $_POST['referenceid']) && is_numeric($_POST['referenceid'])){
	if(!isset($_POST['number'])){
		$_POST['number']=NULL;
	}
if($configuration->config_values['permissions']['guest_captcha']==true && $_POST['number']==substr($_SESSION['key'],0,5) || $configuration->config_values['permissions']['guest_captcha']==false || $_SESSION['logged']=="true"){

		$userid = $_SESSION['uid'];
		$reference_id = $_POST['referenceid'];
		$comment_message = htmlspecialchars($_POST['message']);

		$DB->query("INSERT INTO script_comments (scriptid, authorid, date, comment, ip)VALUES('$reference_id', '$userid', '$date_time', '$comment_message', '$ip')") or trigger_error($lang_error['INSERT_ERROR'], E_USER_ERROR);

	$t_ = array(
		'MESSAGE'		=> "Your comment was posted successfully."
		);

	$TEMPLATE->load("message.tpl");
		$TEMPLATE->assign($t_);
			$TEMPLATE->publish();
}
}else{
	$t_ = array(
		'MESSAGE'		=> $lang['permissiondenied']
		);

	$TEMPLATE->load("permission.tpl");
		$TEMPLATE->assign($t_);
			$TEMPLATE->publish();
}
?>
