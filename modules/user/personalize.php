<?php
defined('LOAD_SAFE') or die('Server Error');

$user_id = NULL;
$languages = NULL;
$templates = NULL;

//passthru('ls /var/www/templates/');

if($_SESSION['uid']!=0 && !isset($_REQUEST['Submit']) && is_numeric($_SESSION['uid']) && ($_SESSION['logged']=='true')){

	$user_id = $_SESSION['uid'];

//get current news listing information to edit
	$query1 = $DB->query("SELECT * FROM users WHERE id=$user_id");

	foreach($query1 as $r){
		$id				=	$r["id"];
		$userage			=	$r["age"];
		$useravatar		=	$r["avatar"];
		$userlocation		=	$r["location"];
		$useroccupation	=	$r["occupation"];
		$usersignature		=	$r["signature"];
		$userbiography		=	$r["biography"];
		$usermsn			=	$r["msn"];

		$useryahoo		=	$r["yahoo"];
		$usergoogle		=	$r["google"];
		$userskype		=	$r["skype"];
		$userurl			=	$r["url"];
		$usertemplate		=	$r["template"];
	}

foreach(new DirectoryIterator(__SITE_PATH . "/" . $configuration->config_values['template']['template_dir']) as $fileInfo)
{

   if($fileInfo->isDot()) continue;
   
	   if ($fileInfo->isFile()) continue;
	   
         if($fileInfo->getFilename() != "icons" && $fileInfo->getFilename() != "static" && $fileInfo->isDir())
         {

            $selected = NULL;

		      if($usertemplate == $fileInfo->getFilename())
		      {
		      
			      $selected = "checked";
			      
		      }

		      $templates .= $fileInfo->getFilename(). "<input type=\"radio\" name=\"template\" value=\"".$fileInfo->getFilename()."\" $selected/>  ";
		      
         }
         
}

	$t_ = array(
		'USER_ID' 			   => $id,
		'USER_AGE' 			   => $userage,
		'USER_AVATAR' 			=> $useravatar,
		'USER_LOCATION' 		=> $userlocation,
		'USER_OCCUPATION' 	=> $useroccupation,
		'USER_SIGNATURE' 		=> $usersignature,
		'USER_BIOGRAPHY' 		=> $userbiography,
		'USER_TEMPLATE' 		=> $templates,
		'RESET'				   => $lang['reset'],
		'SUBMIT'				   => $lang['submit'],
		'REQUIRED'			   => $lang['require'],
		'USER_MSN'			   => $usermsn,
		'USER_YAHOO'			=> $useryahoo,
		'USER_GOOGLE'			=> $usergoogle,
		'USER_SKYPE'			=> $userskype,
		'USER_URL'			   => $userurl,
		'TEMPLATE'			   => $lang['template']
	);

	$TEMPLATE->load("personalize.tpl");
	$TEMPLATE->assign($t_);
	$TEMPLATE->publish();

}elseif($_SESSION['uid']==$_POST['userid'] && isset($_REQUEST['Submit']) && is_numeric($_SESSION['uid']) && $_SESSION['logged']=='true')
{

	$user_id 		= $_SESSION['uid'];
	$age		 	   = $_POST['age'];
	$avatar 		   = $_POST['avatar'];
	$location    	= $_POST['location'];
	$occupation 	= $_POST['occupation'];
	$msn 		      = $_POST['msn'];
	$yahoo 	   	= $_POST['yahoo'];
	$google 		   = $_POST['google'];
	$skype 		   = $_POST['skype'];
	$url 		      = $_POST['url'];
	$signature 	   = $_POST['signature'];
	$biography 	   = $_POST['biography'];
	$template 	   = $_POST['template'];

	$sql6 = "UPDATE users SET age='$age', avatar='$avatar', location='$location', occupation='$occupation', signature='$signature', biography='$biography', msn='$msn', yahoo='$yahoo', google='$google', skype='$skype', url='$url', template='$template' WHERE id='$user_id'";
	$query = $DB->query($sql6) or trigger_error($lang_error['UPDATE_ERROR'], E_USER_ERROR);

	$t_ = array(
		'MESSAGE_HEADING'		=> "Profile Status",
		'MESSAGE_DESCRIPTION'	=> "Personalized information status",
		'MESSAGE'				=> "You information was changed successfully."
	);

	$TEMPLATE->load("message.tpl");
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