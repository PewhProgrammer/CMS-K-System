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
     * @return Response The return value shall be a Response
     */
    public function execute()
    {
        $empty = '';
        $this->query = new Query("INSERT INTO monitors (`mID`, `name`, `mac`, `new`) VALUES ('" . $this->mID . "', '" . $empty . "', '" . $empty . "', '" . TRUE . "')");
        $this->query->getQuery();
        return $this->query->getResponse();
    }
}

$a = new newMonitor();

?>