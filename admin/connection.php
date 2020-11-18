<?php




class ConnectionBD{

private static $con = null;
private static $dbname = 'printer';

	public static function connect($dbname){

		try{

			self::$con=new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8",'root',''
			,[   
			     PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			     PDO::ATTR_EMULATE_PREPARES => false,
			     PDO::ATTR_PERSISTENT => true
			]);
		}
		catch(PDOException $e){
			die($e->getMessage());
		}

	}
	public static function getConnection(){
		if(self::$con == null)
		{
			self::connect(self::$dbname);
			return self::$con;
		}
		return self::$con;
	}
	public static function closeConnection()
	{
	  unset(self::$con);
	}


}