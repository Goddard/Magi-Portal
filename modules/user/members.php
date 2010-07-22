<?php
////////////////////////////////////
// page load security
////////////////////////////////////
defined('LOAD_SAFE') or die('Server Error');

$sql1 = "SELECT * FROM users WHERE active='1'";
$query = $DB->query($sql1);

foreach($query as $r)
{

	$members_displayname	   =	$r["displayname"];
	$members_age			   =	$r["age"];
	$members_avatar			=	$r["avatar"];
	$members_location		   =	$r["location"];
	$members_occupation	   =	$r["occupation"];
	$members_signature		=	$r["signature"];
	$members_biography		=	$r["biography"];
	$members_url			   =	$r["url"];

	$t_ = array(
		'MEMBERS_NAME' 		   => $members_displayname,
		'MEMBERS_AGE' 		      => $members_age,
		'MEMBERS_AVATAR' 	      => $members_avatar,
		'MEMBERS_LOCATION' 	   => $members_location,
		'MEMBERS_OCCUPATION' 	=> $members_occupation,
		'MEMBERS_SIGNATURE' 	   => $members_signature,
		'MEMBERS_BIOGRAPHY' 	   => $members_biography,
		'MEMBERS_URL' 		      => $members_url
	);

	$TEMPLATE->load("members.tpl");
	$TEMPLATE->assign($t_);
	$TEMPLATE->publish();	

}
?>