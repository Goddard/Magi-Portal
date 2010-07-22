<?php
//File ok to load directly here
define('LOAD_SAFE', true);

//include required root system file
require_once $_SERVER["DOCUMENT_ROOT"]."/root.php";

include($_SERVER["DOCUMENT_ROOT"]."/header.php");

$news_id = NULL;

if(is_numeric($_GET['newsid']) && isset($_GET['rate'])){

	$news_id = $_GET['newsid'];

//get current news listing information
	$query1 = $DB->query("SELECT * FROM news WHERE id=$news_id");
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
		
	}

   if($_SESSION['logged']=='true' && preg_match("/\b".$_SESSION['uid']."\b/i", $voters)==false){

	   $user_id = $_SESSION['uid'];

	   if($_GET['rate']=="+1")
	   {
	
	   	$rating = $rating + 1;
		
	   }elseif($_GET['rate']=="-1"){
	
		   $rating = $rating - 1;
		
	   }
	
	   $rateoutof++;

		$sql2 = "UPDATE news SET rating='$rating', rateoutof='$rateoutof' , voters = CONCAT(voters, '$user_id:') WHERE id='$id'";
		$query2 = $DB->query($sql2) or trigger_error($lang_error['UPDATE_ERROR'],E_USER_ERROR);

	   echo "Thanks for voting.";
	
   }else{

	   echo "Only registered users can vote.";
	
   }

}else{

	die("No");
	
}
?>