<?php
////////////////////////////////////
// page load security
////////////////////////////////////
defined('LOAD_SAFE') or die('Server Error');

include("application/language/".$language."/ban.lang.php");

if($_SESSION['userlevel'] >= 200 && !isset($_POST['Submit']) && !isset($_REQUEST['logout']))
{
	$t_ = array(
		'BANNED_ADD_TITLE'        	=> "Banned Add",
		'BANNED_ADD_SUB_TITLE'    	=> "Banned Add Sub Title",
		'BANNED_IP_LABEL'           => "User IP",
		'BANNED_EMAIL_LABEL'        => "User Email",
		'BANNED_USERID_LABEL'       => "Userid",
		'RESET'                     => $lang['reset'],
		'SUBMIT'                    => $lang['submit'],
	);

	$TEMPLATE->load("banadd.tpl");
	$TEMPLATE->assign($t_);
	$TEMPLATE->publish();

	$sql_1 = "SELECT * FROM banned";
	$query_1 = $DB->query($sql_1) or trigger_error($lang_error['SELECT_ERROR'], E_USER_ERROR);
	$countbanned = $query_1->rowCount();
	
	if($countbanned != 0)
	{
	
		foreach($query_1 as $r)
		{
		
			$bannned_ip 	= $r['ip'];
			$bannned_email  = $r['email'];
			$bannned_userid = $r['userid'];

			$t_ = array(
				'BANNED_IPS_LABEL'      => "Banned IPs",
				'BANNED_EMAILS_LABEL'   => "Banned Emails",
				'BANNED_USERS_LABEL'    => "Banned Users",
				'BANNED_IPS'      		=> $bannned_ip,
				'BANNED_EMAILS'   		=> $bannned_email,
				'BANNED_USERS'    		=> $bannned_userid,
			);

			$TEMPLATE->load("banlist.tpl");
			$TEMPLATE->assign($t_);
			$TEMPLATE->publish();

		}
		
	}

}elseif($_SESSION['userlevel'] >= 200 && isset($_POST['Submit']) && !isset($_REQUEST['logout'])) {

    $name      	   = $_POST['name'];
    $description   = $_POST['description'];
    $picture   	   = $_POST['picture'];
    $categorytype  = $_POST['categorytype'];
    $subcategory   = $_POST['subcategory'];
    
    foreach($categorytype as $type_value)
    {
    
    	$type_value = $type_value.",";
    	$all_type_values .= $type_value;
    
    }
	
	$all_type_values = substr($all_type_values, 0, -1);
	
    foreach($subcategory as $sub_value)
    {
    
    	$sub_value = $sub_value.",";
    	$all_sub_values .= $sub_value;
    
    }
	
	$all_sub_values = substr($all_sub_values, 0, -1);
	
	$sql1 = "INSERT INTO category (name, description, picture, categorytype, subcategory)VALUES(?, ?, ?, ?, ?)";
	$query1 = $DB->prepare($sql1) or trigger_error($lang_error['INSERT_ERROR'], E_USER_ERROR);
	$query1->execute(array($name, $description, $picture, $all_type_values, $all_sub_values));

	$TEMPLATE->load("message.tpl");
	$TEMPLATE->assign($t_);
	$TEMPLATE->publish();

}else{

	$t_ = array(
    	'MESSAGE'   => $lang['permissiondenied'],
	);

	$TEMPLATE->load("permission.tpl");
	$TEMPLATE->assign($t_);
	$TEMPLATE->publish();
}
?>
