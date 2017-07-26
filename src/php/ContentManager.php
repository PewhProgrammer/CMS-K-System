<?php
require_once("ServerWrapper.php");

/**
 * Created by PhpStorm.
 * User: Jonas
 * Date: 05.07.2017
 * Time: 18:40
 */

class ContentManager extends ServerWrapper
{
    private $mID;

    function __construct()
    {
        //Check if keys exists
        if (isset($_POST["mID"]))
        {
            $this->mID = $_POST["mID"];
        }
    }

    /**
     * @return Response The return value shall be a Response
     */
    public function execute()
    {
        if(!$this->verify()) return new Response('404','No mID found');

        $this->query = new Query("SELECT * FROM resources, monitorhasresource WHERE monitorhasresource.mID ='" . $this->mID . "' AND resources.rID = monitorhasresource.rID");
        $res = $this->query->getQuery();

        $typeArr = ["pdf" => ["no" => 0, "path" => []], "image" => ["no" => 0, "path" => []], "website" => ["no" => 0, "path" => []], "rss" => ["no" => 0, "path" => []], "mensa" => 0, "bus" => 0,"caldav" => ["no" => 0, "path" => []]];

        $now = new DateTime(null, new DateTimeZone('Europe/Berlin'));
        $nowTS = $now->getTimestamp() + $now->getOffset();

        while ($row = $res->fetch_assoc()) {

            $until = new DateTime($row["until"], new DateTimeZone('Europe/Berlin'));
            $untilTS = $until->getTimestamp() + $until->getOffset();

            if ($nowTS < $untilTS){ //check if resource is still attached first
                switch ($row["type"]) {
                    case "pdf":
                        $typeArr["pdf"]["no"]++;
                        array_push($typeArr["pdf"]["path"], $row["data"]);
                        break;
                    case "image":
                        $typeArr["image"]["no"]++;
                        array_push($typeArr["image"]["path"], $row["data"]);
                        break;
                    case "website":
                        $typeArr["website"]["no"]++;
                        array_push($typeArr["website"]["path"], $row["data"]);
                        break;
                    case "rss":
                        $typeArr["rss"]["no"]++;
                        array_push($typeArr["rss"]["path"], $row["data"]);
                        break;
                    case "mensa":
                        $typeArr["mensa"]++;
                        break;
                    case "bus":
                        $typeArr["bus"]++;
                        break;
                    case "caldav":
                        $typeArr["caldav"]["no"]++;
                        array_push($typeArr["caldav"]["path"], $row["data"]);
                        break;
                }
            }
            else { //delete all attached resources for that monitor
                $this->query = new Query("DELETE FROM monitorhasresource WHERE mID ='" . $this->mID . "'");
                $res = $this->query->executeQuery();
                break;
            }


        }

        //echo json_encode($typeArr);
        $this->query->setResponse(200,json_encode($typeArr));
        return $this->query->getResponse();
    }

    private function verify(){
        if($this->mID === null)
        {
           return false;
        }
        $this->query = new Query("SELECT * FROM `monitors` WHERE mID =" . $this->mID);
        $res = $this->query->getQuery();
        $break = true;
        while ($row = $res->fetch_assoc()) {
            $break = false;
        }
        if($break) return false;
        //echo 'rows:'.json_encode($res->fetch_assoc());
        return true;
    }

    public function initTestData($id){
        $this->mID = $id;
    }
}

$a = new ContentManager();
echo $a->execute();

?>
