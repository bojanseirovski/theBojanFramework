<?php
namespace BojanGles\lib;
/**
 * AppResource
 *
 * @author bseirovski
 */

class AppResource {
	
	protected $log, $db , $config, $response = array();
	
	
	public function __construct($config, $db) {
		$this->log = new Log($config['log_file']);
		$this->db = $db;
		$this->config = $config;
	}
}
