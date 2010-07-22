<?php
defined('LOAD_SAFE') or die('Server Error');

if($_SESSION['logged'] == true)
{

   $usercase = array('statistics', 'required', 'personalize', 'messages', 'messagesdelete');
   
   if(!isset($_GET['user']) || empty($_GET['user']) || !in_array($_GET['user'], $usercase))
   {

	   $_GET['user'] = "statistics";
	
   }

   include("modules/user/userheader.php");

   switch($_GET['user'])
   {
   
	   case 'statistics':
	   	include("modules/user/statistics.php");
	   	break;

	   case 'required':
		   include("modules/user/required.php");
		   break;

	   case 'personalize':
	   	include("modules/user/personalize.php");
		   break;

	   case 'messages':
		   include("modules/user/messages.php");
		   break;
		   
	   case 'messagesdelete':
		   include("modules/user/messagesdelete.php");
		   break;
		   
	   default:
		   include("modules/user/statistics.php");
		   break;
		   
   }

   include("modules/user/userfooter.php");

}else{

   $refresh = "<meta http-equiv=\"Refresh\" content=\"0; URL=index.php?page=news\">";
   echo $refersh;
   
}
?>