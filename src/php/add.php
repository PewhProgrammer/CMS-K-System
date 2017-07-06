<?php

require "ServerWrapper.php";
include_once "Resource.php";

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
        echo "Wrong Param Format.";

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
}

$a = new Add();

?>