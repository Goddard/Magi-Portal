<?php
defined('LOAD_SAFE') or die('Server Error');

//start page load timer
$start_time = microtime();

$gzip = ob_gzhandler($buffer, 1);

if($gzip)
{

	header("Content-Encoding: gzip");
	ob_start('ob_gzhandler');

}else{

	ob_start();

}

////////////////////////////////////
//  Checks PHP version and makes sure its atleast 5.1.0
////////////////////////////////////
if(version_compare(phpversion(), '5.1.0', '<') == true)
{

	die("PHP5 = false : PHP5 required");

}

////////////////////////////////////
//  Set system time
////////////////////////////////////
$date_time = date("l, F jS Y g:i:s A");

////////////////////////////////////
// Define root directory
////////////////////////////////////
define('__SITE_PATH', realpath(dirname(__FILE__)));

////////////////////////////////////
// Get Configuration Object
////////////////////////////////////
include(__SITE_PATH."/core/library/config.class.php");
$configuration = configuration::getInstance();

////////////////////////////////////
// Set Time Zone
////////////////////////////////////
date_default_timezone_set($configuration->config_values['application']['timezone']);

////////////////////////////////////
// Load Classes - Core
////////////////////////////////////
include(__SITE_PATH."/core/library/error.class.php");
include(__SITE_PATH."/core/library/template.class.php");
include(__SITE_PATH."/core/database/db.class.php");
////////////////////////////////////
// Classes Loaded - Core
////////////////////////////////////

////////////////////////////////////
// turn off auto error reporting doing our own.
////////////////////////////////////
error_reporting($configuration->config_values['application']['error_reporting']);
ini_set('display_errors', 1);
//error_reporting(E_ALL);
////////////////////////////////////
// Load Application Functions
////////////////////////////////////
function GET_IP()
{

	if(getenv('HTTP_CLIENT_IP'))
	{
		$ip = getenv('HTTP_CLIENT_IP');

	}elseif(getenv('HTTP_X_FORWARDED_FOR'))
	{

		$ip = getenv('HTTP_X_FORWARDED_FOR');

	}elseif(getenv('HTTP_X_FORWARDED'))
	{

		$ip = getenv('HTTP_X_FORWARDED');

	}elseif(getenv('HTTP_FORWARDED_FOR'))
	{

		$ip = getenv('HTTP_FORWARDED_FOR');

	}elseif (getenv('HTTP_FORWARDED'))
	{

		$ip = getenv('HTTP_FORWARDED');

	}else{

		$ip = $_SERVER['REMOTE_ADDR'];
		return $ip;

	}

}

function VERIFY_IP($ip)
{

    if(!empty($ip) && $ip == long2ip(ip2long($ip)))
    {

        $reserved_ips = array(array('0.0.0.0','2.255.255.255'), array('10.0.0.0','10.255.255.255'), array('127.0.0.0','127.255.255.255'), array('169.254.0.0','169.254.255.255'), array('172.16.0.0','172.31.255.255'), array('192.0.2.0','192.0.2.255'), array('192.168.0.0','192.168.255.255'), array('255.255.255.0','255.255.255.255'));

        foreach($reserved_ips as $r)
        {

            $min = ip2long($r[0]);
            $max = ip2long($r[1]);

            if ((ip2long($ip) >= $min) && (ip2long($ip) <= $max))
            {

			return false;

	    	}

        }

        return true;

    }

    return false;

}

function END_TIMER($start_time)
{
	$end_time = microtime();
	$end_time_array = explode(" ", $end_time);
	$end_time = $end_time_array['0'] + $end_time_array['1'];
	$start_time_array = explode(" ", $start_time);
	$start_time = $start_time_array['0'] + $start_time_array['1'];
	$execution_time = $end_time - $start_time;
	$execution_time = number_format($execution_time, 3);

return $execution_time;

}

function SECURITY($debug, $userlevel)
{

	if((count($_POST)!=0) || (count($_GET)!=0))
	{

		if(count($_POST)!=0)
		{

         include("plugins/decoda/decoda.php");

			foreach($_POST as $key => $val)
			{
            if($key == 'message')
            {
            
               $code = new Decoda($val);
               $code->useShorthand(false);
               $code->makeClickable(true);
               $code->setupGeshi("use_css = false");
               //$code->addCensored(array('shit'));
               $val = $code->parse(true);
               
            }

				   $_POST[$key] = $val;

				if($debug == 1 && $userlevel == 255)
				{

					echo "POST ARRAY - Field : $key Value: $val<br />";

				}

			}

		return $_POST;

		}elseif(count($_GET)!=0)
		{

			foreach($_GET as $key => $val)
			{

				$val = addslashes($val);
				$val = htmlentities($val, ENT_QUOTES);
				$_GET[$key] = $val;

				if($debug == 1 && $userlevel == 255)
				{

					echo "GET ARRAY - Field : $key Value: $val<br />";

				}

			}

			return $_GET;

		}else{

			die("ERROR with the http phaser");

		}

	}

	if($debug == 1 && $userlevel == 255)
	{
	
		if(is_array($_SESSION))
		{

			foreach($_SESSION as $key => $val)
			{

				$_SESSION[$key] = $val;
				echo "SESSION ARRAY - Field : $key Value: $val<br />";

			}

		}

	}

}
////////////////////////////////////
// Set Default Database type
////////////////////////////////////
include(__SITE_PATH."/core/database/drivers/" . $configuration->config_values['database']['db_type'] . ".class.php");

