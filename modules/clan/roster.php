<?php
////////////////////////////////////
// page load security
////////////////////////////////////
defined('LOAD_SAFE') or die('Server Error');

$getclanmembers = "SELECT * FROM users WHERE clan='1'";
$query = $DB->query($getclanmembers);

foreach($query as $r)
{

   $roster_id         	=	$r["id"];
	$roster_displayname	=	$r["displayname"];
	$roster_age			   =	$r["age"];
	$roster_avatar			=	$r["avatar"];
	$roster_location		=	$r["location"];
	$roster_occupation	=	$r["occupation"];
	$roster_signature		=	$r["signature"];
	$roster_biography		=	$r["biography"];
	$roster_url			   =	$r["url"];

	$t_ = array(
	   'ROSTER_ID' 		   => $roster_id,
		'ROSTER_NAME' 		   => $roster_displayname,
		'ROSTER_AGE' 		   => $roster_age,
		'ROSTER_AVATAR' 	   => "<img src=\"".$roster_avatar."\" />",
		'ROSTER_LOCATION' 	=> $roster_location,
		'ROSTER_OCCUPATION' 	=> $roster_occupation,
		'ROSTER_SIGNATURE' 	=> $roster_signature,
		'ROSTER_BIOGRAPHY' 	=> $roster_biography,
		'ROSTER_URL' 		   => "http://" . $roster_url
	);

	$TEMPLATE->load("roster.tpl");
	$TEMPLATE->assign($t_);
	$TEMPLATE->publish();	

}
?>