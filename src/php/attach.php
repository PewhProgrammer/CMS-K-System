<?php

require "dbquery.php";

class Attach extends Query
{
    private $resources = "";
    private $resSize = 0;
    private $monitors = "";
    private $monSize = 0;
    private $monOutput = "";
    private $until = "";
    private $build = 'INSERT INTO `monitorhasresource` (`mID`, `rID`, `until`) VALUES ';
    private $deleteBuild = 'DELETE FROM `monitorhasresource` WHERE ' ;

    function __construct()
    {
        //Check if keys exists
        if (isset($_POST["resources"]) && isset($_POST["monitors"]))
        {
            $this->resources = $_POST["resources"];
            $this->monitors = $_POST["monitors"];
            $this->until = $_POST["until"];
            $this->monSize = sizeof($this->monitors);
            $this->resSize = sizeof($this->resources);
            $this->response = new Response(200, "Success");
            $this->buildQuery();
        }
        else{
            $this->response = new Response(400, "Got no parameters.");
        }

    }

    public function isIterable($obj){
        return
            $obj instanceof Traversable || is_array($obj);
    }

    public function buildQuery(){

        //Check if array
        if($this->isIterable($this->monitors) && $this->monSize > 0){

            for($i = 0 ; $i < sizeof($this->monitors); $i++ ){
                //append Strings to build
                $mon = $this->monitors[$i];
                $this->monOutput .= $mon.', ';
                $this->deleteBuild .= '`mID` = '.$mon.' ';
                if(($i+1) != $this->monSize)
                    $this->deleteBuild .= 'OR ';
                if($this->isIterable($this->resources) && $this->resSize > 0){
                    $j = 0;
                    foreach($this->resources as $res){
                        $this->build .= "(".$mon.", ".$res.", '". $this->until."' ".")";
                        if(($j+1) != $this->resSize) $this->build .= ", ";
                        //else $this->build .= ";";
                        $j++;
                    }
                }
                else {
                    $this->response->setCode(404);
                    $this->response->setMsg("Error");
                }
                if(($i+1) != $this->monSize) $this->build .= ", ";
                else $this->build .= ";";
            }
        }
        else {
            $this->response->setCode(404);
            $this->response->setMsg("Error");
        }
        $this->execute();
    }

    public function execute(){

        if ($this->response->getCode() == 200){

            $this->deleteBuild .= ';';

            //Remove all resources from given monitors
            $query = new Query($this->deleteBuild);
            $db = $query->getQuery();

            //Add resources to monitors
            $query = new Query($this->build);
            $db = $query->getQuery();
            $this->response->setMsg($this->build);


        }
        return $this->response;
    }

}

$a = new Attach();

?>