////////////////////////////////////
// Connect to Database
////////////////////////////////////
try
{

  $DB = new PDO($configuration->config_values['database']['db_type'].":host=".$configuration->config_values['database']['db_hostname'].";dbname=".$configuration->config_values['database']['db_name']."", $configuration->config_values['database']['db_username'], $configuration->config_values['database']['db_password']);
  $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION, PDO::ATTR_PERSISTENT);
  
}
catch(PDOException $e)
{

    echo "I'm sorry, Dave. I'm afraid I can't do that.";
    file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);

}



//if no session started start one
if(!isset($_SESSION['logged']))
{

	session_start();
	session_regenerate_id();

}

if(isset($_SESSION['logged']) && $_SESSION['logged'] == true && !empty($_SESSION['language']))
{

	$language = $_SESSION['language'];

}else{

	$language = $configuration->config_values['application']['language'];

}

////////////////////////////////////
// Include core language files
////////////////////////////////////
include(__SITE_PATH."/application/language/".$language."/core.lang.php");
include(__SITE_PATH."/application/language/".$language."/error.lang.php");

////////////////////////////////////
// Create template object
////////////////////////////////////
$TEMPLATE = new TEMPLATE("./".$configuration->config_values['template']['template_dir']."/".$configuration->config_values['template']['default_template']."/", "./".$configuration->config_values['template']['template_dir']."/static/");

////////////////////////////////////
// Define Error Variables - Create Error object
////////////////////////////////////
$error = new error($ip = GET_IP(), $debug = $configuration->config_values['application']['debug'], $email=$configuration->config_values['mail']['admin_mail'], __SITE_PATH.$error_log_file=$configuration->config_values['logging']['error_log_file'], $error_logging=$configuration->config_values['logging']['enable_error_log'], $error_mail=$configuration->config_values['mail']['enable_error_mail'], $db_type=$configuration->config_values['database']['db_type']);
set_error_handler(array(&$error, "handler"));

VERIFY_IP($ip);

if($ip != true)
{

	die();

}

////////////////////////////////////
// Handle Session's
////////////////////////////////////
if(!isset($_SESSION['userlevel']))
{

	$_SESSION['logged'] 	   = 'false';
	$_SESSION['uid'] 		   = 0;
	$_SESSION['username'] 	= 'Guest';
	$_SESSION['cookie'] 	   = 0;
	$_SESSION['remember'] 	= 'false';
	$_SESSION['language'] 	= $configuration->config_values['language']['default_language'];
	$_SESSION['timezone'] 	= $configuration->config_values['application']['timezone'];
	$_SESSION['template'] 	= $configuration->config_values['template']['default_template'];
	$_SESSION['userlevel'] 	= -1;
	$_SESSION['warnlevel'] 	= 0;
	$_SESSION['ip'] 		   = $ip;

}

if(isset($_SESSION['valid']) && $_SESSION['valid'] == 'false')
{

	unset($_SESSION['logged']);
	unset($_SESSION['uid']);
	unset($_SESSION['username']);
	unset($_SESSION['cookie']);
	unset($_SESSION['remember']);
	unset($_SESSION['language']);
	unset($_SESSION['timezone']);
	unset($_SESSION['template']);
	unset($_SESSION['userlevel']);
	unset($_SESSION['warnlevel']);
	unset($_SESSION['activitylevel']);
	unset($_SESSION['email']);
	unset($_SESSION['key']);
	unset($_SESSION['useragent']);
	unset($_SESSION['codename']);
	unset($_SESSION['valid']);
	header('Location: index.php');

}

////////////////////////////////////
// Define system variables
////////////////////////////////////
$adminjump = NULL;
$location  = NULL;

//redefine session variables for page use
$username = $_SESSION['username'];
$remember = $_SESSION['remember'];


//define session timeout time
$timeout = date("l, F jS Y g:i:s A", strtotime("-".$configuration->config_values['application']['session_timeout']));
$timeout_calc = strtotime($timeout);


if (isset($_SESSION['logged']) && $_SESSION['logged'] != 'false' && $_SESSION['useragent'] != $_SERVER['HTTP_USER_AGENT'])
{

	session_destroy();
	trigger_error($lang_error['SECURITY_ERROR'], E_USER_ERROR);

}

SECURITY($configuration->config_values['application']['debug'], $_SESSION['userlevel']);
?>