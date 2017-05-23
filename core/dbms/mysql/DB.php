<?php 
namespace dbms\mysql;

use Viewer\Viewer;
class DB
{
	private static $instance = null;
	private static $logger = null;
	private $mysqli;
	
	static public  function getInstance(){
		if(self::$instance === null){
			$instance = new DB();
		}
		return $instance;
	}

	public function __construct() {
		try {
			error_reporting(0);
			$this->mysqli = new \mysqli(HOST, USER, PASS, DB);
			if ($this->mysqli->connect_errno) {
				$out = [];
				$out[] = "Error Code: " . $this->mysqli->connect_errno;
				$out[] = "Error Description: " . $this->mysqli->connect_error;
				if(self::$logger===null){
					echo Viewer::show('database-error', $out);
					exit();
				} else {
					self::$logger->log($out);
				}
			}
			error_reporting(E_ALL);
		} catch (Exception $e) {
			Viewer::show('database-error', $error);
		}
		
	}

	public function query($query) {
		return $this->mysqli->query($query);;
	}

	private function fetch($result) {
		$rows = array();
		while($row = $result->fetch_array(MYSQLI_ASSOC))
		{
			$rows[] = $row;
		}
		return $rows;
	}

	public function queryToArray($query){
		return $this->fetch($this->query($query));
	}
	
	static public function q($query){
		$db = self::getInstance();
		return $db->query($query);
	}
	static public function qta($query){
		$db = self::getInstance();
		return $db->queryToArray($query);
	}
	
	public static function setLogger($logger){
		$this->logger = $logger;
		return $this;
	}
}
