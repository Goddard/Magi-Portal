<?php
defined('LOAD_SAFE') or die('Server Error');

include("application/language/".$language."/news.lang.php");

if(is_numeric($_GET['newsid']))
{
	
	$news_id = $_GET['newsid'];	
	
//get current news listing information
	$query1 = $DB->query("SELECT * FROM news WHERE id=$news_id");
	foreach($query1 as $r)
	{
	
		$id			   =	$r["id"];
		$title		   =	$r["title"];
		$category		=	$r["category"];
		$message		   =	$r["message"];
		$date		      =	$r["date"];
		$author	   	=	$r["author"];
		$commentable	=	$r["commentable"];
		
	}

//identify user that posted news item
	$query2 = $DB->query("SELECT * FROM users WHERE id='$author'");
	foreach($query2 as $r)
	{
	
		$displayname		=	$r["displayname"];
		
	}

//organize into categories
	$query3 = $DB->query("SELECT * FROM category WHERE id='$category'");
	foreach($query3 as $r)
	{
	
		$categoryname		=	$r["name"];
		
	}

	$t_ = array(
		'TITLE' 			   => $title,
		'CATEGORY' 		   => $categoryname,
		'MESSAGE' 		   => $message,
		'DATE' 			   => $date,
		'AUTHOR' 			=> $displayname,
		'TEMPLATE_PATH'	=> $configuration->config_values['template']['template_dir']."/".$configuration->config_values['template']['default_template'],
		'KING_GODDARD' 	=> 'King Goddard',
		'MAGI_PORTAL' 		=> 'Magi Portal',
		'TITLE' 				=> $configuration->config_values['website']['title'],
		'SLOGAN' 			=> $configuration->config_values['website']['slogan'],
		'DESCRIPTION' 		=> $configuration->config_values['website']['description'],
		'KEYWORDS' 			=> $configuration->config_values['website']['keywords'],
		'AUTHOR' 			=> $configuration->config_values['website']['author'],
	);

	$TEMPLATE->load("newsprint.tpl");
	$TEMPLATE->assign($t_);
	$TEMPLATE->publish();

}
?>
