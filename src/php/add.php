<?php

require_once("ServerWrapper.php");
require_once "Resource.php";

class Add extends ServerWrapper
{

    private $resource;


    function __construct()
    {
        //Check if keys exists
        if (isset($_POST["name"]) && isset($_POST["type"]) && isset($_POST["path"])) {
            $this->resource = new Resource($_POST["name"], $_POST["path"], $_POST["type"]);
            $this->execute();
            return;
        }
    }

    /**
     * @return Response The return value shall be a Response
     */
    public function execute()
    {
        $this->query = new Query("INSERT INTO resources (name, type, data) VALUES ('" . $this->resource->getName() . "', '" . $this->resource->getType() . "', '" . $this->resource->getData() . "')");
        $this->query->getQuery();
        return $this->query->getResponse();
    }


    public function setResource($res){
        $this->resource = $res;
    }

    public function getResource() {
        return $this->resource;
    }
}

$a = new Add();

?>