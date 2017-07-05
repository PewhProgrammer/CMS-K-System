<?php
require "dbquery.php";

/**
 * Created by PhpStorm.
 * User: Jonas
 * Date: 05.07.2017
 * Time: 18:40
 */
class ContentManager extends Query
{
    private $mID;

    function __construct()
    {
        //Check if keys exists
        if (isset($_POST["mID"]))
        {
            $this->mID = $_POST["mID"];
            $this->response = new Response(200, "Success");
        }
        else{
            $this->response = new Response(400, "Got no parameters.");
        }

    }

    public function getContent(){
        $query = new Query("SELECT * FROM resources, monitorhasresource WHERE monitorhasresource.mID ='" . $this->mID . "' AND resources.rID = monitorhasresource.rID");
        $res = $query->getQuery();

        $typeArr = ["pdf" => ["no" => 0, "path" => []], "image" => ["no" => 0, "path" => []], "website" => ["no" => 0, "path" => []], "rss" => ["no" => 0, "path" => []], "mensa" => 0, "bus" => 0];

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
                    break;
                default:
                    echo "Error: Resource has wrong file type.";
            }
        }

        echo json_encode($typeArr);
    }
}

$a = new ContentManager();
$a->getContent();

?>
