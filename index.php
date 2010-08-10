<?php
define('LOAD_SAFE', true);

require "root.php";

$location = pathinfo(__FILE__, PATHINFO_BASENAME);

$case = array('newsview', 'news', 'scripts', 'scriptview', 'user', 'newsadd', 'newsedit', 'newsdelete', 'configuration',
'newsprint', 'page', 'pageadd', 'pageedit', 'pagedelete', 'userpanel', 'roster', 'register', 'login', 'contact', 'pageprint', 
'members', 'error', 'profile'
);

if(!isset($_GET['page']) || empty($_GET['page']) || !in_array($_GET['page'], $case))
{

	$_GET['page'] = $configuration->config_values['application']['default_action'];
	
}

if($_GET['page'] != "newsprint" && $_GET['page'] != "pageprint")
{

	include("header.php");
	
}


if($_GET['page'] == $configuration->config_values['application']['default_action'])
{

	$TEMPLATE->load("index_header.tpl");
	$TEMPLATE->publish();
	
}

//guest switch start +
switch($_GET['page'])
{

	case 'newsview':
		include("modules/news/newsview.php");
		break;

	case 'news':
		include("modules/news/news.php");
		break;
		
	case 'newsprint':
		include("modules/news/newsprint.php");
		break;
		
	case 'scripts':
		include("modules/scripts/scripts.php");
		break;

	case 'scriptview':
		include("modules/scripts/scriptview.php");
		break;

	case 'page':
		include("modules/page/page.php");
		break;
		
	case 'pageprint':
		include("modules/page/pageprint.php");
		break;

	case 'roster':
		include("modules/clan/roster.php");
		break;
		
	case 'register':
		include("modules/user/register.php");
		break;

	case 'login':
		include("modules/user/login.php");
		break;
		
	case 'contact':
		include("modules/user/contact.php");
		break;

	case 'members':
		include("modules/user/members.php");
		break;
		
	case 'profile':
		include("modules/user/profile.php");
		break;		
//guest switch end -

//user switch start +
	case 'userpanel':
		include("modules/user/userpanel.php");
		break;

//user switch end -

//mod switch start +
	case 'newsadd':
		include("modules/news/newsadd.php");
		break;

	case 'newsedit':
		include("modules/news/newsedit.php");
		break;

	case 'newsdelete':
		include("modules/news/newsdelete.php");
		break;

	case 'pageadd':
		include("modules/page/pageadd.php");
		break;

	case 'pageedit':
		include("modules/page/pageedit.php");
		break;

	case 'pagedelete':
		include("modules/page/pagedelete.php");
		break;
//mod switch end -

//admin switch start +
	case 'configuration':
		include("modules/administration/configuration.php");
		break;
		
	case 'error':
		include("modules/administration/error.php");
		break;
		
//admin switch end -
	default:
		include($configuration->config_values['application']['default_action']);
		break;
		
}

if($_GET['page'] == $configuration->config_values['application']['default_action'])
{

	$TEMPLATE->load("index_footer.tpl");
	$TEMPLATE->publish();
	
}

if($_GET['page'] != "newsprint" && $_GET['page'] != "pageprint")
{

	include("footer.php");
	
}

?>
