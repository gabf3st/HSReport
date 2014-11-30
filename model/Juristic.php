<?php

class Juristic {
    private static $dbConn = null;
	public function __construct() {
		self::initializeConnection();
	}

	private static function initializeConnection() {
		if (is_null(self::$dbConn)) {
			self::$dbConn = DatabasePDO::getInstance();
		}
	}
    
    public static function spGetDayAccess($startDate, $endDate) {
		self::initializeConnection();
		$result = null;
		try {
            $statement = self::$dbConn->prepare("CALL sp_genQueryEachProject2 ('[SELECT] count(DISTINCT dayofmonth((last_active + interval 7 hour))) AS days from [PROJECT].user_niti_log where (last_active + interval 7 hour) between  \'". $startDate ."\' and \'". $endDate ."\'')");
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
    
    
    //Created Announce
    public static function spGetAnnounce($startDate, $endDate) {
		self::initializeConnection();
		$result = null;
		try {
            
            $statement = self::$dbConn->prepare("CAll sp_genQueryEachProject2 (
'[SELECT] count(*) as announce_time FROM [PROJECT].user_niti_log 
where (last_active + interval 7 hour) between  \'". $startDate ."\' and \'". $endDate ."\'
and  detail like ''Announce Created%''')");
            
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
    
    //Available Announce
     public static function spGetComMsg($startDate, $endDate) {
		self::initializeConnection();
		$result = null;
		try {
//			$statement = self::$dbConn->prepare("call sp_genQueryEachProject2 ('[SELECT] count(*)  as tt from [PROJECT].community_msg  where is_shown = 1')");
			$statement = self::$dbConn->prepare("CALL sp_genQueryEachProject (
CONCAT('[SELECT] count(*) FROM [PROJECT].community_msg 
where   start_date >= ''', '".$startDate."',''' and end_date <= ''' ,'".$endDate."',''''),1)");
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
    
    //Announce : Get proj_db_name
     public static function spGetAnnounceDB($proj_name) {
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
    
    //Announce detail
     public static function spGetAnnounceDetail($proj_name) {
		self::initializeConnection();
		$result = null;
		try {
            $announcedb = Juristic::spGetAnnounceDB($proj_name);
//            echo $announcedb->db_name;
			$statement = self::$dbConn->prepare("SELECT *
                                                FROM ".$announcedb->db_name.".community_msg
                                                ORDER BY create_at desc;");
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
    
    
    //Mailbox
    public static function spGetPackage($startDate, $endDate) {
		self::initializeConnection();
		$result = null;
		try {
			$statement = self::$dbConn->prepare("call sp_genQueryEachProject2 ('[SELECT] count(distinct day(datetime)) as dd
from [PROJECT].package
where month(datetime) = 7') ");
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
    
     public static function spGetPhoneDir($startDate, $endDate) {
		self::initializeConnection();
		$result = null;
		try {
			$statement = self::$dbConn->prepare("call sp_genQueryEachProject2 ('[SELECT] count(distinct service_group_id ) as TotalHeader , count(*)  as TotalNumber from [PROJECT].phone_directory ')");
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