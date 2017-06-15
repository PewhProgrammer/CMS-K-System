<?php
$responseCode = 200;

function isIterable($obj){
    return
        $obj instanceof Traversable || is_array($obj);
}
if(isset($_POST["resources"]) && isset($_POST["monitors"])) {
    $resources = $_POST["resources"];
    $monitors = $_POST["monitors"];

    if(isIterable($resources) && sizeof($resources) > 0){
        foreach($resources as $res){
            $resOutput .= $res.', ';
        }
    }
    else $responseCode = 400;

    if(isIterable($monitors) && sizeof($monitors) > 0){
        foreach($monitors as $mon){
            $monOutput .= $mon.', ';
        }
    }
    else $responseCode = 400;
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
    echo "Resources: ".$resOutput;
    echo "Monitors: ".$monOutput;
}
?>