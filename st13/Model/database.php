<?php

class Database
{
	private static $my_host = "localhost";
	private static $my_db = 'stdb';
	private static $my_db_username = "root";
	private static $my_db_passwd = "";

	public static function getConnection() 
	{
		try 
		{
			return new PDO("mysql:host=".self::$my_host.";dbname=".self::$my_db, self::$my_db_username, self::$my_db_passwd);
		} 
		catch (Exception $ex) 
		{
			return false;
		}
	}
}
	
?>