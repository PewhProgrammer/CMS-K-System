<?php

require_once("ServerWrapper.php");

class Attach extends ServerWrapper
{
    private $resources = "";
    private $resSize = 0;
    private $monitors = "";
    private $monSize = 0;
    private $until = "";
    private $build = 'INSERT INTO `monitorhasresource` (`mID`, `rID`, `until`) VALUES ';
    private $deleteBuild = 'DELETE FROM `monitorhasresource` WHERE ';

    function __construct()
    {
        //Check if keys exists
        if (isset($_POST["resources"]) && isset($_POST["monitors"])) {
            $this->resources = $_POST["resources"];
            $this->monitors = $_POST["monitors"];
            $this->until = $_POST["until"];
            $this->monSize = sizeof($this->monitors);
            $this->resSize = sizeof($this->resources);
            //Check if array
            if ($this->isIterable($this->monitors) && $this->monSize > 0 &&
                $this->isIterable($this->resources) && $this->resSize > 0
            ) {
                echo $this->execute();
                return;
            }

        }
        //echo "Wrong Param Format.";

    }

    public function execute()
    {
        $this->buildQuery();
        $this->deleteBuild .= ';';

        //Remove all resources from given monitors
        $query = new Query($this->deleteBuild);
        $query->executeQuery();

        //Add resources to monitors
        $query = new Query($this->build);
        $query->executeQuery();

        return $query->getResponse();
    }

    public function buildQuery()
    {
        for ($i = 0; $i < sizeof($this->monitors); $i++) {
            //append Strings to build
            $mon = $this->monitors[$i];
            $this->deleteBuild .= '`mID` = ' . $mon . ' ';
            if (($i + 1) != $this->monSize)
                $this->deleteBuild .= 'OR ';
            $j = 0;
            foreach ($this->resources as $res) {
                $this->build .= "(" . $mon . ", " . $res . ", '" . $this->until . "' " . ")";
                if (($j + 1) != $this->resSize) $this->build .= ", ";
                $j++;
            }
            if (($i + 1) != $this->monSize) $this->build .= ", ";
            else $this->build .= ";";
        }

    }


    public function isIterable($obj)
    {
        return
            $obj instanceof Traversable || is_array($obj);
    }

    public function setResources($resources, $monitors, $until) {
        $this->resources = $resources;
        $this->monitors = $monitors;
        $this->until = $until;
        $this->monSize = sizeof($this->monitors);
        $this->resSize = sizeof($this->resources);
    }

    public function getResources() {
        return $this->resources;
    }

    public function getMonitors() {
        return $this->monitors;
    }

    public function getUntil() {
        return $this->until;
    }

}

$a = new Attach();

?>