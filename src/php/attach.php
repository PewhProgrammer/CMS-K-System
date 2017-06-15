<?php
require 'dbconnect.php';
$responseCode = 200;

function isIterable($obj){
    return
        $obj instanceof Traversable || is_array($obj);
}

if(isset($_POST["resources"]) && isset($_POST["monitors"])) {
    $resources = $_POST["resources"];
    $monitors = $_POST["monitors"];

    $build = 'INSERT INTO `monitorhasresource` (`mID`, `rID`, `until`) VALUES ';
    $deleteBuild = 'DELETE FROM `monitorhasresource` WHERE ' ;
    $monSize = sizeof($monitors);
    $monIter = 0;
    $iter = 0;
    if(isIterable($monitors) && $monSize > 0){
        for($i = 0 ; $i < sizeof($monitors); $i++ ){
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

    //$row = $db->fetch_assoc();
    //execute query


}
else $responseCode = 400 ;

// Check if $uploadOk is set to 0 by an error
if ($responseCode == 400) {
    echo "Sorry, the system did something unexpected. Contact the developers of the system. 400";
// if everything is ok, try to upload file
}
else if ($responseCode == 404){
    echo "Sorry, the system could not find the resource. Contact the developers of the system. 404";
}
else {
    echo "Your resource was successfully attached to the monitor";
}
?>