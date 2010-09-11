<?php
////////////////////////////////////
// page load security
////////////////////////////////////
defined('LOAD_SAFE') or die('Server Error');

	$t_ = array(
		'BANNED_MESSAGE' 		   => "Sorry, but you've been ban hammered.",
	);

	$TEMPLATE->load("banned.tpl");
	$TEMPLATE->assign($t_);
	$TEMPLATE->publish();
?>