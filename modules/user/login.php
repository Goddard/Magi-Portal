<?php
defined('LOAD_SAFE') or die('Server Error');

$location = pathinfo(__FILE__, PATHINFO_BASENAME);

include("application/language/".$language."/login.lang.php");

if(!isset($_POST['number'], $_SESSION['key'])){
	$_POST['number'] = NULL;
	$_SESSION['key'] = NULL;
}

//make sure the login form hasn't been submitted and the user isn't trying to logout.
if(!isset($_REQUEST['Submit'], $_POST['name'], $_POST['password'], $_POST['number']) && !isset($_GET['logout']) && $_SESSION['logged']!='true'){

//define template variables
	$t_ = array(
		'CAPTCHA_LINK'				   => "<img src='plugins/captcha/captcha.php'>",
		'USERTIP'					   => $lang['usernametip'],
		'PASSTIP'					   => $lang['passwordtip'],
		'SPAMTIP'					   => $lang['spamtip'],
		'REQUIRED'					   => $lang['require'],
		'RESET'						   => $lang['reset'],
		'SUBMIT'					      => $lang['submit'],
		'PASSWORD'					   => $lang['password'],
		'USERNAME'					   => $lang['username'],
		'LOGIN_REGISTRATION_TEXT'	=> $lang['logregtext'],
		'REGISTER' 					   => $lang['register'],
		'LOGIN_FORM_TITLE'			=> $lang['logform'],
		'LOGIN_MESSAGE'				=> $lang['login'],
		'SPAM'						   => $lang['spam'],
		'REGISTRATION_PAGE'			=> "<a href=index.php?page=register>Register</a>",
		);

	$TEMPLATE->load("login.tpl");
	$TEMPLATE->assign($t_);
	$TEMPLATE->publish();

//if post data is set then make sure the email is valid and name and password inputs arent empty}elseif(isset($_REQUEST['Submit'], $_POST['name'], $_POST['password'], $_POST['number']) && !empty($_POST['name']) && !empty($_POST['password']) && !isset($_GET['logout']) && $_SESSION['logged']!='true'){

	$username = $_POST['name'];
	$password = md5($_POST['password']);

		//check if username exsists and is active
	$sql1 = "SELECT * FROM users WHERE username=? AND password=? AND active=?";
	$query1 = $DB->prepare($sql1) or trigger_error($lang_error['SELECT_ERROR'], E_USER_ERROR);
	$query1->execute(array($username, $password, '1'));
   $userfound = $query1->rowCount();

		//If no username or inactive display warm fuzzy message.
	if(($userfound != 1) || $_REQUEST['number'] != substr($_SESSION['key'],0,7)){
		
		$t_ = array(
			'USERTIP' 				      => $lang['usernametip'],
			'PASSTIP' 				      => $lang['passwordtip'],
			'REQUIRED' 				      => $lang['require'],
			'RESET' 					      => $lang['reset'],
			'SUBMIT' 				   	=> $lang['submit'],
			'PASSWORD' 				      => $lang['password'],
			'USERNAME' 				      => $lang['username'],
			'LOGIN_REGISTRATION_TEXT' 	=> $lang['logregtext'],
			'REGISTER' 				      => $lang['register'],
			'LOGIN_FORM_TITLE' 			=> $lang['logform'],
			'LOGIN_MESSAGE' 		   	=> $lang['logunsuccessful'],
			'SPAM'				      	=> $lang['spam'],
			'SPAMTIP'				   	=> $lang['spamtip'],
			'CAPTCHA_LINK'			   	=> "<img src='plugins/captcha/captcha.php'>",
			'REGISTRATION_PAGE' 		   => "index.php?page=register"
		);

		$TEMPLATE->load("login_error.tpl");
	   $TEMPLATE->assign($t_);
		$TEMPLATE->publish();

	}else{

		foreach($query1 as $r)
		{
		
			$id				   =	$r["id"];
			$displayname		=	$r["displayname"];
			$useremail		   =	$r["email"];
			$avatar			   =	$r["avatar"];
			$userlanguage		=	$r["language"];
			$usertimezone		=	$r["timezone"];
			$usertemplate		=	$r["template"];
			$userlevel		   =	$r["userlevel"];
			$warnlevel		   =	$r["warnlevel"];
			$activitylevel		=	$r["activitylevel"];
			
		}

		$sql2 = "UPDATE users SET logintime=?, iplog = CONCAT(iplog, ?) WHERE id=? AND iplog NOT LIKE ?";
		$query2 = $DB->prepare($sql2) or die("wrong");//trigger_error($lang_error['UPDATE_ERROR'],E_USER_ERROR);
      $query2->execute(array($date_time, $ip ."':'", $id, "'%'". $ip ."'%'")) or die("wrong");

		$t_ = array(
			'LOGIN_FORM_TITLE' 		=> $lang['logform'],
			'USER_CONTROL_PANEL' 	=> "<a href=\"index.php?page=user\">".$lang['usercp']."</a>",
			'LOGIN_MESSAGE' 		   => $lang['logsuccess']."<meta http-equiv=\"Refresh\" content=\"2; URL=index.php?page=userpanel\">"
		);


		//unset default session variables.  User is signing in.
		unset($_SESSION['logged']);
		unset($_SESSION['uid']);
		unset($_SESSION['username']);
		unset($_SESSION['cookie']);
		unset($_SESSION['remember']);
		unset($_SESSION['language']);
		unset($_SESSION['timezone']);
		unset($_SESSION['template']);
		unset($_SESSION['userlevel']);
		unset($_SESSION['warnlevel']);
		unset($_SESSION['codename']);
		unset($_SESSION['useragent']);
		unset($_SESSION['email']);
		//remove login captcha key
		unset($_SESSION['key']);

		//set the user session info from the database.
		session_regenerate_id();

		$_SESSION['logged'] 	         = 'true';
		$_SESSION['uid'] 		         = $id;
		$_SESSION['username'] 	      = $displayname;
		$_SESSION['codename'] 	      = $username;
		$_SESSION['cookie']    	      = 0;
		$_SESSION['remember'] 	      = 'false';
		$_SESSION['ip'] 		         = $ip;
		$_SESSION['useragent']	      = $_SERVER['HTTP_USER_AGENT'];
		$_SESSION['email'] 		      = $useremail;
		$_SESSION['language'] 	      = $userlanguage;
		$_SESSION['timezone'] 	      = $usertimezone;
		$_SESSION['template'] 	      = $usertemplate;
		$_SESSION['userlevel'] 	      = $userlevel;
		$_SESSION['warnlevel'] 	      = $warnlevel;
		$_SESSION['avatar'] 	         = $avatar;
		$_SESSION['activitylevel'] 	= $activitylevel;

		$TEMPLATE->load("login_message.tpl");
		$TEMPLATE->assign($t_);
		$TEMPLATE->publish();
	}

}elseif(isset($_GET['logout']) && $_SESSION['logged'] == 'true'){

////////////////////////////////////
// Unset Session Variable
////////////////////////////////////
	unset($_SESSION['logged']);
	unset($_SESSION['uid']);
	unset($_SESSION['username']);
	unset($_SESSION['cookie']);
	unset($_SESSION['remember']);
	unset($_SESSION['language']);
	unset($_SESSION['timezone']);
	unset($_SESSION['template']);
	unset($_SESSION['userlevel']);
	unset($_SESSION['warnlevel']);
	unset($_SESSION['activitylevel']);
	unset($_SESSION['email']);
	unset($_SESSION['key']);
	unset($_SESSION['useragent']);
	unset($_SESSION['codename']);

////////////////////////////////////
// Begin Session Variable Defaults
////////////////////////////////////

	if(!isset($_SESSION['logged'])){
		$_SESSION['logged'] 		      = 'false';
		$_SESSION['uid'] 			      = 0;
		$_SESSION['username'] 		   = 'Guest';
		$_SESSION['cookie'] 		      = 0;
		$_SESSION['remember'] 		   = 'false';
		$_SESSION['language'] 		   = $configuration->config_values['language']['default_language'];
		$_SESSION['timezone'] 		   = $configuration->config_values['application']['timezone'];
		$_SESSION['template'] 		   = $configuration->config_values['template']['default_template'];
		$_SESSION['userlevel'] 		   = -1;
		$_SESSION['warnlevel'] 		   = 0;
		$_SESSION['ip'] 			      = $ip;
		$_SESSION['activitylevel'] 	= 0;
		$_SESSION['email'] 			   = NULL;
	}

	session_destroy();

	$t_ = array(
		'LOGIN_FORM_TITLE' 		=> $lang['logform'],
		'USER_CONTROL_PANEL'	   => "",
		'LOGOUT_MESSAGE'		   => $lang['logoutmsg'],
		'LOGIN_MESSAGE' 		   => $lang['logoutsuccess']
	);

	$TEMPLATE->load("login_message.tpl");
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

	include("footer.php");
?>