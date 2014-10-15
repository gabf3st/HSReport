<?php

class DatabasePDO {
	
	private static $_instance = array();

	static function getInstance($dbName = 'hs_main') {
		if (!array_key_exists($dbName, self::$_instance)) {
			$dbtype = 'mysql';
			$username = 'root';
			$password = 'root';
			$hostname = 'localhost';
			$dsn = $dbtype . ":host=" . $hostname . ";dbname=" . $dbName;
			try {
				self::$_instance[$dbName] = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
			}
			catch (PDOException $e) {
				echo "Error: " . $e->getMessage();
				die();
			}
		}
		return self::$_instance[$dbName];
	}

}

?>