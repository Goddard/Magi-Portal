<?php
defined('LOAD_SAFE') or die('Server Error');

$script_id = NULL;

		$sql = "SELECT * FROM scripts WHERE share='1' ORDER BY id asc LIMIT 10";
		$query = $DB->query($sql) or trigger_error($lang_error['SELECT_ERROR'], E_USER_ERROR);
		$userfound = $DB->num_rows($query);

	while($r=$DB->fetch_array($query)){
		$id			=	$r["id"];
		$uid			=	$r["uid"];
		$scriptname		=	$r["name"];
		$contents		=	$r["contents"];
		$scriptdate		=	$r["date"];
		$flag			=	$r["flag"];
		$share			=	$r["share"];
		$scriptcomment		=	$r["comment"];
		$commentable		=	$r["commentable"];

	$scriptname = "<a href=\"?page=scriptview&amp;scriptid=$id\">$scriptname</a>";

	$userget = "SELECT * FROM users WHERE id='$uid'";
		$query2 = $DB->query($userget);
	while($r=$DB->fetch_array($query2)){
		$scriptauthor		=	$r["displayname"];

if($_SESSION['logged']=="true" && $_SESSION['userlevel']>=200 && !isset($_GET['logout']) || $_SESSION['logged']=="true" && !isset($_GET['logout']) && $_SESSION['username']==$scriptauthor){
	$editnews 	= "<a href=\"index.php?page=scriptedit&amp;scriptid=".$id."\">" . $lang['edit'] . "</a>";
	$deletenews 	= "<a href=\"index.php?page=scriptdelete&amp;scriptid=".$id."\">" . $lang['delete'] . "</a>";
}else{
	$editnews 	= "";
	$deletenews 	= "";
}

	}

//check if there any comments on this news item and count them
		$commentget = "SELECT * FROM script_comments WHERE scriptid='$id'";
		$query3 = $DB->query($commentget) or trigger_error($lang_error['SELECT_ERROR'], E_USER_ERROR);
		$commentcount = $DB->num_rows($query3);

	$t_ = array(
		'EDIT'	 		=> $editnews,
		'DELETE' 		=> $deletenews,
		'SCRIPT_DATE'	 	=> $scriptdate,
		'SCRIPT_AUTHOR'	 	=> $scriptauthor,
		'SCRIPT_NAME'	 	=> $scriptname,
		'SCRIPT_CONTENT'	=> $contents,
		'SCRIPT_COMMENT'	=> $scriptcomment,
		'COMMENT_COUNT' 	=> "<a href=\"?page=scriptview&amp;scriptid=$id\">Comment[" . $commentcount . "]</a>",
	);

	$TEMPLATE->load("scripts.tpl");
		$TEMPLATE->assign($t_);
			$TEMPLATE->publish();
}
?>
