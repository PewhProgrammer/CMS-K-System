<?php

require "dbquery.php";

class Add extends Query
{
    private $responseCode = 200;
    private $name = "";
    private $type = "";
    private $path = "";

    function __construct()
    {
        //Check if keys exists
        if (isset($_POST["name"]) && isset($_POST["type"]) && isset($_POST["path"]))
        {
            $this->name = $_POST["name"];
            $this->type = $_POST["type"];
            $this->path = $_POST["path"];
        }
        else{
            $this->responseCode = 400;
        }

    }

    public function addUrl(){

        if ($this->responseCode == 200){
            $query = new Query("INSERT INTO resources (name, type, data) VALUES ('" .  $this->name . "', '" .  $this->type . "', '" .  $this->path . "')");
            $db = $query->getQuery();
        }
        else {
            echo array(
                "status" => 400,
                "msg" => "Sorry, the system did something unexpected. Contact the developers of the system. 400"
            );
        }
    }

}

$a = new Add();
$a->addUrl();

?>