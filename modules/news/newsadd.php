<?php
////////////////////////////////////
// page load security
////////////////////////////////////
defined('LOAD_SAFE') or die('Server Error');

include("application/language/".$language."/news.lang.php");

if($_SESSION['userlevel'] >= 200 && !isset($_REQUEST['Submit']) && !isset($_REQUEST['logout']))
{

	$newscategoryoptions = "";
	$newscategories = $DB->query("SELECT id, name FROM category WHERE categorytype=1");

	foreach($newscategories as $r)
	{
	
		$cat_id		=	$r["id"];
		$cat_name	=	$r["name"];

	$newscategoryoptions .= "<option value=\"$cat_id\">$cat_name</option>";
	
	}

	$t_ = array(
		'NEWS_ADD_TITLE' 	      => $lang['newsaddtitle'],
		'NEWS_ADD_SUB_TITLE' 	=> $lang['newsaddsubtitle'],
		'NEWS_CATEGORIES' 	   => $newscategoryoptions,
		'TITLE' 		            => $lang['title'],
		'CATEGORY' 		         => $lang['category'],
		'MESSAGE' 		         => $lang['message'],
		'RESET'			         => $lang['reset'],
		'ALLOW_COMMENT'	   	=> $lang['allowcomment'],
		'SUBMIT'		            => $lang['submit'],
	);

	$TEMPLATE->load("newsadd.tpl");
	$TEMPLATE->assign($t_);
	$TEMPLATE->publish();

}elseif($_SESSION['userlevel'] >= 200 && isset($_REQUEST['Submit']) && !isset($_REQUEST['logout']))
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