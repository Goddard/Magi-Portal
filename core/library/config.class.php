<?php
defined('LOAD_SAFE') or die('Server Error');
class configuration{
	/*
	* @var string $config_file
	*/
	private static $ini_file = '../../configuration/magi.ini.php';
	/*
	 * @var array $config_values; 
	 */
	private static $ini_values = array();

	/*
	* @var object $instance
	*/
	private static $instance = null;

	/**
	 *
	 * Return Config instance or create intitial instance
	 *
	 * @access public
	 *
	 * @return object
	 *
	 */
	public static function getInstance(){
 		if(is_null(self::$instance)){
 			self::$instance = new configuration;
 		}
		return self::$instance;
	}
	/**
	 *
	 * @the constructor is set to private so
	 * @so nobody can create a new instance using new
	 *
	 */
	private function configuration(){
		$this->config_values=parse_ini_file(__SITE_PATH . self::$ini_file, true);
	}
	/**
	 * @get a config option by key
	 *
	 * @access public
	 *
	 * @param string $key:The configuration setting key
	 *
	 * @return string
	 *
	 */
	public function getValue($key){
		return self::$ini_values[$key];
	}
	/**
	 *
	 * @__clone
	 *
	 * @access private
	 *
	 */
	private function __clone(){
	}
}
?>
