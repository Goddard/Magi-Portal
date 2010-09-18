<?php
////////////////////////////////////
// page load security
////////////////////////////////////
defined('LOAD_SAFE') or die('Server Error');

if($username != $lang['guest'] && !isset($_GET['logout']))
{

	include("application/language/".$language."/user.lang.php");
	
	$loglink = "<a href=\"index.php?page=login&&logout\" id=\"logoutlink\">" . $lang['logout'] . "</a>";
	$reglink = $lang['register'];
		
	if(isset($_SESSION['userlevel']) && $_SESSION['userlevel'] >= 254)
	{
			
		include("application/language/".$language."/administrator.lang.php");
		
		$adminjump = "<form name=\"jump\"><select name=\"menu\" onChange=\"location=document.jump.menu.options[document.jump.menu.selectedIndex].value;\">
		<option selected value=\"index.php\">---------" . $lang['adminpanel'] . "---------</option>
		<option value=\"index.php?page=newsadd\"> - " . $lang['addnews'] . "</option>
		<option value=\"index.php?page=pageadd\"> - " . $lang['addpage'] . "</option>
		<option value=\"index.php?page=categoryadd\"> - " . $lang['addcategory'] . "</option>
		<option value=\"index.php?page=banadd\"> - " . $lang['banned'] . "</option>
		<option value=\"index.php?page=maintenance\"> - " . $lang['maintenance'] . "</option>
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
	'TEMPLATE_PATH'		=> $configuration->config_values['template']['template_dir']."/".$configuration->config_values['template']['default_template'],
	'CODENAME' 			=> $username,
	'LOGLINK' 			=> $loglink,
	'REGLINK' 			=> $reglink,
	'USER_COUNT' 		=> $countusers,
	'TITLE' 			=> $configuration->config_values['website']['title'],
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
