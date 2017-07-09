<?php

require "ServerWrapper.php";

class Delete extends ServerWrapper
{
    private $id = 0;

    function __construct()
    {
        //Check if param exists
        if (isset($_POST["id"]))
        {
            $this->id = $_POST["id"];
            $this->execute();
        }
        else{
           echo "No params set";
        }

    }

    public function execute(){

        $this->query = new Query("SELECT * FROM resources WHERE rID=" . $this->id);
        $res = $this->query->getQuery();

        while ($row = $res->fetch_assoc()) {

            if ($row["type"] == "pdf" || $row["type"] == "image"){ //delete also files from server
                unlink($row["data"]);
            }
        }

        $this->query = new Query("DELETE FROM resources WHERE rID=" . $this->id);
        $this->query->executeQuery();

        echo $this->query->getResponse();
    }

}

$a = new Delete();

?>