<?php

require "dbquery.php";
include_once "Resource.php";

class Add extends Query
{

    private $resource;

    function __construct()
    {
        //Check if keys exists
        if (isset($_POST["name"]) && isset($_POST["type"]) && isset($_POST["path"]))
        {
            $this->resource = new Resource($_POST["name"], $_POST["path"], $_POST["type"]);
            $this->response = new Response(200, "Success");
        }
        else{
            $this->response = new Response(400, "Got no parameters.");
        }

    }

    public function addUrl(){

        if ($this->response->getCode() == 200){
            $query = new Query("INSERT INTO resources (name, type, data) VALUES ('" .  $this->resource->getName() . "', '" .  $this->resource->getType() . "', '" .  $this->resource->getData() . "')");
            $db = $query->getQuery();
        }
        return $this->response;
    }

}

$a = new Add();
$a->addUrl();

?>