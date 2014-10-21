<?php

class Homecare {

	private static $dbConn = null;
    
	public function __construct() {
		self::initializeConnection();
	}
    
    public function getStartDate(){
        return $this->startDate;   
    }
    
    public function getEndDate(){
        return $this->endDate;   
    }

	private static function initializeConnection() {
		if (is_null(self::$dbConn)) {
			self::$dbConn = DatabasePDO::getInstance();
		}
	}

    public static function homecareRequest($strDate,$endDate) {
		self::initializeConnection();
		try {
			$statement = self::$dbConn->query(" select Project , sum(total) as total , 
                                        sum(waiting) as waiting,
                                        sum(accept) as accept,
                                        sum(review) as review,
                                        sum(success) as success,
                                        sum(cancel) as cancel
                                        from vw_homecare
                                        where period between '".$strDate."' and '".$endDate."'
                                        group by Project
                                        order by sum(total) desc; ");
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
    
    public static function homecareType($strDate,$endDate) {
		self::initializeConnection();
		try {
			$statement = self::$dbConn->query(" select homecare_type_title , sum(total) as total
                                        from vw_homecare
                                        where period  between '".$strDate."' and '".$endDate."'
                                        group by homecare_type_title 
                                        order by count(*)  desc ;  ");
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
    
    
    public static function spGetDB($proj_name) {
		self::initializeConnection();
		$result = null;
		try {
			$statement = self::$dbConn->prepare("SELECT db_name FROM hs_main.project where name_en = '".$proj_name."';");
			$statement->execute();
			$statement->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
			$result = $statement->fetch();
		}
		catch (PDOException $e) {
			echo "Error: " . $e->getMessage();
			die();
		}
		return $result;
	}
    
    
    public static function homecareRequestDetail($proj_name,$status,$sDate,$eDate) {
		self::initializeConnection();
		$result = null;
		try {
            $announcedb = Homecare::spGetDB($proj_name);
			$statement = self::$dbConn->prepare("select unit_code,detail,datetime,is_responsed from ".$announcedb->db_name.".homecare where is_responsed = '".$status."' and (datetime between '".$sDate."' and '".$eDate."') order by datetime desc;");
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
//    
//    
   

}