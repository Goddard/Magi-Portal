<?php
////////////////////////////////////
// page load security
////////////////////////////////////
define('LOAD_SAFE', true);

$location = pathinfo(__FILE__, PATHINFO_BASENAME);

if($_SESSION['userlevel'] == 255 && !isset($_GET['logout']) && !isset($_GET['cleanerror']))
{

	$readlog = $error->readerrorlog();

	if(empty($readlog))
	{
	
		$clearloglink = "";
		$readlog = "No errors to report.";
		
	}else{
	
		$clearloglink = "<a href=\"error.php?cleanerror\">Clear Error Log</a>";
		
	}

	$t_ = array(
		'ERROR_MESSAGE' 		=> $readlog,
		'ERROR_CLEAR' 			=> $clearloglink,
	);

}elseif($_SESSION['userlevel'] == 255 && isset($_GET['cleanerror']))
{

	$clearlog = $error->clearerrorlog();

	$t_ = array(
		'ERROR_MESSAGE' 		=> "File Cleared".$clearlog,
		'ERROR_CLEAR' 			=> "",
	);
	
}else{

	$t_ = array(
		'ERROR_MESSAGE' 		=> "We encountered an error. We apologize for any inconvenience.  An administrator has already been contacted.  Your username, or IP has also been logged to help assist in future errors.",
		'ERROR_CLEAR' 			=> ""
	);
	
}

$TEMPLATE->load("error.tpl");
$TEMPLATE->assign($t_);
$TEMPLATE->publish();
?>