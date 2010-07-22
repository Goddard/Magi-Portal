<?php

defined('LOAD_SAFE') or die('Server Error');

////////////////////////////////////
// Database Connection/Type Class
////////////////////////////////////

class DB_TYPE
{
	
	public function dbhost($dbhost)
	{
		
		$this->dbhost = $dbhost;
		
	}
	
	public function dbuser($dbuser)
	{
		
		$this->dbuser = $dbuser;
		
	}
	
	public function dbpass($dbpass)
	{
		
		$this->dbpass = $dbpass;
		
	}
	
	public function dbname($dbname)
	{
		
		$this->dbname = $dbname;
		
	}
		
	public function persistent()
	{
		
		$this->persistent = 1;

	}

}
?>
