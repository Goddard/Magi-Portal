<?php
defined('LOAD_SAFE') or die('Server Error');

	include("application/language/".$language."/user.lang.php");

if($_SESSION['logged']=="true" && $_SESSION['userlevel']>=1 && !isset($_GET['logout']) && !isset($_REQUEST['Submit'])){
	
	if(empty($_SESSION['avatar'])){
		$avatar = "No Image";
	}else{
		$avatar = $_SESSION['avatar'];
	}
//creationdate
	$t_ = array(
		'AVATAR'				=> $avatar,
		'DISPLAY_NAME'			=> $_SESSION['username'],
		'ACTIVITY_LEVEL'		=> $_SESSION['activitylevel'],
		'USER_TITLE'			=> $lang['usercp'],
		'USER_INTRO'			=> "Welcome to the magi portal user control panel.  You can moderatre and control your account profile, scripts, tutorial submissions, clan, and team information.",
	);

	$TEMPLATE->load("statistics.tpl");
		$TEMPLATE->assign($t_);
			$TEMPLATE->publish();
}

?>
