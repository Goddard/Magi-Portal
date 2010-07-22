<?php
defined('LOAD_SAFE') or die('Server Error');

$t_ = array(
	'NOTHING'		=> ""
);

$TEMPLATE->load("userfooter.tpl");
$TEMPLATE->assign($t_);
$TEMPLATE->publish();

?>