<?php
////////////////////////////////////
// page load security
////////////////////////////////////
defined('LOAD_SAFE') or die('Server Error');

////////////////////////////////////
// Error class handles error processing
////////////////////////////////////
Class error
{

	var $link_id;
	var $line;
	var $file;
	var $error_default;
	
	public function error($ip=0, $debug=0, $email=NULL, $error_log_file=NULL, $error_logging=0, $error_mail=0, $db_type=NULL)
	{

		$this->ip = $ip;
		$this->debug = $debug;
		$this->email = $email;
		$this->log_file = $error_log_file;
		$this->log_error = $error_logging;
		$this->mail_error = $error_mail;
		$this->db_type = $db_type;
		$this->log_message = NULL;
		$this->email_sent = false;

		$this->error_codes =  E_ERROR | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR;
		$this->warning_codes =  E_WARNING | E_CORE_WARNING | E_COMPILE_WARNING | E_USER_WARNING;

		$this->error_names = array('E_ERROR','E_WARNING','E_PARSE','E_NOTICE','E_CORE_ERROR','E_CORE_WARNING',
									'E_COMPILE_ERROR','E_COMPILE_WARNING','E_USER_ERROR','E_USER_WARNING',
								 	'E_USER_NOTICE','E_STRICT','E_RECOVERABLE_ERROR');

		for($i=0,$j=1,$num=count($this->error_names); $i<$num; $i++,$j=$j*2)
				$this->error_numbers[$j] = $this->error_names[$i];
				
	}

   public function handler($errno, $errstr, $errfile, $errline, $errcontext)
   {

		$this->errno = $errno;
		$this->errstr = $errstr;
		$this->errfile = $errfile;
		$this->errline = $errline;
		$this->errcontext = $errcontext;

		if($this->log_error == 1)
		{
			$this->LogError();
				
		}
			
		if($this->mail_error == 1)
		{
			
			$this->SendError();
			
		}
			
		if($this->debug == 1)
		{
			
			$url = "error.php";
			echo "<meta http-equiv=\"Refresh\" content=\"0;url=".$url."\">";
				
		}
			
		  return true;
		   
   }

   private function ErrorMessage()
	{

			$message =  "Time: ".date("j M y - g:i:s A (T)", time())."<br />";
			$message .= "File: ".$this->errfile."<br />";
			$message .= "Line: ".$this->errline."<br />";
			$message .= "Code: ".$this->error_numbers[$this->errno]."<br />";
			$message .= "Message: ".$this->errstr."<br />";
			$message .= "IP: ".$this->ip;

			return $message;
			
	}

	private function SendError()
	{
	
		if($this->mail_error==1)
		{
		
		   error_log("Server Error Notification: 
		   File: ".$this->errfile."
		   Line: ".$this->errline. "
		   Code: ".$this->error_numbers[$this->errno]."
		   Message: ".$this->errstr."
		   IP: ".$this->ip, 1, $this->email);
		   
		   return $this->email_sent=true;
		   
		}
		
		return $this->email_sent=false;
		
	}

	private function LogError()
	{
	
		$message =  "Time: ".date("j M y - g:i:s A (T)", time())."\n";
		$message .= "File: ".$this->errfile."\n";
		$message .= "Line: ".$this->errline."\n";
		$message .= "Code: ".$this->error_numbers[$this->errno]."\n";
		$message .= "Message: ".$this->errstr."\n";
		$message .= "IP: ".$this->ip."\n";
		$message .= "##################################################\n\n";

		if (!$fp = fopen($this->log_file, 'a+'))
			$this->log_message = "Could not open/create file: $this->log_file to log error."; $log_error = true;

		if (!fwrite($fp, $message))
			$this->log_message = "Could not log error to file: $this->log_file. Write Error."; $log_error = true;

		if(!$this->log_message)
			$this->log_message = "Error was logged to file: $this->log_file.";

		fclose($fp);
		
	}

	public function readerrorlog()
	{
	
		if (file_exists($this->log_file))
		{
		
			$error_log = fopen($this->log_file, 'r');
			$line_number = 0;
			$real_number = 0;
			$message = "";
			
			while ($line = fgets($error_log))
			{
			   if($line_number == 0 && $line != "\n")
			   {

               $message .= "<div><div class=\"errorcodetitle\"><b>Error:</b><a href=\"#\" onclick=\"selectCode(this); return false;\"> SELECT ERROR</a></div><div class=\"codecontent\"><code>";
			
			   }
			
			   if($line != "\n")
			   {
			   
				   $line_number++;
				   $real_number++;
				   $message .= $real_number." ";
				   
			   }
			   
			   if($line_number >= 1 && $line != "\n")
			   {
			   
				$message .= $line;
				
			   }
			   
			   if($line_number == 7)
			   {
			   
				$message .= "</code></div></div><br />";
				$line_number = 0;
				
			   }
			   
			}
			
		return $message;
		
		fclose($error_log);
		
		} else {
		
   	 	$message = "The file ".$this->log_file." does not exist";
   	 	
		}
		
	}

	public function clearerrorlog()
	{
	
		$error_log = fopen($this->log_file, 'w');
		fwrite($error_log, "");
		
	}

	public function DatabaseError()
	{
		if($this->db_type=='mysql')
		{
		
			$default_db_error = mysql_error();
			
		}else{
		
			$default_db_error = "User Database Undefined";
			
		}
		
		return $default_db_error;
		
	}
	
}
?>