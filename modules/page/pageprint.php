<?php
defined('LOAD_SAFE') or die('Server Error');

$page_name = $_GET['name'];

$sql1 = "SELECT * FROM page WHERE page='$page_name'";
$query1 = $DB->query($sql1) or trigger_error($lang_error['SELECT_ERROR'], E_USER_ERROR);
$pagecount = $query1->rowCount();

if($pagecount == 1)
{

	foreach($query1 as $r)
	{

		$pagename			=	$r["page"];
		$pagecreator		=	$r["creator"];
		$pagecreatedate	=	$r["create_date"];
		$pagemodified		=	$r["modified"];

	   $sql2 = "SELECT * FROM users WHERE id='$pagecreator'";
	   $query2 = $DB->query($sql2);

	   foreach($query2 as $r)
	   {

	   	$displayname		=	$r["displayname"];


	   }

	}

	$t_ = array(
		'PAGE_NAME'	 		   => $pagename,
		'PAGE_CREATOR' 		=> $displayname,
		'PAGE_CREATION_DATE'	=> $pagecreatedate,
		'PAGE_MODIFIED'		=> $pagemodified,
		'PAGE_EDIT'			   => "",
		'PAGE_DELETE'			=> "",
		'PAGE_PRINT'			=> ""
	);
	
	$TEMPLATE->loadstatic("staticheader.tpl");
	$TEMPLATE->assign($t_);
	$TEMPLATE->publish();

	$TEMPLATE->loadstatic($pagename.".tpl");
	$TEMPLATE->assign($t_);
	$TEMPLATE->publish();

	$TEMPLATE->loadstatic("staticfooter.tpl");
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