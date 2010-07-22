<?php

defined('LOAD_SAFE') or die('Server Error');

////////////////////////////////////
// MSQYL Abstraction Class
////////////////////////////////////
class MYSQLi extends DB_TYPE
{
	/**
	* @return unknown
	* @desc An obvious function.  Used to connect to the database.
	*/
	function connect()
	{
			
		$this->conn = mysqli_connect($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname)
		
	   return($this->conn);
		
	}

	/**
	* @return unknown
	* @desc Used to close the database connection is persistance is used.
	*/
	function close()
	{
		
		if($this->persistent)
		{
			
			$speed = 1;
			
		}else{
			
			$speed = mysql_close($this->conn);
			
		}
		
	return($speed);
	
	}

	/**
	* @return unknown
	* @param unknown $query
	* @desc queries database and detects if a query is a delete, update, or insert.
	*/
	function query($query)
	{
		
		$this->result = mysql_query($query);
		$detect1 = preg_replace("/DELETE/siU", 1, $query);
		$detect2 = preg_replace("/UPDATE/siU", 1, $query);
		$detect3 = preg_replace("/INSERT/siU", 1, $query);
		
		if($detect1 == 1 || $detect2 == 1 || $detect2 == 1)
		{
			
			$this->affected_rows = mysql_affected_rows();
			$this->affected_rows_total += $this->affected_rows;
			
		}

		$this->counter++;
		
	return($this->result);
		
	}

	/**
	* @return unknown
	* @param unknown $query_id
	* @desc counts the number of rows is a replacement for mysql_num_rows.
	*/
	function num_rows($query_id = 0)
	{
		
		if (!$query_id)
		$query_id = $this->query_result;
		return ($query_id) ? @mysql_num_rows($query_id) : false;
		
	}

	/**
    * @return unknown
    * @param unknown $row
    * @desc replacement for mysql_data_seek.
    */
	function seek($row)
	{
		
		$seek = mysql_data_seek($this->result, $row);
		
	return($seek);
	
	}

	/**
    * @return unknown
    * @desc fetch row is a replacement for mysql_fetch_row.
    */
	function fetch_row()
	{
		
		$row = mysql_fetch_row($this->result);
		$this->counter++;
		
	return($row);
		
	}

	/**
    * @return unknown
    * @param unknown $result
    * @desc fetch object function is a replacement for mysql_fetch_object.
    */
	function fetch_object($result)
	{
		
		$object = mysql_fetch_object($result);
		
	return($object);
	
	}

	/**
    * @return unknown
    * @param unknown $result
    * @desc fetch array function is a replacement for mysql_fetch_array non-object loops apply.
    */
	function fetch_array($result)
	{
		
		$array = mysql_fetch_array($result);
		
	return($array);
	
	}

	/**
    * @return unknown
    * @param unknown $result
    * @desc fetch assoc function is a replacement for mysql_fetch_assoc non-object loops apply.
    */
	function fetch_assoc($result)
	{
		
		$array = mysql_fetch_assoc($result);
		
	return($array);
	
	}

	/**
	* @return unknown
	* @param unknown $query_id
	* @param unknown $row
	* @desc replacement for mysql_result
	*/
	function result($query_id = 0, $row = 0)
	{
		
		if(!$query_id)
		$query_id = $this->query_result;
		return($query_id) ? @mysql_result($query_id, $row) : false;
		
	}

	/**
	* @return unknown
	* @desc Counts numbers of queries used.
	*/
	function count_queries()
	{
		
	return $this->counter;
		
	}

	/**
	* @return unknown
	* @desc Used to count the number of Deleted, Inserted, or Updated queries used in a page.  This is displayed at the bottom of hte page.
	*/
	function affected_rows()
	{
		
		if($this->affected_rows_total == "0")
		{
			
			$this->affected_rows_total = "0";
			
		}
		
	return $this->affected_rows_total;
	}

	/**
    * @return unknown
    * @desc free results and memory from the interprater.
    */
	function free()
	{
		
		$free = mysql_free_result($this->result);
		
		return($free);
		
	}
}

	$DB = new MYSQL_DB();
	
?>