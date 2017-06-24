<?php
require 'dbconnect.php';
$responseCode = 200;

//Check if keys exists
if (isset($_POST["id"])) {

    $query = new Query("SELECT * FROM resources WHERE rID=" . $_POST["id"]);
    $res = $query->getQuery();

    if ($res->type == "pdf" || $res->type == "image"){ //delete also files from server

    }

    $query = new Query("DELETE FROM resources WHERE rID=" . $_POST["id"]);
    $db = $query->executeQuery();


}
else
$responseCode = 400;

// Check code
if ($responseCode == 400) {
    echo array(
        "status" => 400,
        "msg" => "Sorry, the system did something unexpected. Contact the developers of the system. 400"
    );
} else if ($responseCode == 404) {
    echo array(
        "status" => 404,
        "msg" => "Sorry, the system could not find the resource. Contact the developers of the system. 404"
    );
} else {
    echo array(
        "status" => 404,
        "msg" => "Your resource was successfully attached to the monitor"
    );
}
?>