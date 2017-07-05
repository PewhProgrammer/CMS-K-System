<?php

require "dbquery.php";

class Delete extends Query
{
    private $id = 0;

    function __construct()
    {
        //Check if keys exists
        if (isset($_POST["id"]))
        {
            $this->id = $_POST["id"];
            $this->response = new Response(200, "Success");
        }
        else{
            $this->response = new Response(400, "Got no parameters.");
        }

    }

    public function deleteResource(){

        if ($this->response->getCode() == 200){

            $query = new Query("SELECT * FROM resources WHERE rID=" . $_POST["id"]);
            $res = $query->getQuery();


            while ($row = $res->fetch_assoc()) {

                if ($row["type"] == "pdf" || $row["type"] == "image"){ //delete also files from server
                    unlink($row["data"]);
                }

                $query = new Query("DELETE FROM resources WHERE rID=" . $_POST["id"]);
                $db = $query->executeQuery();

            }

        }
        return $this->response;
    }

}

$a = new Delete();
$a->deleteResource();

?>