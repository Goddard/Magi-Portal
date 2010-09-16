<?php
defined('LOAD_SAFE') or die('Server Error');

	$included_files = get_included_files();

if($gzip)
{
	
	$output2 = gzcompress(ob_get_contents());
	$page_size = "Gzip: " . mb_strlen($output2) / 1024;
	
}else{
	
	$page_size = "None: " . ob_get_length()  / 1024;
		
}

$t_ = array(
	'TEMPLATE_PATH'	=> $configuration->config_values['template']['template_dir']."/".$configuration->config_values['template']['default_template'],
	'PAGE_SIZE' 	=> substr ($page_size, 0, 10) . "kb",
	'COPYRIGHT' 	=> $configuration->config_values['website']['copy'],
	'LOAD_TIME'	   => END_TIMER($start_time) . "sec",
	'FILES_LOADED'	=> count($included_files) ." Files Loaded"
);

$TEMPLATE->load("footer.tpl");
$TEMPLATE->assign($t_);
$TEMPLATE->publish();

?>