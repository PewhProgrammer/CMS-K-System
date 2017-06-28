<?php
/**
 * Created by PhpStorm.
 * User: Thinh-Laptop
 * Date: 01.06.2017
 * Time: 09:34
 */
require "dbconnect.php";

class Query extends ConnectionFactory {

    private $query;
    private $result;
    private $errorCode = "";

    function __construct($sql) {
        $this->query = $sql ;
    }

    public function getQuery(){
        // Create connection
        try{
            $conn = ConnectionFactory::getFactory()->getConnection();
            //echo nl2br ("<<DB connection established \n");
        }catch (Exception $e){
            echo $e ;
            return;
        }

        if ($result = $conn->query($this->query)) {
            ConnectionFactory::getFactory()->closeConnection();
           return $result;
        } else {
            echo nl2br ("<< Query ".$this->query);
            echo nl2br ("<< Error. ". $this->errorCode . $conn->error. "\n");
        }

    }

    public function createErrorCode($code){
        $this->errorCode = $code ;
    }

    function executeQuery(){
        // Create connection
        try{
            $conn = ConnectionFactory::getFactory()->getConnection();
            //echo nl2br ("<<DB connection established \n");
        }catch (Exception $e){
            echo $e ;
            return;
        }

        if ($conn->query($this->query) === TRUE) {
            echo "Query executed successfully ";
        } else {
            echo nl2br ("<<Error. ". $this->errorCode . $conn->error. "\n");
        }
        ConnectionFactory::getFactory()->closeConnection();
    }
}

?>
