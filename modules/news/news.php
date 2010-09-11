<?php
defined('LOAD_SAFE') or die('Server Error');

include("application/language/".$language."/news.lang.php");

if(!isset($_GET['newscategory']))
{

	$newsgetwhere = "ORDER BY id desc LIMIT 5";
	
}elseif(isset($_GET['newscategory'], $_GET['page']) && is_numeric($_GET['newscategory']))
{

	$newsgetwhere = "WHERE category=". $_GET['newscategory'] ." ORDER BY id desc LIMIT 5";
	$findsubcategories = "SELECT * FROM category WHERE subcategory=".$_GET['newscategory'];
	$query4 = $DB->query($findsubcategories);
		
	foreach($query4 as $r)
	{
	
		$topcategory			      =	$r["id"];
		$topcategoryname		      =	$r["name"];
		$topcategorydescription		=	$r["description"];
		$topcategorypicture		   =	$r["picture"];
		
	   if($topcategory!=0)
	   {
	
	   $t_ = array(
		   'TOP_SUBCATEGORY' 		         => "<a href=\"?page=news&amp;newscategory=$topcategory\">$topcategoryname</a>",
		   'TOP_SUBCATEGORY_DESCRIPTION' 	=> $topcategorydescription,
		   'TOP_SUBCATEGORY_PICTURE' 	      => "<img src=\"./" . $configuration->config_values['template']['template_dir'] . "/" .$configuration->config_values['template']['default_template'] . "/img/" . $topcategorypicture ."\">"
	   );

	   $TEMPLATE->load("newssub.tpl");
	   $TEMPLATE->assign($t_);
	   $TEMPLATE->publish();	

	   }
	
   }

}else{

	$newsgetwhere = "ORDER BY id desc LIMIT 5";
	
}


//get current news listing information
	$newsget = "SELECT * FROM news ". $newsgetwhere ."";
	$query1 = $DB->query($newsget) or trigger_error($lang_error['SELECT_ERROR'], E_USER_ERROR);
		
	foreach($query1 as $r)
	{
	
		$id		   =	$r["id"];
		$title		=	$r["title"];
		$category	=	$r["category"];
		$message	   =	$r["message"];
		$date		   =	$r["date"];
		$author		=	$r["author"];
		$rating		=	$r["rating"];
		$rateoutof	=	$r["rateoutof"];
		$voters		=	$r["voters"];
 
	   if($rating > 0)
	   {
	
		   $rating = "+".$rating;
		
	   }else{
	
		   $rating = $rating;
		   
	   }
	
	   if($_SESSION['logged'] == 'true' && preg_match("/\b".$_SESSION['uid']."\b/i", $voters))
	   {
	
	   	$rate_minus    = $rating. " out of ";
	   	$rate_plus     = $rateoutof. " votes";
		
	   }else{
	
	   	$rate_plus     = "<a href=\"javascript: MyAjaxRequest('rate$id','/modules/news/newsrate.php?newsid=".$id."&amp;rate=+1')\">+1</a>";
	   	$rate_minus    = "<a href=\"javascript: MyAjaxRequest('rate$id','/modules/news/newsrate.php?newsid=".$id."&amp;rate=-1')\">-1</a>";
		
	   }

	   $title = "<a href=\"?page=newsview&amp;newsid=$id\">$title</a>";

//identify user that posted news item
	   $userget = "SELECT * FROM users WHERE id='$author'";
	   $query2 = $DB->query($userget);
	   
      foreach($query2 as $r)
	   {
	   
		$displayname		=	$r["displayname"];

      if($_SESSION['logged'] == 'true' && $_SESSION['userlevel'] >= 100 && !isset($_GET['logout']) || $_SESSION['logged'] == 'true' && !isset($_GET['logout']) && $_SESSION['username'] == $displayname)
      {
      
      	$editnews 	   = "<a href=\"index.php?page=newsedit&amp;newsid=".$id."\">" . $lang['edit'] . "</a>";
	      $deletenews 	= "<a href=\"index.php?page=newsdelete&amp;newsid=".$id."\">" . $lang['delete'] . "</a>";
	      
      }else{
      
	      $editnews 	   = "";
	      $deletenews 	= "";
	      
      }

//check if there any comments on this news item and count them
		$commentget = "SELECT * FROM news_comments WHERE newsid='$id'";
		$query3 = $DB->query($commentget) or trigger_error($lang_error['SELECT_ERROR'], E_USER_ERROR);
      $commentcount = $query3->rowCount();
//organize into categories
	   $categoryget = "SELECT * FROM category WHERE id='$category'";
	   $query3 = $DB->query($categoryget);
	   
      foreach($query3 as $r)
	   {
	   
		   $categoryname		=	$r["name"];
		   $subcategoryid		=	$r["subcategory"];
		   $categorypicture	=	$r["picture"];

			$subcategoryget = "SELECT * FROM category WHERE id='$subcategoryid'";
			$query4 = $DB->query($subcategoryget);
			
         foreach($query4 as $r)
			{
			
				$subcategoryname		   =	$r["name"];
				$subcategorypicture		=	$r["picture"];
				
			}

	      $t_ = array(
		      'ID'	 		         => $id,
		      'EDIT'	 		      => $editnews,
		      'DELETE' 		      => $deletenews,
		      'TITLE' 		         => $title,
		      'RATE_MINUS' 		   => $rate_minus,
		      'RATE_PLUS' 		   => $rate_plus,
		      'RATING' 		      => $rating,
		      'CATEGORY' 		      => "<a href=\"?page=news&amp;newscategory=$category\">$categoryname</a>",
		      'SUBCATEGORY' 		   => "<a href=\"?page=news&amp;newscategory=$subcategoryid\">$subcategoryname</a>",
		      'PRINT' 		         => "<a href=\"?page=newsprint&amp;newsid=" . $id . "\">".$lang['print']."</a>",
		      'MESSAGE' 		      => $message,
		      'DATE' 			      => $date,
		      'COMMENT_COUNT' 	   => "<a href=\"?page=newsview&amp;newsid=$id\">".$lang['comment']."(" . $commentcount . ")</a>",
		      'AUTHOR' 		      => $displayname,
		      'CATEGORY_PIC' 		=> "<img src=\"./" . $configuration->config_values['template']['template_dir'] . "/" .$configuration->config_values['template']['default_template'] . "/img/" . $categorypicture ."\">",
		      'FACEBOOK_SITE_URL'	=> $configuration->config_values['website']['url'] . "?page=newsview&newsid=" . $id
	      );

	      $TEMPLATE->load("news.tpl");
	      $TEMPLATE->assign($t_);
	      $TEMPLATE->publish();
	      
	      }

	   }

	}

?>