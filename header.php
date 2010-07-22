<?php
////////////////////////////////////
// page load security
////////////////////////////////////
defined('LOAD_SAFE') or die('Server Error');

////////////////////////////////////
// sql commands
////////////////////////////////////
$sql_1 = "SELECT * FROM sessions";

////////////////////////////////////
// sql queries
////////////////////////////////////
$query_1 = $DB->query($sql_1) or trigger_error($lang_error['SELECT_ERROR'], E_USER_ERROR);

$countusers = $query_1->rowCount();

foreach($query_1 as $r)
{

	$ip2			   =	$r['ip'];
	$username2		=	$r['username'];
  	$usertime		=	$r['time'];
	$stay_logged	=	$r['logged'];

	$user_time_calc = strtotime($usertime);

	if($user_time_calc <= $timeout_calc && $stay_logged == 0)
	{
		
		$sql_2 = "DELETE FROM sessions WHERE ip='$ip2'";
		$DB->query($sql_2) or trigger_error($lang_error['DELETE_ERROR'], E_USER_ERROR);
		
	}
	
}

//if username changes and ip doesn't match user logged in delete old guest session
if($username != $lang['guest'])
{
	
	$sql_3 = "DELETE FROM sessions WHERE ip='$ip' AND username='" . $lang['guest'] . "'";
	
	$DB->query($sql_3) or trigger_error($lang_error['DELETE_ERROR'], E_USER_ERROR);

}

//find out how many rows in db of same ip which is hopefully either 0 or 1 if everything worked right
$sql_4 = "SELECT * FROM sessions WHERE ip='$ip'";

$query_4 = $DB->query($sql_4) or trigger_error($lang_error['SELECT_ERROR'], E_USER_ERROR);

$ipfound = $query_4->rowCount();

//if none then user is new to website
if($ipfound == 0)
{
	
	$sql_5 = "INSERT INTO sessions (ip, username, time, location)VALUES('$ip', '$username', '$date_time', '$location')";

	$DB->query($sql_5) or trigger_error($lang_error['INSERT_ERROR'], E_USER_ERROR);

//if 1 then user has been here surfing already need to update location and time
}elseif($ipfound == 1)
{
	$sql_6 = "UPDATE sessions SET username='$username', time='$date_time', location='$location' WHERE ip='$ip'";
	
	$DB->query($sql_6) or trigger_error($lang_error['UPDATE_ERROR'], E_USER_ERROR);
	
//if there are more then 2 ips found then something is wrong delete all and insert a fresh row.
}elseif($ipfound >= 2)
{

	$sql_7 = "DELETE FROM sessions WHERE ip=$ip";
	
	$sql_8 = "INSERT INTO sessions (ip, username, time, location)VALUES('$ip', '$username', '$date_time', '$location')";
	
	$DB->query($sql_7,$sql_8) or trigger_error($lang_error['INSERT_ERROR'], E_USER_ERROR);

//dont know what the heck happen
}else{
	
	trigger_error($error['DEFAULT_ERROR'], E_USER_ERROR);

}

if($username != $lang['guest'] && !isset($_GET['logout']))
{

	include("application/language/".$language."/user.lang.php");
	$loglink = "<a href=\"index.php?page=login&&logout\" id=\"logoutlink\">" . $lang['logout'] . "</a>";
	$reglink = $lang['register'];
		
	if($_SESSION['userlevel'] >= 254)
	{
			
		include("application/language/".$language."/administrator.lang.php");
		
		$adminjump = "<form name=\"jump\"><select name=\"menu\" onChange=\"location=document.jump.menu.options[document.jump.menu.selectedIndex].value;\">
		<option selected value=\"index.php\">---------" . $lang['adminpanel'] . "---------</option>
		<option value=\"index.php?page=newsadd\"> - " . $lang['addnews'] . "</option>
		<option value=\"index.php?page=pageadd\"> - " . $lang['addpage'] . "</option>
		<option value=\"index.php?page=configuration\"> - " . $lang['configoptions'] . "</option>
		<option value=\"index.php?page=error\"> - " . $lang['viewerrorlog'] . "</option>
		<option value=\"index.php?page=userpanel\">---------" . $lang['userpanel'] . "---------</option>
		<option value=\"index.php?page=userpanel\"> - " . $lang['controlpanel'] . "</option>
		</select></form>";
			
	}elseif($_SESSION['userlevel'] <= 254 && $_SESSION['logged'] == true){
	
	   $adminjump = "<form name=\"jump\"><select name=\"menu\" onChange=\"location=document.jump.menu.options[document.jump.menu.selectedIndex].value;\">
		<option selected value=\"index.php?page=userpanel\">---------" . $lang['userpanel'] . "---------</option>
		<option value=\"index.php?page=userpanel\"> - " . $lang['controlpanel'] . "</option>
		</select></form>";
	
	}
		
}else{

	$loglink = "<a href=\"index.php?page=login\" id=\"loginlink\">".$lang['login']."</a>";
	$reglink = "<a href=\"index.php?page=register\" id=\"registerlink\">".$lang['register']."</a>";
	$username = $lang['guest'];

}

//assign header template variables
$t_ = array(
	'TEMPLATE_PATH'	=> $configuration->config_values['template']['template_dir']."/".$configuration->config_values['template']['default_template'],
	'CODENAME' 			=> $username,
	'LOGLINK' 			=> $loglink,
	'REGLINK' 			=> $reglink,
	'USER_COUNT' 		=> $countusers,
	'TITLE' 			   => $configuration->config_values['website']['title'],
	'SLOGAN' 			=> $configuration->config_values['website']['slogan'],
	'DESCRIPTION' 		=> $configuration->config_values['website']['description'],
	'KEYWORDS' 			=> $configuration->config_values['website']['keywords'],
	'AUTHOR' 			=> $configuration->config_values['website']['author'],
	'ADMIN_JUMP' 		=> $adminjump,
	'CODE_NAME' 		=> $lang['codename']
);

$TEMPLATE->load("header.tpl");
$TEMPLATE->assign($t_);
$TEMPLATE->publish();
?>