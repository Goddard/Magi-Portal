<?php
//Delete old accounts that aren't activated within a certain time period
//

defined('LOAD_SAFE') or die('Server Error');

if($_SESSION['logged'] == "true" && $_SESSION['userlevel'] == 255 && !isset($_GET['logout']) && !isset($_POST['Submit']))
{

   $t_ = array(
		'MAINTENANCE_TITLE' 		         => "Maintenance Screen",
		'MAINTENANCE_SUB_TITLE' 	      => "Maintenance SUB Screen",
		'MAINTENANCE_USER_DELETE' 	      => "Delete Users",
		'MAINTENANCE_BAN_HAMMER' 	      => "Ban Hammer",
		'MAINTENANCE_USER_DELETE_TIP' 	=> "All users that aren't actived and are older then the old account time set in the configuration file will be deleted.",
		'MAINTENANCE_BAN_HAMMER_TIP' 	   => "This option is used to ban suspected IP addresses and emails of suspected spam bots.",
	);

	$TEMPLATE->load("maintenance.tpl");
	$TEMPLATE->assign($t_);
	$TEMPLATE->publish();

}elseif($_SESSION['logged'] == "true" && $_SESSION['userlevel'] == 255 && !isset($_GET['logout']) && isset($_POST['Submit']))
{



   $t_ = array(
		'MAINTENANCE_TITLE' 		=> "Maintenance Screen",
	);

	$TEMPLATE->load("message.tpl");
	$TEMPLATE->assign($t_);
	$TEMPLATE->publish();

}

?>