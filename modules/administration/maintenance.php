<?php
//Delete old accounts that aren't activated within a certain time period
//

defined('LOAD_SAFE') or die('Server Error');

$delete_date = date("l, F jS Y g:i:s A", strtotime("-" . $configuration->config_values['maintenance']['user_delete_time']));

if($_SESSION['logged'] == "true" && $_SESSION['userlevel'] == 255 && !isset($_GET['logout']) && !isset($_POST['Submit']))
{

//find out how many users haven't activated their account.
$sql_1 = "SELECT * FROM users WHERE active='0'";
$query_1 = $DB->query($sql_1) or trigger_error($lang_error['SELECT_ERROR'], E_USER_ERROR);
$userunactive = $query_1->rowCount();

//find out how many users haven't activated their account.
$sql_2 = "SELECT * FROM users WHERE active='0' AND creationdate > '$delete_date'";
$query_2 = $DB->query($sql_2) or trigger_error($lang_error['SELECT_ERROR'], E_USER_ERROR);
$userunactiveold = $query_2->rowCount();


   $t_ = array(
		'MAINTENANCE_TITLE' 		            => "Maintenance Screen",
		'MAINTENANCE_SUB_TITLE' 	         => "Maintenance SUB Screen",
		'MAINTENANCE_USER_DELETE' 	         => "Delete Users",
		'MAINTENANCE_BAN_HAMMER' 	         => "Ban Hammer",
		'MAINTENANCE_USER_DELETE_TIP' 	   => "All users that aren't actived and are older then the old account time set in the configuration file will be deleted.",
		'MAINTENANCE_BAN_HAMMER_TIP' 	      => "This option is used to ban suspected IP addresses and emails of suspected spam bots.",
		'MAINTENANCE_INACTIVE_COUNT' 	      => $userunactive,
		'MAINTENANCE_INACTIVE_OLD_COUNT' 	=> $userunactiveold,
		'MAINTENANCE_DELETE_TIME' 	         => $configuration->config_values['maintenance']['user_delete_time'],
		'REQUIRED' 	                        => $lang['require'],
		'RESET' 	                           => $lang['reset'],
		'SUBMIT' 	                        => $lang['submit'],
	);

	$TEMPLATE->load("maintenance.tpl");
	$TEMPLATE->assign($t_);
	$TEMPLATE->publish();

}elseif($_SESSION['logged'] == "true" && $_SESSION['userlevel'] == 255 && !isset($_GET['logout']) && isset($_POST['Submit']))
{

   if($_POST['userdelete'] == true)
   {
   
      $sql_3 = "DELETE FROM users WHERE active='0' AND creationdate > '$delete_date'";
		$DB->query($sql_3) or trigger_error($lang_error['DELETE_ERROR'], E_USER_ERROR);
   
   
   }

   $t_ = array(
		'MAINTENANCE_TITLE' 		=> "Maintenance Screen",
	);

	$TEMPLATE->load("message.tpl");
	$TEMPLATE->assign($t_);
	$TEMPLATE->publish();

}

?>