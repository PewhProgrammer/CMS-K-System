<?php
session_start();
/**
 * Created by PhpStorm.
 * User: Jonas
 * Date: 29.05.2017
 * Time: 19:51
 */

/** This should serve as a db connection wrapper to make sure connection
 * is open and if interrupted, will re-open again
 * Addtionally, check if multiple connection exists
 */

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
    private $dbname = "cms_k";
    private $lock = false;

    public function getConnection(){
        while($this->lock){
            sleep(1);
        }
        $this->lock = true;
        if (!function_exists('mysqli_init') && !extension_loaded('mysqli')) {
            echo 'We don\'t have mysqli!';
            return null;
        }

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
        $this->lock = false;
        if (!is_null($this->db)) {
            $this->db->close();
            $this->db = null;
        }
    }
}
?>