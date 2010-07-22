<?php
defined('LOAD_SAFE') or die('Server Error');

$location = pathinfo(__FILE__, PATHINFO_BASENAME);

include("application/language/".$language."/contact.lang.php");

if(!isset($_POST['number'], $_SESSION['key']))
{

	$_POST['number'] = NULL;
	$_SESSION['key'] = NULL;
	
}

if(isset($_POST['Submit'], $_POST['name'], $_POST['email'], $_POST['message']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && $_REQUEST['number']==substr($_SESSION['key'],0,7)) {

	$to            = $configuration->config_values['mail']['admin_mail']; 
	$subject       = "Website Contact Form";
	$name_field    = $_POST['name'];
	$email_field   = $_POST['email'];
	$message       = $_POST['message'];

	$body = "From: ". $name_field ."
		 E-Mail: ". $email_field ."
		 Message: ". $message;

	$contact_message = $lang['successpart1']. " " . $configuration->config_values['website']['author'] . " " .$lang['successpart2'];
	mail($to, $subject, $body);

	$t_ = array(
		'CONTACT_MESSAGE' => $contact_message,
		);

	$TEMPLATE->load("contact_message.tpl");
	$TEMPLATE->assign($t_);
	$TEMPLATE->publish();

}elseif(!isset($_POST['Submit'])){

	$t_ = array(
		'NAME'				      => $lang['name'],
		'MESSAGE'				   => $lang['message'],
		'EMAIL'				      => $lang['email'],
		'CONTACT_NAME_TIP'		=> $lang['contactnametip'],
		'CONTACT_EMAIL_TIP'		=> $lang['contactemailtip'],
		'CONTACT_MESSAGE_TIP'	=> $lang['contactmessagetip'],
		'CONTACT_SUB_TITLE'		=> $lang['contactsubtitle'],
		'CONTACT_TITLE'		   => $lang['contactform'],
		'RESET'				      => $lang['reset'],
		'SUBMIT'				      => $lang['submit'],
		'SPAM'				      => $lang['spam'],
		'SPAMTIP'				   => $lang['spamtip'],
		'REQUIRED'			      => $lang['require'],
		'CAPTCHA_LINK'			   => "<img src='plugins/captcha/captcha.php'>",
		);

	$TEMPLATE->load("contact.tpl");
	$TEMPLATE->assign($t_);
	$TEMPLATE->publish();

}else{

	$contact_message = "Your message could not be sent.";

	$t_ = array(
		'CONTACT_MESSAGE' => $contact_message,
		);

	$TEMPLATE->load("contact_message.tpl");
		$TEMPLATE->assign($t_);
			$TEMPLATE->publish();

}
?>
