<?php
# from: http://www.startutorial.com/articles/view/php-crud-tutorial-part-1
class Database
{
    private static $dbName = 'gpcorser' ;
    private static $dbHost = 'localhost' ;
    private static $dbUsername = 'gpcorser';
    private static $dbUserPassword = 'remember';
     
    private static $cont  = null;
     
    public function __construct() {
        die('Init function is not allowed');
    }
     
    public static function connect()
    {
       // One connection through whole application
       if ( null == self::$cont )
       {     
        try
        {
          self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword); 
        }
        catch(PDOException $e)
        {
          die($e->getMessage()); 
        }
       }
       return self::$cont;
    }
     
    public static function disconnect()
    {
        self::$cont = null;
    }
}
?>
