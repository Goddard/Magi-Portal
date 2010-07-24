<?php
////////////////////////////////////
// page load security
////////////////////////////////////
defined('LOAD_SAFE') or die('Server Error');

//if username changes and ip doesn't match user logged in delete old guest session
if(is_numeric($_GET['user']))
{
   
   $user = $_GET['user'];
////////////////////////////////////
// sql commands
////////////////////////////////////
$sql1 = "SELECT * FROM users WHERE id = '$user'";

////////////////////////////////////
// sql queries
////////////////////////////////////
$query1 = $DB->query($sql1) or trigger_error($lang_error['SELECT_ERROR'], E_USER_ERROR);

}

?>