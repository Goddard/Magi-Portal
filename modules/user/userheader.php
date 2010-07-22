<?php
defined('LOAD_SAFE') or die('Server Error');

$t_ = array(
	'NOTHING' 		=> "",
);

$TEMPLATE->load("userheader.tpl");
$TEMPLATE->assign($t_);
$TEMPLATE->publish();

?>
