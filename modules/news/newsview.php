<?php
////////////////////////////////////
// page load security
////////////////////////////////////
defined('LOAD_SAFE') or die('Server Error');

include("application/language/".$language."/news.lang.php");

$news_id = NULL;

if($_SESSION['logged']=="true")
{

	$_SESSION['key'] = NULL;

}

if(isset($_REQUEST['Submit']) && !isset($_GET['newsid']) || !is_numeric($_GET['newsid']))
{

	$_GET['newsid'] = 1;
	
}

if(!isset($_POST['message'], $_REQUEST['Submit'], $_POST['referenceid']) && is_numeric($_GET['newsid']))
{
	
	$news_id = $_GET['newsid'];	

	$query1 = $DB->query("SELECT * FROM news WHERE id=$news_id");
   $newsfound = $query1->rowCount();
   
   if($newsfound==1)
   {
	
	   foreach($query1 as $r)
	   {
	   
		   $id		      =	$r["id"];
		   $title		   =	$r["title"];
		   $category	   =	$r["category"];
		   $message	      =	$r["message"];
		   $date		      =	$r["date"];
		   $author		   =	$r["author"];
		   $rating		   =	$r["rating"];
		   $rateoutof	   =	$r["rateoutof"];
		   $commentable	=	$r["commentable"];
		   $voters		   =	$r["voters"];
		   $views		   =	$r["views"];
		   
	   }

	$views++;

	$sql1 = "UPDATE news SET views='$views' WHERE id='$id'";
		$query2 = $DB->query($sql1) or trigger_error($lang_error['UPDATE_ERROR'], E_USER_ERROR);

	if($rating > 0)
	{
	
		$rating = "+".$rating;
		
	}else{
	
		$rating = $rating;
		
	}

	if($_SESSION['logged']=='true' && preg_match("/\b".$_SESSION['uid']."\b/i", $voters))
	{
	
		$rate_minus = $rating. " out of ";
		$rate_plus = $rateoutof. " votes";
		
	}else{
	
		$rate_plus = "<a href=\"javascript: MyAjaxRequest('rate$id','/modules/news/newsrate.php?newsid=".$id."&amp;rate=+1')\">+1</a>";
		$rate_minus = "<a href=\"javascript: MyAjaxRequest('rate$id','/modules/news/newsrate.php?newsid=".$id."&amp;rate=-1')\">-1</a>";
		
	}

//identify user that posted news item
	$query2 = $DB->query("SELECT * FROM users WHERE id='$author'");
	foreach($query2 as $r)
	{
	
		$displayname		=	$r["displayname"];
		
	}

	if($_SESSION['logged']=="true" && $_SESSION['userlevel']>=200 && !isset($_GET['logout']) || $_SESSION['logged']=="true" && !isset($_GET['logout']) && $_SESSION['username']==$displayname)
	{
	
		$editnews 	= "<a href=\"index.php?page=newsedit&amp;newsid=".$id."\">" . $lang['edit'] . "</a>";
		$deletenews 	= "<a href=\"index.php?page=newsdelete&amp;newsid=".$id."\">" . $lang['delete'] . "</a>";
		
	}else{
	
		$editnews 	= "";
		$deletenews 	= "";
		
	}

//organize into categories
	$query3 = $DB->query("SELECT * FROM category WHERE id='$category'");

	foreach($query3 as $r)
	{
	
		$categoryname		=	$r["name"];
		$subcategory		=	$r["subcategory"];
		$categorypicture	=	$r["picture"];
		
	}

	if($subcategory != 0)
	{
	
		$subcategoryget = "SELECT * FROM category WHERE id='$subcategory'";
		$query4 = $DB->query($subcategoryget);

		foreach($query4 as $r)
		{
		
			$subcategoryname	=	$r["name"];
			
		}

	}else{

		$subcategoryname = NULL;

	}

	if($commentable==1)
	{
	
		$comments = $lang['comments'];
		
	}else{
	
		$comments = $lang['nocomments'];
		
	}

	$t_ = array(
		'ID'	 		   => $id,
		'EDIT'	 		=> $editnews,
		'DELETE' 		=> $deletenews,
		'COMMENTS' 		=> $comments,
		'TITLE' 		   => $title,
		'RATE_MINUS' 	=> $rate_minus,
		'RATE_PLUS' 	=> $rate_plus,
		'RATING' 		=> $rating,
		'CATEGORY' 		=> "<a href=\"?page=news&amp;newscategory=$category\">$categoryname</a>",
		'SUBCATEGORY' 	=> "<a href=\"?page=news&amp;newscategory=$subcategory\">$subcategoryname</a>",
		'PRINT' 		   => "<a href=\"?page=newsprint&amp;newsid=".$id."\">".$lang['print']."</a>",
		'MESSAGE' 		=> $message,
		'DATE' 			=> $date,
		'CATEGORY_PIC' => "<img src=\"./" . $configuration->config_values['template']['template_dir'] . "/" .$configuration->config_values['template']['default_template'] . "/img/" . $categorypicture ."\">",
		'AUTHOR' 		=> $displayname
	);

	$TEMPLATE->load("newsview.tpl");
	$TEMPLATE->assign($t_);
	$TEMPLATE->publish();

	$query5 = $DB->query("SELECT * FROM news_comments WHERE newsid='$id'");
	foreach($query5 as $r)
	{
	
		$comment_date		=	$r["date"];
		$comment_author	=	$r["authorid"];
		$comment_message	=	$r["comment"];

		if($_SESSION['logged']=="true" && $_SESSION['userlevel']>=200 && !isset($_GET['logout']))
		{
		
			$comment_ip	=	"(".$r["ip"].")";
			
		}else{
		
			$comment_ip	=	"";
			
		}

		if($comment_author!=0)
		{
		
		//identify user that posted news item
		$query6 = $DB->query("SELECT * FROM users WHERE id='$comment_author'");

		foreach($query6 as $r)
		{
		
			$displayname		=	$r["displayname"];
			
		}

		}else{
		
			$displayname = "Guest";
			
		}

      $comment_message = html_entity_decode($comment_message);
      
		$t_ = array(
			'COMMENT_DATE'	 	=> $comment_date,
			'COMMENT_AUTHOR' 	=> $displayname,
			'COMMENT_MESSAGE' => $comment_message,
			'COMMENT_IP' 		=> $comment_ip
		);

		$TEMPLATE->load("comment.tpl");
		$TEMPLATE->assign($t_);
		$TEMPLATE->publish();

	}

if(($commentable==1 && $configuration->config_values['permissions']['guest_comments'] == true) || ($commentable == 1 && $_SESSION['logged'] == "true" && $configuration->config_values['permissions']['guest_comments'] == false))
{

	if($configuration->config_values['permissions']['guest_captcha'] == true && $_SESSION['logged'] == "false")
	{

		$captchalink = $lang['spam'].":* <li><img src='plugins/captcha/captcha.php'><br /><input name=\"number\" type=\"text\"></li>";

	}else{

		$captchalink = "";

	}

	$t_ = array(
		'ACTION'			=> "?page=newsview",
		'NAME'			=> $lang['name'],
		'MESSAGE'		=> $lang['message'],
		'REQUIRED'		=> $lang['require'],
		'RESET'			=> $lang['reset'],
		'SUBMIT'			=> $lang['submit'],
		'EMAIL'			=> $lang['email'],
		'REFERENCE_ID'	=> $id,
		'CAPTCHA_LINK'	=> $captchalink,
	);


	$TEMPLATE->load("comment_form.tpl");
	$TEMPLATE->assign($t_);
	$TEMPLATE->publish();

}else{

	if($commentable==1)
	{

		$t_ = array(
			'MESSAGE_HEADING'		   => "Message Status",
			'MESSAGE_DESCRIPTION'	=> "Comment post status",
			'MESSAGE'				   => "You must be logged in to post a comment."
			);

		$TEMPLATE->load("message.tpl");
		$TEMPLATE->assign($t_);
		$TEMPLATE->publish();

	}

}
	}else{

		$t_ = array(
			'MESSAGE'   => $lang['permissiondenied']
		);

		$TEMPLATE->load("permission.tpl");
		$TEMPLATE->assign($t_);
		$TEMPLATE->publish();
		
	}

}elseif(isset($_POST['message'], $_REQUEST['Submit'], $_POST['referenceid']) && is_numeric($_POST['referenceid']))
{

	if(!isset($_POST['number']))
	{
	
		$_POST['number'] = NULL;
		
	}

	if($configuration->config_values['permissions']['guest_captcha']==true && $_POST['number']==substr($_SESSION['key'],0,7) || $configuration->config_values['permissions']['guest_captcha']==false || $_SESSION['logged']=="true")
	{

		$userid = $_SESSION['uid'];
		$reference_id = $_POST['referenceid'];
		$comment_message = $_POST['message'];

      $commentprepare = $DB->prepare("INSERT INTO news_comments (newsid, authorid, date, comment, ip)VALUES(?, ?, ?, ?, ?)") or trigger_error($lang_error['INSERT_ERROR'], E_USER_ERROR);
      $commentprepare->execute(array($reference_id, $userid, $date_time, $comment_message, $ip));


		//$DB->query("INSERT INTO news_comments (newsid, authorid, date, comment, ip)VALUES('$reference_id', '$userid', '$date_time', '$comment_message', '$ip')") or trigger_error($lang_error['INSERT_ERROR'], E_USER_ERROR);

		$t_ = array(
			'MESSAGE_HEADING'		   => "Message Status",
			'MESSAGE_DESCRIPTION'	=> "Comment post status",
			'MESSAGE'				   => "Your comment was posted successfully."
			);
			
	}else{
	
		$t_ = array(
			'MESSAGE_HEADING'		   => "Message Status",
			'MESSAGE_DESCRIPTION'	=> "Comment post status",
			'MESSAGE'				   => "You entered the wrong key."
			);
	}
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
