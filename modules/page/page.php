<?php
defined('LOAD_SAFE') or die('Server Error');

$page_name = $_GET['name'];

$pageget = "SELECT * FROM page WHERE page='$page_name'";
$query = $DB->query($pageget) or trigger_error($lang_error['SELECT_ERROR'], E_USER_ERROR);
$pagecount = $query->rowCount();

if($pagecount==1)
{

	foreach($query as $r)
	{
	
		$pagename			=	$r["page"];
		$pagecreator		=	$r["creator"];
		$pagecreatedate	=	$r["create_date"];
		$pagemodified		=	$r["modified"];

	   $userget = "SELECT * FROM users WHERE id='$pagecreator'";
	   $query2 = $DB->query($userget);
	   
	   foreach($query2 as $r)
	   {
	
	   	$displayname		=	$r["displayname"];
		

	   }
	
	}

	if($_SESSION['userlevel']>=200 && !isset($_REQUEST['logout']))
	{
	
		$editpage 	= "<a href=\"index.php?page=pageedit&amp;name=".$pagename."\">" . $lang['edit'] . "</a>";
		$deletepage 	= "<a href=\"index.php?page=pagedelete&amp;name=".$pagename."\">" . $lang['delete'] . "</a>";
		
	}else{
	
		$editpage 	= "";
		$deletepage 	= "";
		
	}

	$t_ = array(
		'PAGE_NAME'	 		   => $pagename,
		'PAGE_CREATOR' 		=> $displayname,
		'PAGE_CREATION_DATE'	=> $pagecreatedate,
		'PAGE_MODIFIED'		=> $pagemodified,
		'PAGE_EDIT'			   => $editpage,
		'PAGE_DELETE'			=> $deletepage,
		'PAGE_PRINT'			=> "<a href=\"index.php?page=pageprint&amp;name=".$pagename."\">" . $lang['print'] . "</a>"
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
