<?php

require_once("ServerWrapper.php");

class newMonitor extends ServerWrapper
{
    private $mID;

    function __construct()
    {
        //Check if keys exists
        if (isset($_POST["mID"])) {
            $this->mID = $_POST["mID"];
            echo $this->execute();
            return;
        }
    }

    /**
     * Either puts a new unregistered monitor into db or registers a db
     * @return Response The return value shall be a Response
     */
    public function execute()
    {
        if(isset($_POST['name'])){
            $this->query = new Query("UPDATE monitors SET `name`='".$_POST['name']."', `new` = 0 WHERE `mID`=".$_POST['mID']);
            $this->query->getQuery();
            $this->query = new Query("INSERT INTO monitorhaslabel (`mID`, `lID`) VALUES ('".$_POST['mID']."','".$_POST['alignment']."')");
            $this->query->getQuery();
            $this->query = new Query("INSERT INTO monitorhaslabel (`mID`, `lID`) VALUES ('".$_POST['mID']."','".$_POST['location']."')");
            $this->query->getQuery();
            return $this->query->getResponse();;
        }
        $empty = '';
        $this->query = new Query("INSERT INTO monitors (`mID`, `name`, `mac`, `new`) VALUES ('" . $this->mID . "', '" . $empty . "', '" . $empty . "', '" . TRUE . "')");
        $this->query->getQuery();
        return $this->query->getResponse();
    }
}

$a = new newMonitor();

?>