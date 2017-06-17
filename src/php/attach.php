<?php
require 'dbconnect.php';
$responseCode = 200;

function isIterable($obj){
    return
        $obj instanceof Traversable || is_array($obj);
}

//Check if keys exists
if(isset($_POST["resources"]) && isset($_POST["monitors"])) {
    $resources = $_POST["resources"];
    $monitors = $_POST["monitors"];

    //stringBuilder for queries
    $build = 'INSERT INTO `monitorhasresource` (`mID`, `rID`, `until`) VALUES ';
    $deleteBuild = 'DELETE FROM `monitorhasresource` WHERE ' ;
    $monSize = sizeof($monitors);

    //Check if array
    if(isIterable($monitors) && $monSize > 0){
        for($i = 0 ; $i < sizeof($monitors); $i++ ){
            //append Strings to build
            $mon = $monitors[$i];
            $monOutput .= $mon.', ';
            $deleteBuild .= '`mID` = '.$mon.' ';
            if(($i+1) != $monSize)
                $deleteBuild .= 'OR ';
            if(isIterable($resources) && sizeof($resources) > 0){
                foreach($resources as $res){
                    $resOutput .= $res.', ';
                    $build .= "(".$mon.", ".$res.", '".$_POST["until"]."' ".")";
                }
            }
            else $responseCode = 400;
            if(($i+1) != $monSize) $build .= ", ";
            else $build .= ";";
        }
    }
    else $responseCode = 400;

    $deleteBuild .= ';';

    //Remove all resources from given monitors
    $query = new Query($deleteBuild);
    $db = $query->getQuery();

    //Add resources to monitors
    $query = new Query($build);
    $db = $query->getQuery();
}
else $responseCode = 400 ;

// Check code
if ($responseCode == 400) {
    echo array(
        "status" => 400,
        "msg" => "Sorry, the system did something unexpected. Contact the developers of the system. 400"
        );
}
else if ($responseCode == 404){
    echo array(
        "status" => 404,
        "msg" => "Sorry, the system could not find the resource. Contact the developers of the system. 404"
    );
}
else {
    echo array(
        "status" => 404,
        "msg" => "Your resource was successfully attached to the monitor"
    );
}
?>