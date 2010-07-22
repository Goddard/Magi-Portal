<?php
defined('LOAD_SAFE') or die('Server Error');

include("application/language/".$language."/news.lang.php");

$news_id = NULL;
$selected = NULL;
$checked_yes = NULL;
$checked_no = NULL;

if($_SESSION['userlevel']>=200 && !isset($_REQUEST['Submit']) && !isset($_REQUEST['logout']) && is_numeric($_GET['newsid']) && !isset($_POST['newsid']))
{

	$news_id = $_GET['newsid'];

//get current news listing information to edit
	$query1 = $DB->query("SELECT * FROM news WHERE id=$news_id") or trigger_error($lang_error['SELECT_ERROR'], E_USER_ERROR);
	foreach($query1 as $r)
	{
	
		$id			   =	$r["id"];
		$title		   =	$r["title"];
		$category		=	$r["category"];
		$message		   =	$r["message"];
		$date		      =	$r["date"];
		$author		   =	$r["author"];
		$commentable	=	$r["commentable"];
		
		$message = html_entity_decode($message);
		
	}

	$newscategoryoptions = "";
	$newscategories = $DB->query("SELECT id, name FROM category WHERE categorytype=1") or trigger_error($lang_error['SELECT_ERROR'], E_USER_ERROR);
	foreach($newscategories as $r)
	{
	
		$cat_id		   =	$r["id"];
		$cat_name		=	$r["name"];

		if($cat_id == $category)
		{
		
			$selected = "selected";
			
		}else{
		
			$selected = "";
			
		}

	   $newscategoryoptions .= "<option value=\"$cat_id\" $selected>$cat_name</option>";
	
	}



	if($commentable == 1)
	{
		
		$checked_yes = "checked=\"checked\"";
			
	}else{
		
		$checked_no = "checked=\"checked\"";
			
	}

	$t_ = array(
		'CHECKED_NO' 			   => $checked_no,
		'CHECKED_YES' 			   => $checked_yes,
		'NEWS_EDIT_ID' 		   => $id,
		'NEWS_EDIT_TITLE' 		=> $title,
		'NEWS_EDIT_MESSAGE' 	   => $message,
		'NEWS_ADD_TITLE' 		   => $lang['newsaddtitle'],
		'NEWS_ADD_SUB_TITLE' 	=> $lang['newsaddsubtitle'],
		'NEWS_CATEGORIES' 		=> $newscategoryoptions,
		'TITLE' 				      => $lang['title'],
		'CATEGORY' 			      => $lang['category'],
		'MESSAGE' 			      => $lang['message'],
		'RESET'				      => $lang['reset'],
		'ALLOW_COMMENT'	   	=> $lang['allowcomment'],
		'SUBMIT'				      => $lang['submit'],
		'REQUIRED'			      => $lang['require']
	);

	$TEMPLATE->load("newsedit.tpl");
	$TEMPLATE->assign($t_);
	$TEMPLATE->publish();

}elseif($_SESSION['userlevel']>=200 && isset($_REQUEST['Submit']) && !isset($_REQUEST['logout']) && is_numeric($_POST['newsid']) && isset($_POST['newsid']))
{

		$news_id     = $_POST['newsid'];
		$title       = $_POST['title'];
		$message     = $_POST['message'];
		$category    = $_POST['category'];
		$commentable = $_POST['commentable'];
		$userid      = $_SESSION['uid'];

		$sql = "UPDATE news SET title='$title', category='$category', message='$message', date='$date_time', author='$userid', ip='$ip', commentable='$commentable' WHERE id='$news_id'";
		$DB->query($sql) or trigger_error($lang_error['INSERT_ERROR'], E_USER_ERROR);

		//dirty fast version probably wont work with all browsers and server settings
		header('Location: ?page=newsview&newsid='.$news_id);

}else{

	$t_ = array(
		'MESSAGE'	 			=> $lang['permissiondenied'],
	);

	$TEMPLATE->load("permission.tpl");
	$TEMPLATE->assign($t_);
	$TEMPLATE->publish();

}

?>