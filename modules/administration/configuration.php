<?php
defined('LOAD_SAFE') or die('Server Error');

include("application/language/".$language."/configuration.lang.php");

if($_SESSION['logged']=="true" && $_SESSION['userlevel']==255 && !isset($_GET['logout']) && !isset($_REQUEST['Submit'])  && !isset($_REQUEST['configoptions'])){

	$magi_config = file_get_contents("../configuration/magi.ini.php");

	$t_ = array(
		'TITLE'				=> $lang['cgtile'],
		'INPUT_TITLE'			=> $lang['cgoptions'],
		'CGTIP'				=> $lang['cgtip'],
		'MESSAGE'				=> $lang['sysvariables'],
		'SUBMIT'				=> $lang['submit'],
		'REQUIRED'			=> $lang['require'],
		'CONFIG_OPTIONS' 		=> $magi_config,
	);

	$TEMPLATE->load("config_options.tpl");
		$TEMPLATE->assign($t_);
			$TEMPLATE->publish();

}elseif($_SESSION['logged']=="true" && $_SESSION['userlevel']==255 && isset($_REQUEST['Submit'], $_REQUEST['configoptions']) && !isset($_GET['logout'])){

	$file = "./application/configuration/magi.ini.php";
	$f_write = stripcslashes($_POST['configoptions']);
	$ini_write = fopen($file,'w');
	fwrite($ini_write,$f_write);
	fclose($ini_write);

	$t_ = array(
		'MESSAGE'		=> $lang['cgupdatesuccess'],
	);

	$TEMPLATE->load("config_options_message.tpl");
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
