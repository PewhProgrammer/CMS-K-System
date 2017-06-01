<?php
/**
 * Created by PhpStorm.
 * User: Jonas
 * Date: 29.05.2017
 * Time: 19:51
 */

/** This should serve as a db connection wrapper to make sure connection
 * is open and if interrupted, will re-open again*/

require 'dbqueries.php';

class ConnectionFactory{
    private static $factory;

    public static function getFactory(){
        if (!self::$factory) {
            self::$factory = new ConnectionFactory();
        }
        return self::$factory;
    }

    private $db;
    private $servername = "localhost";
    private $username = "root";
    private $password = "root";
    private $dbname = "myDB";

    public function getConnection(){
        if (is_null($this->db))
            $this->db = new mysqli($this->servername, $this->username, $this->password,$this->dbname);
        if ($this->db->connect_error) {
            throw new Exception("Connect Error ("
                . $this->db->connect_errno
                . ") "
                . $this->db->connect_error
            );
        }
        return $this->db;
    }

    public function closeConnection(){
        if (!is_null($this->db)) {
            $this->db->close();
            $this->db = null;
        }
    }
}

$query = new Query('CREATE DATABASE myDB');
$query->executeQuery();

/*// Create database
$sql = "CREATE DATABASE myDB";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . $conn->error;
}*/

ConnectionFactory::getFactory()->closeConnection();
?>