<?php
//File ok to load directly here
define('LOAD_SAFE', true);

//include required root system file
require_once "../../root.php";

$now = date("D, d M Y H:i:s T");

$output = "<?xml version=\"1.0\"?>
<rss version=\"2.0\"
	xmlns:content=\"http://purl.org/rss/1.0/modules/content/\"
	xmlns:wfw=\"http://wellformedweb.org/CommentAPI/\"
	xmlns:dc=\"http://purl.org/dc/elements/1.1/\"
	xmlns:atom=\"http://www.w3.org/2005/Atom\"
	xmlns:sy=\"http://purl.org/rss/1.0/modules/syndication/\"
	xmlns:slash=\"http://purl.org/rss/1.0/modules/slash/\"
	>  
                <channel>
                <title>".$configuration->config_values['website']['title']."</title>
		<atom:link href=\"http://www.kinggoddard.com/modules/news/newsrss.php\" rel=\"self\" type=\"application/rss+xml\" /> 
                <link>http://www.kinggoddard.com/modules/news/newsrss.php</link>
                <description>".$configuration->config_values['website']['description']."</description>
		<language>en-us</language>                    
                <pubDate>".$now."</pubDate>
                <lastBuildDate>".$now."</lastBuildDate>
		<sy:updatePeriod>hourly</sy:updatePeriod> 
		<sy:updateFrequency>1</sy:updateFrequency> 
                <docs>http://cyber.law.harvard.edu/rss/rss.html</docs>
            ";

if(!isset($_GET['newscategory'])){
	$newsgetwhere = "ORDER BY id desc LIMIT 15";
}elseif(isset($_GET['newscategory'], $_GET['page']) && is_numeric($_GET['newscategory'])){
	$newsgetwhere = "WHERE category=". $_GET['newscategory'] ." ORDER BY id desc LIMIT 15";
}else{
	$newsgetwhere = "ORDER BY id desc LIMIT 15";
}

//get current news listing information
	$newsget = "SELECT * FROM news ". $newsgetwhere;
		$query1 = $DB->query($newsget) or trigger_error($lang_error['SELECT_ERROR'], E_USER_ERROR);
	while($r=$DB->fetch_array($query1)){
		$id		=	$r["id"];
		$title		=	$r["title"];
		$category	=	$r["category"];
		$message	=	$r["message"];
		$date		=	$r["date"];
		$author		=	$r["author"];
		$rating		=	$r["rating"];
		$rateoutof	=	$r["rateoutof"];
		$voters		=	$r["voters"];

//identify user that posted news item
	$userget = "SELECT * FROM users WHERE id='$author'";
		$query2 = $DB->query($userget);
	while($r=$DB->fetch_array($query2)){
		$displayname		=	$r["displayname"];


//check if there any comments on this news item and count them
		$commentget = "SELECT * FROM news_comments WHERE newsid='$id'";
		$query3 = $DB->query($commentget) or trigger_error($lang_error['SELECT_ERROR'], E_USER_ERROR);
		$commentcount = $DB->num_rows($query3);

//organize into categories
	$categoryget = "SELECT * FROM category WHERE id='$category'";
		$query3 = $DB->query($categoryget);
	while($r=$DB->fetch_array($query3)){
		$categoryname		=	$r["name"];
		$subcategoryid		=	$r["subcategory"];
		$categorypicture	=	$r["picture"];



			$subcategoryget = "SELECT * FROM category WHERE id='$subcategoryid'";
			$query4 = $DB->query($subcategoryget);
			while($r=$DB->fetch_array($query4)){
				$subcategoryname		=	$r["name"];
				$subcategorypicture		=	$r["picture"];
			}

$output .= "<item>
            	<title>".$title."</title>
            	<link><![CDATA[".$configuration->config_values['website']['url']."/index.php?page=newsview&newsid=".$id."]]></link>
		<comments><![CDATA[".$configuration->config_values['website']['url']."/index.php?page=newsview&amp;newsid=".$id."]]></comments>
            	<description><![CDATA[".$message."]]></description>
		<pubDate>".$date."</pubDate>
		<dc:creator>".$displayname."</dc:creator>
		<wfw:commentRss><![CDATA[".$configuration->config_values['website']['url']."/index.php?page=newsview&amp;newsid=".$id."]]></wfw:commentRss>
		<slash:comments>0</slash:comments>
	    </item>";

	}
	}
	}

$output .= "</channel></rss>";
header("Content-Type: application/rss+xml");
echo $output;
?>
