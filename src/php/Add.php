<?php

require_once("Events.php");
require_once "Resource.php";

class Add extends Events
{

    private $resource;


    function __construct()
    {
        //Check if keys exists
        if (isset($_POST["name"]) && isset($_POST["type"]) && isset($_POST["path"])) {
            $this->resource = new Resource($_POST["name"], $_POST["path"], $_POST["type"]);
            echo $this->execute();
            return;
        } else if(isset($_POST["newLabel"])) {
            echo $this->addNewLabel();
            return;
        } else if(isset($_POST["lID"]) && isset($_POST["mID"])) {
            echo $this->addLabelToMonitor();
            return;
        }
    }

    /**
     * @return Response The return value shall be a Response
     */
    public function execute()
    {
        if(!$this->verify()){
        }
        $this->query = new Query("INSERT INTO resources (name, type, data) VALUES ('" . $this->resource->getName() . "', '" . $this->resource->getType() . "', '" . $this->resource->getData() . "')");
        $this->query->getQuery();
        if($this->query->getResponse()->getCode() <> '200') return $this->query->getResponse();

        $url = $this->resource->getData();
        $header = get_headers($url, 1);
        //echo $header["X-Frame-Options"];
        return new Response('200',$header["X-Frame-Options"]);

        //return $this->query->getResponse();
    }

    public function addNewLabel() {
        $this->query = new Query("INSERT INTO labels (name,custom) VALUES ('".$_POST['newLabel']."','1')");
        $this->query->getQuery();
        return $this->query->getResponse();
    }

    public function addLabelToMonitor() {
        $this->query = new Query("INSERT INTO monitorhaslabel (mID,lID) VALUES (".$_POST['mID'].",".$_POST['lID'].")");
        $this->query->getQuery();
        return $this->query->getResponse();
    }

    public function setResource($res){
        $this->resource = $res;
    }

    public function getResource() {
        return $this->resource;
    }

    /**
     * Checks if the params are set correctly
     * @return bool The return value shall be a Boolean
     */
    protected function verify()
    {
        return true;
    }
}

$a = new Add();

?>