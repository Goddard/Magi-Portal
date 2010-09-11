<?php
////////////////////////////////////
// page load security
////////////////////////////////////
defined('LOAD_SAFE') or die('Server Error');

if(is_numeric($_GET['user']))
{
   
   $user = $_GET['user'];

   $sql1 = "SELECT * FROM users WHERE id = '$user'";

   $query1 = $DB->query($sql1) or trigger_error($lang_error['SELECT_ERROR'], E_USER_ERROR);

		foreach($query1 as $r)
		{
		
			$id				   =	$r['id'];
			$displayname		=	$r['displayname'];
			$useremail		   =	$r['email'];
			$creationdate	   =	$r['creationdate'];
			$age         	   =	$r['age'];
			$avatar			   =	$r['avatar'];
			$location			=	$r['location'];
			$occupation			=	$r['occupation'];
			$userlanguage		=	$r['language'];
			$signature  		=	$r['signature'];
			$biography  		=	$r['biography'];
			$msn        		=	$r['msn'];
			$yahoo        		=	$r['yahoo'];
			$google     		=	$r['google'];
			$skype        		=	$r['skype'];
			$url        		=	$r['url'];		
			$usertimezone		=	$r['timezone'];
			$usertemplate		=	$r['template'];
			$userlevel		   =	$r['userlevel'];
			$warnlevel		   =	$r['warnlevel'];
			$activitylevel		=	$r['activitylevel'];
			
		}

   $t_ = array(
	   'PROFILE_CODENAME' 		=> $displayname,
	   'PROFILE_JOINED'    		=> $activitylevel,
	   'PROFILE_AVATAR' 			=> $avatar,
	   'PROFILE_TIMEZONE' 		=> $usertimezone,
	   'PROFILE_AGE' 	      	=> $age,
	   'PROFILE_LOCATION' 		=> $location,
	   'PROFILE_OCCUPATION' 	=> $occupation,
	   'PROFILE_LANGUAGE' 		=> $userlanguage,
	   'PROFILE_SIGNATURE' 		=> $signature,
	   'PROFILE_BIOGRAPHY' 		=> $biography,
      'PROFILE_MSN' 	      	=> $msn,
      'PROFILE_YAHOO' 	   	=> $yahoo,
      'PROFILE_GOOGLE' 	   	=> $google,
      'PROFILE_SKYPE'    		=> $skype,
      'PROFILE_URL' 	      	=> $url,
	   'PROFILE_TEMPLATE' 		=> $usertemplate,	 
	   'PROFILE_ACTIVITY' 		=> $activitylevel,
	   'PROFILE_PM' 		      => "index.php?page=userpanel&user=sendmessage&userid=$id"	
   );

   $TEMPLATE->load("profile.tpl");
   $TEMPLATE->assign($t_);
   $TEMPLATE->publish();

}else{

   trigger_error($error['DEFAULT_ERROR'], E_USER_ERROR);

}
?>