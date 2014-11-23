<?php

class Register {
	
	private static $dbConn = null;
	public function __construct() {
		self::initializeConnection();
	}

	private static function initializeConnection() {
		if (is_null(self::$dbConn)) {
			self::$dbConn = DatabasePDO::getInstance();
		}
	}

	/* spGetactiveUser()
	count($result)
	*/
	public static function spGetactiveUser() {
		self::initializeConnection();
		$result = null;
		try {
			$statement = self::$dbConn->prepare("CALL sp_getactive_user");
			$statement->execute();
			$statement->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
			$result = $statement->fetchAll();
		}
		catch (PDOException $e) {
			echo "Error: " . $e->getMessage();
			die();
		}
		return $result;
	}
    
    
    public static function spGetMonthlyRegister() {
		self::initializeConnection();
		$result = null;
		try {
//			$statement = self::$dbConn->prepare("SELECT * FROM total_register where y_date = '". date("Y") ."'" );
            $statement = 
                self::$dbConn->prepare("SELECT SUM(month1) as month1,SUM(month2) as month2, SUM(month3) as month3, SUM(month4) as month4, SUM(month5) as month5, SUM(month6) as month6,
SUM(month7) as month7, SUM(month8) as month8, SUM(month9) as month9, SUM(month10) as month10, SUM(month11) as month11, SUM(month12) as month12 FROM total_register where y_date = '". date("Y") ."' group by y_date" );
			$statement->execute();
			$statement->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
			$result = $statement->fetchAll();
		}
		catch (PDOException $e) {
			echo "Error: " . $e->getMessage();
			die();
		}
		return $result;
	}
    

	/* spCountuser()
	object -> id, project, total_unit, totaluser
	*/
	public static function spCountuser() {
		self::initializeConnection();
		$result = null;
		try {
			$statement = self::$dbConn->prepare("CALL sp_countuser");
			$statement->execute();
			$statement->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
			$result = $statement->fetchAll();
		}
		catch (PDOException $e) {
			echo "Error: " . $e->getMessage();
			die();
		}
		return $result;
	}

	/* newRegister
	count($result)
	*/
	public static function newRegister($strDate,$endDate) {
		self::initializeConnection();
		$result = null;
		try {
            $statement = self::$dbConn->prepare(
"select proj , sum(total) as regis_total 
from vw_new_register 
where regis_date between '".$strDate."' and '".$endDate."'
group by proj");
			$statement->execute();
			$statement->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
			$result = $statement->fetchAll();
		}
		catch (PDOException $e) {
			echo "Error: " . $e->getMessage();
			die();
		}
		return $result;
	}
    
    public static function getProjLocation() {
		self::initializeConnection();
		$result = null;
		try {
			$statement = self::$dbConn->prepare("SELECT location, count(location) as num_of_proj from hs_main.project group by location order by location");
			$statement->execute();
			$statement->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
			$result = $statement->fetchAll();
		}
		catch (PDOException $e) {
			echo "Error: " . $e->getMessage();
			die();
		}
		return $result;
	}

}

?>