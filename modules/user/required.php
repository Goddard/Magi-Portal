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

	foreach($query1 as $r)
	{
	
		$id				   =	$r["id"];
		$username			=	$r["username"];
		$displayname		=	$r["displayname"];
		$useremail		   =	$r["email"];
		$userlanguage		=	$r["language"];
		$usertimezone		=	$r["timezone"];
	}

foreach(new DirectoryIterator(__SITE_PATH . "/application/language/") as $fileInfo)
{

    if($fileInfo->isDot()) continue;
    
      if ($fileInfo->isFile()) continue;
      
	      if($fileInfo->isDir())
	      {

		      $selected = NULL;

		      if($userlanguage == $fileInfo->getFilename())
		      {
		      
			      $selected = "checked";
			      
		      }

		$languages .= $fileInfo->getFilename(). "<input type=\"radio\" name=\"language\" value=\"".$fileInfo->getFilename()."\" $selected/>  ";
		
	       }
	       
}

	$t_ = array(
		'USER_ID' 			      => $id,
		'USER_NAME' 			   => $username,
		'DISPLAY_NAME' 		   => $displayname,
		'USER_EMAIL' 			   => $useremail,
		'USER_LANGUAGE' 		   => $languages,
		'USER_TIMEZONE' 		   => $usertimezone,
		'USER_TEMPLATE' 		   => $templates,
		'RESET'				      => $lang['reset'],
		'SUBMIT'				      => $lang['submit'],
		'REQUIRED'			      => $lang['require'],
		'PASSWORD'			      => $lang['password'],
		'CONFIRM_PASSWORD'		=> $lang['confirmpassword'],
		'USERNAME'			      => $lang['username'],
		'CODENAME'			      => $lang['codename'],
		'EMAIL'				      => $lang['email'],
		'USERTIP'				   => $lang['usernametip'],
		'PASSTIP'				   => $lang['passwordtip'],
		'EMAILTIP'			      => $lang['emailtip'],
		'CODENAMETIP'			   => $lang['codenametip'],
		'CONFIRMPASSTIP'		   => $lang['confirmpasswordtip'],
		'LANGUAGE'			      => $lang['language']
	);

	$TEMPLATE->load("required.tpl");
	$TEMPLATE->assign($t_);
	$TEMPLATE->publish();

}elseif($_SESSION['uid']==$_POST['userid'] && isset($_REQUEST['Submit']) && is_numeric($_SESSION['uid']) && $_SESSION['logged'] == 'true')
{

	$user_id          = $_SESSION['uid'];
	$password 		   = $_POST['password'];
	$confirmpassword 	= $_POST['confirmpassword'];
	$email 			   = $_POST['email'];
	$language 		   = $_POST['language'];

	if($confirmpassword==$password)
	{

		if(empty($password) && empty($confirmpassword))
		{

			$passwordupdate = '';

		}else{

			$password = md5($password);
			$passwordupdate = 'password=\''.$password.'\',';

		}

		$sql6 = "UPDATE users SET $passwordupdate email='$email', language='$language' WHERE id='$user_id'";
		$query = $DB->query($sql6) or trigger_error($lang_error['UPDATE_ERROR'], E_USER_ERROR);

		unset($_POST['password']);
		unset($_POST['confirmpassword']);

		$t_ = array(
			'MESSAGE_HEADING'		=> "Profile Status",
			'MESSAGE_DESCRIPTION'	=> "Required information status",
			'MESSAGE'				=> "You information was changed successfully."
			);

	}else{

		$t_ = array(
			'MESSAGE_HEADING'		=> "Profile Status",
			'MESSAGE_DESCRIPTION'	=> "Required information status",
			'MESSAGE'				=> "The passwords you entered did not match."
			);
			
	}

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