<?php
require 'php/dbconnect.php';
$mon = $_GET["m"];

$query = new Query("SELECT * FROM resources, monitorhasresource WHERE monitorhasresource.mID ='" . $mon . "' AND resources.rID = monitorhasresource.rID");
$res = $query->getQuery();

$typeArr = ["pdf" => ["no" => 0, "path" => []], "image" => ["no" => 0, "path" => []], "website" => ["no" => 0, "path" => []], "rss" => ["no" => 0, "path" => []], "mensa" => 0, "bus" => 0];

while ($row = $res->fetch_assoc()) {
    echo $row["name"];

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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="main.css">
    <meta charset="UTF-8">
    <title>CMS-K</title>
</head>

<body>
Monitor page will be created here.
<a href="./admin/">Go to admin panel</a>

<?php if ($typeArr["website"]["no"] == 1) { ?>
    <iframe
            height="100%"
            width="100%"
            src="<?php echo $typeArr["website"]["path"][0]?>"
            frameborder="0"
            scrolling="no"
    ></iframe>
<?php } else if ($typeArr["pdf"]["no"] == 1) { ?>
    <iframe
            height="100%"
            width="100%"
            src="<?php echo $typeArr["pdf"]["path"][0]?>"
            frameborder="0"
            scrolling="no"
    ></iframe>
<?php } else if ($typeArr["image"]["no"] == 1) { ?>
    <iframe
            height="100%"
            width="100%"
            src="<?php echo $typeArr["image"]["path"][0]?>"
            frameborder="0"
            scrolling="no"
    ></iframe>
<?php } else if ($typeArr["rss"]["no"] == 1) { ?>
   Show RSS feed
<?php } ?>

</body>

</html>
