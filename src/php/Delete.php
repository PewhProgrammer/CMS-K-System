<?php

require_once("Events.php");

class Delete extends Events
{
    private $id = 0;

    function __construct(){}

    public function execute(){
        if(isset($_POST["id"])) {
            if (!$this->verify()) return new Response(404, 'The id was wrong');
            $this->query = new Query("SELECT * FROM resources WHERE rID=" . $this->id);
            $res = $this->query->getQuery();

            while ($row = $res->fetch_assoc()) {

                if ($row["type"] == "pdf" || $row["type"] == "image") { //delete also files from server
                    if (file_exists($row["data"])) {
                        unlink($row["data"]);
                    } else {
                        $this->query = new Query("DELETE FROM monitorhasresource WHERE rID=" . $this->id);
                        $this->query->executeQuery();

                        $this->query = new Query("DELETE FROM resources WHERE rID=" . $this->id);
                        $this->query->executeQuery();

                        return new Response(404, 'File not found on the webserver');
                    }
                }
            }

            $this->query = new Query("DELETE FROM monitorhasresource WHERE rID=" . $this->id);
            $this->query->executeQuery();

            $this->query = new Query("DELETE FROM resources WHERE rID=" . $this->id);
            $this->query->executeQuery();

            return $this->query->getResponse();
        } else if(isset($_POST["mID"])) {
            $this->query = new Query("DELETE FROM monitorhaslabel WHERE mID=".$_POST['mID']." AND lID=".$_POST['lID']);
            $this->query->executeQuery();
            return $this->query->getResponse();
        } else if(isset($_POST["labID"])) {
            $this->query = new Query("DELETE FROM labels WHERE lID=".$_POST['labID']);
            $this->query->executeQuery();
            return $this->query->getResponse();
        }
    }

    /**
     * Checks if the params are set correctly
     * @return bool The return value shall be a Boolean
     */
    protected function verify()
    {
        //Check if param exists
        if (isset($_POST["id"]))
        {
            $this->id = $_POST["id"];
            return true;
        } else if (isset($_POST["mID"]))
        {
            $this->id = $_POST["mID"];
            return true;
        } else if (isset($_POST["labID"]))
        {
            $this->id = $_POST["labID"];
            return true;
        }
        return false;
    }
}

$a = new Delete();
echo $a->execute();

?>