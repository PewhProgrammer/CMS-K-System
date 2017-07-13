<?php
/**
 * Created by PhpStorm.
 * User: Thinh-Laptop
 * Date: 01.06.2017
 * Time: 09:34
 */
require "dbconnect.php";
include_once "Response.php";

class Query extends ConnectionFactory {

    private $query;
    private $result;
    private $errorCode = 0;
    protected $response;


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
            return null;
        }

        //$this->query = $this->sanitize($conn, $this->query);

        if ($this->result = $conn->query($this->query)) {
            ConnectionFactory::getFactory()->closeConnection();
            $this->setResponse(200,$this->result);
           return $this->result;
        } else {
            $this->setResponse(404,'SQLQuery format error: '.$this->query);
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

        //$this->query = $this->sanitize($conn, $this->query);

        if ($conn->query($this->query) === TRUE) {
            $this->setResponse(200,"");
        } else {
            $this->setResponse(404,'SQLQuery format error: '.$this->query);
        }
        ConnectionFactory::getFactory()->closeConnection();
    }

    function sanitize($conn, $input){
        return $conn->real_escape_string($input);
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param mixed $response
     */
    public function setResponse($code, $msg)
    {
        $this->response = new Response($code, $msg);
    }

}

?>
