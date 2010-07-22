<?php
defined('LOAD_SAFE') or die('Server Error');

include("application/language/".$language."/page.lang.php");

if($_SESSION['userlevel']>=200 && !isset($_REQUEST['Submit']) && !isset($_REQUEST['logout'])){

	$t_ = array(
		'PAGE_ADD_TITLE' 		=> $lang['pageaddtitle'],
		'PAGE_ADD_SUB_TITLE' 	=> $lang['pageaddsubtitle'],
		'FILE_NAME' 			=> $lang['pageaddfilename'],
		'CATEGORY' 			=> $lang['category'],
		'PAGE_CONTENT' 		=> $lang['contenttitle'],
		'RESET'				=> $lang['reset'],
		'REQUIRED'			=> $lang['require'],
		'SUBMIT'				=> $lang['submit']
	);

	$TEMPLATE->load("pageadd.tpl");
		$TEMPLATE->assign($t_);
			$TEMPLATE->publish();

}elseif($_SESSION['userlevel']>=200 && isset($_REQUEST['Submit']) && !isset($_REQUEST['logout'])){
		$title = $_POST['title'];
		$message = $_POST['message'];

		$file = __SITE_PATH . "/" . $configuration->config_values['template']['template_dir'] . "/static/" . $title . ".tpl";

		if(file_exists($file)){

			$t_ = array(
				'MESSAGE'		=> $lang['pageaddexists']
			);

			$TEMPLATE->load("message.tpl");
				$TEMPLATE->assign($t_);
					$TEMPLATE->publish();

		}else{

			file_put_contents($file, $message) or trigger_error($lang_error['CREATE_ERROR'], E_USER_ERROR);

			$userid  = $_SESSION['uid'];

			$sql = "INSERT INTO page (page, creator, create_date, modified)VALUES('$title', '$userid', '$date_time', '$date_time')";
			$DB->query($sql) or trigger_error($lang_error['INSERT_ERROR'], E_USER_ERROR);

			header('Location: index.php?page=page&name='.$title);

		}

}else{

	$t_ = array(
		'MESSAGE'	 => $lang['permissiondenied'],
	);

	$TEMPLATE->load("permission.tpl");
		$TEMPLATE->assign($t_);
			$TEMPLATE->publish();

}

?>
