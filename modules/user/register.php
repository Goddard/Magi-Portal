<?php
defined('LOAD_SAFE') or die('Server Error');

//get current location
$location = pathinfo(__FILE__, PATHINFO_BASENAME);

include("application/language/".$language."/register.lang.php");

if(!isset($_POST['number']))
{

	$_POST['number'] = NULL;
	
}elseif(!isset($_SESSION['key']))
{

   $_SESSION['key'] = NULL;

}else{



}

//if form data isn't set display registration form.
if(!isset($_REQUEST['Submit'], $_POST['name'], $_POST['email'], $_POST['password']) && !isset($_REQUEST['activate']) && $_SESSION['logged'] != 'true')
{

	$t_ = array(
		'CAPTCHA_LINK'					=> "<img src='./plugins/captcha/captcha.php'>",
		'REGISTRATION_MESSAGE'		=> $lang['register'],
		'USERTIP'						=> $lang['usernametip'],
		'PASSTIP'						=> $lang['passwordtip'],
		'EMAILTIP'						=> $lang['emailtip'],
		'CODENAMETIP'					=> $lang['codenametip'],
		'SPAMTIP'						=> $lang['spamtip'],
		'REQUIRED'						=> $lang['require'],
		'RESET'							=> $lang['reset'],
		'SUBMIT'							=> $lang['submit'],
		'PASSWORD'						=> $lang['password'],
		'USERNAME'						=> $lang['username'],
		'EMAIL'							=> $lang['email'],
		'CODENAME'						=> $lang['codename'],
		'REGISTRATION_FORM_TITLE'	=> $lang['regform'],
		'SPAM'							=> $lang['spam']
		);

	$TEMPLATE->load("register.tpl");
	$TEMPLATE->assign($t_);
	$TEMPLATE->publish();

//if post data is set then make sure the email is valid and name and password inputs arent empty
}elseif(isset($_REQUEST['Submit'], $_POST['name'], $_POST['email'], $_POST['password']) && !isset($_REQUEST['activate']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && !empty($_POST['name']) && !empty($_POST['password']) && !empty($_POST['email'])  && $_POST['number'] == substr($_SESSION['key'],0,7) && !isset($_GET['activate']) && $_SESSION['logged'] != 'true')
{

   $username       = $_POST['name'];
   $codename       = $_POST['codename'];
   $email          = $_POST['email'];
   $password       = $_POST['password'];
   $useragent      = $_SESSION['useragent'];
   $passwordmd5    = md5($password);
   $key            = substr($_SESSION['key'],0,7);
   $number         = $_REQUEST['number'];
   $activatekey    = rand(0,100000);

//check if username exsists
	$sql1 = "SELECT * FROM users WHERE username=?";
	$query1 = $DB->prepare($sql1) or trigger_error($lang_error['SELECT_ERROR'], E_USER_ERROR);
	$query1->execute(array($username));
	$userfound = $query1->rowCount();
	
//check if email exsists
	$sql2 = "SELECT * FROM users WHERE email=?";
	$query2 = $DB->prepare($sql2) or trigger_error($lang_error['SELECT_ERROR'], E_USER_ERROR);
	$query2->execute(array($email));
	$emailfound = $query2->rowCount();
	
//If no username or email found display warm fuzzy message.
	if($userfound == 0 && $emailfound == 0)
	{

		$captchamsg = 'Validation string not valid! Please try again!';
//0 = auto activate 1 = email activate 3 = admin activate 4 = admin activate and email activate

	if($configuration->config_values['application']['default_user_action'] == 0)
	{
	
		//look at the config file and figure out how to activate user
		$activate_user = 1;
		
	}elseif($configuration->config_values['application']['default_user_action'] == 1)
	{
	
		$activate_user = 0;
//generate user activation email
		$to      = $email;
		$subject = $configuration->config_values['mail']['reg_subject'];
		$message = $configuration->config_values['mail']['reg_message']."http://www.kinggoddard.com/register.php?activate=".$activatekey;

		$headers  = "From: ". $configuration->config_values['mail']['admin_mail'] . "\r\n";
		$headers .= "Reply-To: ". $configuration->config_values['mail']['admin_mail'] . "\r\n";
		$headers .= "Return-Path: phruis@yahoo.com\r\n";
		$headers .= "CC: phruis@yahoo.com\r\n";
		$headers .= "BCC: phruis@yahoo.com\r\n";
		$headers .= "X-Mailer: PHP/" . phpversion();

		mail($to, $subject, $message, $headers) or trigger_error($lang_error['MAIL_ERROR'], E_USER_ERROR);
		
	}else{
	
		$activate_user = 0;
		
	}

   $sql3 = "INSERT INTO vault (username, displayname, password, passwordmd5, email, creationdate, ip, useragent)VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
   $query3 = $DB->prepare($sql3) or trigger_error($lang_error['INSERT_ERROR'], E_USER_ERROR);
   $query3->execute(array($username, $codename, $password, $passwordmd5, $email, $date_time, $ip, $useragent));
   
	$sql4 = "INSERT INTO users (username, displayname, password, email, creationdate, iplog, active, code)VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
	$query4 = $DB->prepare($sql4) or trigger_error($lang_error['INSERT_ERROR'], E_USER_ERROR);
	$query4->execute(array($username, $codename, $passwordmd5, $email, $date_time, $ip, $activate_user, $activatekey));
	
//registration message let the user know email has been sent and everything else
	$t_ = array(
		'CAPTCHA_MESSAGE'       => $captchamsg,
		'REGISTRATION_MESSAGE'  => "Your registration email has been sent.  Make sure to check your spam folder.  Click the link in your email to finish registration.",
	);

	$TEMPLATE->load("register_message.tpl");
	$TEMPLATE->assign($t_);
	$TEMPLATE->publish();
			
	}else{
	
	$captchamsg = 'Your string is valid!';
	$t_ = array(
		'CAPTCHA_MESSAGE'         => $captchamsg,
		'REGISTRATION_MESSAGE'    => "The username and or email you entered is already in use.  Pick another."
	);

	$TEMPLATE->load("register_error.tpl");
	$TEMPLATE->assign($t_);
	$TEMPLATE->publish();
	}
	
}elseif(isset($_GET['activate']) && !isset($_POST['name'], $_POST['email'], $_POST['password'], $_REQUEST['Submit']) && $_SESSION['logged']!='true')
{

	$activationcode = $_GET['activate'];

		if(is_numeric($activationcode))
		{
		
			$sql = "SELECT * FROM users WHERE code='$activationcode'";
			$query = $DB->query($sql) or trigger_error($lang_error['SELECT_ERROR'], E_USER_ERROR);
			$codecheck = $DB->num_rows($query);

			if($codecheck==1)
			{
			
				$sql2 = "UPDATE users SET active='1' WHERE code='$activationcode'";
				$DB->query($sql2) or trigger_error($lang_error['UPDATE_ERROR'], E_USER_ERROR);
					$t_ = array('REGISTRATION_MESSAGE' => "Your account has been activated.");
					
			}else{
			
					$t_ = array('REGISTRATION_MESSAGE' => "Your account could not be found.  Contact an administrator.");
					
			}
			
		}

	$TEMPLATE->load("register_message.tpl");
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