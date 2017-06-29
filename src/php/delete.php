<?php

require "dbquery.php";

class Delete extends Query
{
    private $responseCode = 200;
    private $id = "";

    function __construct()
    {
        //Check if keys exists
        if (isset($_POST["id"]))
        {
            $this->id = $_POST["id"];
        }
        else{
            $this->responseCode = 400;
        }

    }

    public function deleteResource(){

        if ($this->responseCode == 200){

            $query = new Query("SELECT * FROM resources WHERE rID=" . $_POST["id"]);
            $res = $query->getQuery();


            while ($row = $res->fetch_assoc()) {

                if ($row["type"] == "pdf" || $row["type"] == "image"){ //delete also files from server
                    unlink($row["data"]);
                }

                $query = new Query("DELETE FROM resources WHERE rID=" . $_POST["id"]);
                $db = $query->executeQuery();

            }

            echo array(
                "status" => 404,
                "msg" => "Your resource was successfully attached to the monitor"
            );
        }
        else {
            echo array(
                "status" => 400,
                "msg" => "Sorry, the system did something unexpected. Contact the developers of the system. 400"
            );
        }
    }

}

$a = new Delete();
$a->deleteResource();

?>