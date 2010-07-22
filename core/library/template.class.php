<?php

defined('LOAD_SAFE') or die('Server Error');

class TEMPLATE {

	private $tpl = NULL;

	private $filepath = NULL;

	private $staticpath = NULL;

	public function TEMPLATE($filepath, $staticpath){
		$this->filepath = $filepath;
		$this->staticpath = $staticpath;
	}

	public function DESTROY(){
		$this->tpl = NULL;
	}

	public function load($file) {
		if(file_exists($this->filepath . $file)){
			$this->tpl = file_get_contents($this->filepath . $file);
		}
	}

	public function loadstatic($file) {
		if(file_exists($this->staticpath . $file)){
			$this->tpl = file_get_contents($this->staticpath . $file);
		}
	}

	public function assign($var){
		if (!is_array($var)){
			return false;
		}else{
			foreach ($var as $i => $content){
				$this->tpl = str_replace("{".$i."}", $content, $this->tpl);
			}
			return true;
		}
	}

	public function publish() {
		eval("?>".$this->tpl."<?");
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
