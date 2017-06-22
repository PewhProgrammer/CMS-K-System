<?php
require 'dbconnect.php';
$responseCode = 200;

//Check if keys exists
if(isset($_POST["name"]) && isset($_POST["type"]) && isset($_POST["path"])) {

    $query = new Query("INSERT INTO resources (name, type, data) VALUES ('" . $_POST["name"] . "', '" . $_POST["type"] . "', '" . $_POST["path"] . "')");
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