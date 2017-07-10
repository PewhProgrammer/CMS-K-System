<?php
require "ServerWrapper.php";

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
            $this->execute();
            return;
        }

        echo "Wrong Param Format.";

    }

    /**
     * @return Response The return value shall be a Response
     */
    public function execute()
    {
        $this->query = new Query("SELECT * FROM resources, monitorhasresource WHERE monitorhasresource.mID ='" . $this->mID . "' AND resources.rID = monitorhasresource.rID");
        $res = $this->query->getQuery();

        $typeArr = ["pdf" => ["no" => 0, "path" => []], "image" => ["no" => 0, "path" => []], "website" => ["no" => 0, "path" => []], "rss" => ["no" => 0, "path" => []], "mensa" => 0, "bus" => 0,"caldav" => ["no" => 0, "path" => []]];

        while ($row = $res->fetch_assoc()) {
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
                case "caldav":
                    $typeArr["caldav"]["no"]++;
                    array_push($typeArr["caldav"]["path"], $row["data"]);
                    break;
                default:
                    echo "Error: Resource has wrong file type.";
            }
        }

        echo json_encode($typeArr);
        return $this->query->getResponse();
    }
}

$a = new ContentManager();

?>
