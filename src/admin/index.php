<?php
require '../php/dbquery.php';

if(!isset($_SESSION['user'])){
    header('location: login.php');
}
else {

$query = new Query("SELECT * FROM monitors");
$mon = $query->getQuery();

$floorReq1 = new Query("SELECT mID, name FROM monitors NATURAL JOIN monitorhaslabel WHERE lID = 3");
$groundFloor = $floorReq1->getQuery();

$floorReq2 = new Query("SELECT mID, name FROM monitors NATURAL JOIN monitorhaslabel WHERE lID = 4");
$firstFloor = $floorReq2->getQuery();

$floorReq3 = new Query("SELECT mID, name FROM monitors NATURAL JOIN monitorhaslabel WHERE lID = 5");
$secondFloor = $floorReq3->getQuery();

$floorReq4 = new Query("SELECT mID, name FROM monitors NATURAL JOIN monitorhaslabel WHERE lID = 6");
$thirdFloor = $floorReq4->getQuery();

//Retrieves all possible labels
$labelQuery = new Query("SELECT * FROM labels ");
$label = $labelQuery->getQuery();

//contains all monitors with labels
$monClassQuery = new Query("SELECT * FROM monitors NATURAL JOIN monitorhaslabel");
$monClass = $monClassQuery->getQuery();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Content Management System for CISPA monitors</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="This is a content management system which provides
a clean and intuitive system to manage the monitors at CISPA">
    <meta name="author" content="esha,thinh,jonas,marc">

    <!-- CSS FILE -->
    <link href="../main.css" rel="stylesheet">

</head>
<body>

<div id="wrapper">
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">CMS-K Admin v0.2</a>
        </div>
        <!-- /.navbar-header-->
        <a id="logoutButton" type="submit" class="btn btn-primary pull-right" href="login.php?logout=1">Logout</a>


        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="index.php"><i class="fa fa-television fa-fw"></i> Monitor Overview</a>
                    </li>
                    <li>
                        <a href="config.php"><i class="fa fa-folder fa-fw"></i> Resource Overview</a>
                    </li>


                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">

        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">Monitor Overview</h2>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!-- <div class="panel panel-default"> -->
            <!-- /.panel-heading -->
            <div id="monitorPanel" class="panel-body">
                <? $countMonitors = 0; ?>
                <div id="headingDiv">
                    <h3><i class="fa fa-bar-chart-o fa-fw"></i> Select the monitor you want to change</h3>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" id="dropdownMenu" data-toggle="dropdown">
                            <i class="fa fa-filter" aria-hidden="true"></i>
                            Filter
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu pull-right" role="menu">
                            <li><a id="filterAll" href="#">Show all</a></li>
                            <li class="divider"></li>
                            <? while($row = $label->fetch_assoc()){ ?>
                                <li>
                                <a class="filter" id="filterLabel-<? echo $row["lID"] ?>"><? echo $row["name"] ?></a>
                                </li> <?
                            }?>
                        </ul>
                    </div>
                    &nbsp;
                    <button id="selectAll" type="submit" class="btn btn-xs btn-primary logout">
                        <i id="selectAllDescription" class="fa fa-pencil" aria-hidden="true">  Select All</i>
                    </button>
                </div>
                <div class="monitorContainer">
                    <form action="config.php" id="monitorForm">
                        <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" href="#collapse1">
                                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                                            Ground Floor</a>
                                    </h4>
                                </div>
                                <div id="collapse1" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <fieldset class="monFieldset">
                                            <ul>
                                                <? while($row = $groundFloor->fetch_assoc()){ ?>
                                                   <? $monClassQuery = new Query("SELECT * FROM (SELECT lID FROM monitors NATURAL JOIN monitorhaslabel WHERE mID = ".($countMonitors-1).") ".
                                                        "AS labelid NATURAL JOIN labels WHERE lID < 3 OR lID > 6");
                                                    $monClass = $monClassQuery->getQuery();
                                                    $resCountQuery = new Query("SELECT COUNT(mID) AS counter FROM resources NATURAL JOIN monitorhasresource WHERE mID = ".$row["mID"]);
                                                    $resCount = $resCountQuery->getQuery();
                                                    $resTypeQuery = new Query("SELECT name, type FROM resources NATURAL JOIN monitorhasresource WHERE mID = ".$row["mID"]);
                                                    $resType = $resTypeQuery->getQuery();?>
                                                    <li class="monLi Ground Floor  <? while($label = $monClass->fetch_assoc()){ echo $label["name"];?> <?}?>" >
                                                        <label class="monitor_overview">
                                                            <input type="checkbox" name="m" value="<? echo $row["mID"] ?>" id="monInput-<?echo $countMonitors?>">
                                                            <i class="fa fa-television fa-4x" aria-hidden="true">
                                                                <? $counter = $resCount->fetch_assoc();
                                                                if ($counter["counter"] > 1) { ?>
                                                                    <i class="fa fa fa-file-o"></i>
                                                                    <!-- write resource names in hidden <p> -->
                                                                    <p class="resourceContent"><? while($type = $resType->fetch_assoc()){ echo $type["name"].", "; }?></p>
                                                                <? } else if ($counter["counter"] == 1) {
                                                                    $type = $resType->fetch_assoc();

                                                                    if ($type["type"] == "pdf") { ?>
                                                                        <i class="fa fa-file-pdf-o"></i>
                                                                    <? } else if ($type["type"] == "website") { ?>
                                                                        <i class="fa fa-file-word-o"></i>
                                                                    <? } else if ($type["type"] == "image") { ?>
                                                                        <i class="fa fa-picture-o"></i>
                                                                    <? } else if ($type["type"] == "rss") { ?>
                                                                        <i class="fa fa-rss"></i>
                                                                    <? } ?>
                                                                    <p class="resourceContent"><?echo $type["name"].", "?></p>
                                                                <? } else { ?>
                                                                    <p class="resourceContent"></p>
                                                               <? } ?>
                                                            </i>
                                                            <p class="monitorName"><? echo $row["name"] ?></p>
                                                        </label>
                                                    </li> <?
                                                    $countMonitors++;
                                                }?>
                                            </ul>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" href="#collapse2">
                                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                                            1st Floor</a>
                                    </h4>
                                </div>
                                <div id="collapse2" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <fieldset class="monFieldset">
                                            <ul>
                                                <? while($row = $firstFloor->fetch_assoc()){ ?>
                                            <? $monClassQuery = new Query("SELECT * FROM (SELECT lID FROM monitors NATURAL JOIN monitorhaslabel WHERE mID = " . ($countMonitors - 1) . ") " .
                                                "AS labelid NATURAL JOIN labels WHERE lID < 3 OR lID > 6");
                                            $monClass = $monClassQuery->getQuery();
                                            $resCountQuery = new Query("SELECT COUNT(mID) AS counter FROM resources NATURAL JOIN monitorhasresource WHERE mID = " . $row["mID"]);
                                            $resCount = $resCountQuery->getQuery();
                                            $resTypeQuery = new Query("SELECT name, type FROM resources NATURAL JOIN monitorhasresource WHERE mID = " . $row["mID"]);
                                            $resType = $resTypeQuery->getQuery(); ?>
                                                <li class="monLi 1st Floor  <? while ($label = $monClass->fetch_assoc()) {
                                                    echo $label["name"]; ?> <? } ?>">
                                                    <label class="monitor_overview">
                                                        <input type="checkbox" name="m" value="<? echo $row["mID"] ?>"
                                                               id="monInput-<? echo $countMonitors ?>">
                                                        <i class="fa fa-television fa-4x" aria-hidden="true">
                                                            <? $counter = $resCount->fetch_assoc();
                                                            if ($counter["counter"] > 1) { ?>
                                                                <i class="fa fa fa-file-o"></i>
                                                                <!-- write resource names in hidden <p> -->
                                                                <p class="resourceContent"><? while ($type = $resType->fetch_assoc()) {
                                                                        echo $type["name"] . ", ";
                                                                    } ?></p>
                                                            <? } else if ($counter["counter"] == 1) {
                                                                $type = $resType->fetch_assoc();
                                                                if ($type["type"] == "pdf") { ?>
                                                                    <i class="fa fa-file-pdf-o"></i>
                                                                <? } else if ($type["type"] == "website") { ?>
                                                                    <i class="fa fa-file-word-o"></i>
                                                                <? } else if ($type["type"] == "image") { ?>
                                                                    <i class="fa fa-picture-o"></i>
                                                                <? } else if ($type["type"] == "rss") { ?>
                                                                    <i class="fa fa-rss"></i>
                                                                <? } ?>
                                                                <p class="resourceContent"><? echo $type["name"] . ", " ?></p>
                                                            <? } else { ?>
                                                                <p class="resourceContent"></p>
                                                            <? } ?>
                                                            </i>
                                                            <p class="monitorName"><? echo $row["name"] ?></p>
                                                        </label>
                                                    </li><?
                                                    $countMonitors++;
                                                }?>
                                            </ul>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" href="#collapse3">
                                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                                            2nd Floor</a>
                                    </h4>
                                </div>
                                <div id="collapse3" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <fieldset class="monFieldset">
                                            <ul>
                                                <? while($row = $secondFloor->fetch_assoc()){ ?>
                                                    <? $monClassQuery = new Query("SELECT * FROM (SELECT lID FROM monitors NATURAL JOIN monitorhaslabel WHERE mID = ".($countMonitors-1).") ".
                                                        "AS labelid NATURAL JOIN labels WHERE lID < 3 OR lID > 6");
                                                    $monClass = $monClassQuery->getQuery();
                                                    $resCountQuery = new Query("SELECT COUNT(mID) AS counter FROM resources NATURAL JOIN monitorhasresource WHERE mID = ".$row["mID"]);
                                                    $resCount = $resCountQuery->getQuery();
                                                    $resTypeQuery = new Query("SELECT name, type FROM resources NATURAL JOIN monitorhasresource WHERE mID = ".$row["mID"]);
                                                    $resType = $resTypeQuery->getQuery();?>
                                                <li class="monLi 2nd Floor  <? while($label = $monClass->fetch_assoc()){ echo $label["name"];?> <?}?>" >
                                                        <label class="monitor_overview">
                                                            <input type="checkbox" name="m" value="<? echo $row["mID"] ?>" id="monInput-<?echo $countMonitors?>">
                                                            <i class="fa fa-television fa-4x" aria-hidden="true">
                                                                <? $counter = $resCount->fetch_assoc();
                                                                if ($counter["counter"] > 1) { ?>
                                                                    <i class="fa fa fa-file-o"></i>
                                                                    <!-- write resource names in hidden <p> -->
                                                                    <p class="resourceContent"><? while($type = $resType->fetch_assoc()){ echo $type["name"].", "; }?></p>
                                                                <? } else if ($counter["counter"] == 1) {
                                                                    $type = $resType->fetch_assoc();
                                                                    if ($type["type"] == "pdf") { ?>
                                                                        <i class="fa fa-file-pdf-o"></i>
                                                                    <? } else if ($type["type"] == "website") { ?>
                                                                        <i class="fa fa-file-word-o"></i>
                                                                    <? } else if ($type["type"] == "image") { ?>
                                                                        <i class="fa fa-picture-o"></i>
                                                                    <? } else if ($type["type"] == "rss") { ?>
                                                                        <i class="fa fa-rss"></i>
                                                                    <? } ?>
                                                                    <p class="resourceContent"><?echo $type["name"].", "?></p>
                                                                <? } else { ?>
                                                                <p class="resourceContent"></p>
                                                                <? } ?>
                                                            </i>
                                                            <p class="monitorName"><? echo $row["name"] ?></p>
                                                        </label>
                                                    </li><?
                                                    $countMonitors++;
                                                }?>
                                            </ul>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" href="#collapse4">
                                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                                            3rd Floor</a>
                                    </h4>
                                </div>
                                <div id="collapse4" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <fieldset class="monFieldset">
                                            <ul>
                                                <? while($row = $thirdFloor->fetch_assoc()){ ?>
                                                    <? $monClassQuery = new Query("SELECT * FROM (SELECT lID FROM monitors NATURAL JOIN monitorhaslabel WHERE mID = ".($countMonitors-1).") ".
                                                        "AS labelid NATURAL JOIN labels WHERE lID < 3 OR lID > 6");
                                                    $monClass = $monClassQuery->getQuery();
                                                    $resCountQuery = new Query("SELECT COUNT(mID) AS counter FROM resources NATURAL JOIN monitorhasresource WHERE mID = ".$row["mID"]);
                                                    $resCount = $resCountQuery->getQuery();
                                                    $resTypeQuery = new Query("SELECT name, type FROM resources NATURAL JOIN monitorhasresource WHERE mID = ".$row["mID"]);
                                                    $resType = $resTypeQuery->getQuery();?>
                                                <li class="monLi 3rd Floor  <? while($label = $monClass->fetch_assoc()){ echo $label["name"];?> <?}?>" >
                                                        <label class="monitor_overview">
                                                            <input type="checkbox" name="m" value="<? echo $row["mID"] ?>" id="monInput-<?echo $countMonitors?>">
                                                            <i class="fa fa-television fa-4x" aria-hidden="true">
                                                                <? $counter = $resCount->fetch_assoc();
                                                                if ($counter["counter"] > 1) { ?>
                                                                    <i class="fa fa fa-file-o"></i>
                                                                    <!-- write resource names in hidden <p> -->
                                                                    <p class="resourceContent"><? while($type = $resType->fetch_assoc()){ echo $type["name"].", "; }?></p>
                                                                <? } else if ($counter["counter"] == 1) {
                                                                    $type = $resType->fetch_assoc();
                                                                    if ($type["type"] == "pdf") { ?>
                                                                        <i class="fa fa-file-pdf-o"></i>
                                                                    <? } else if ($type["type"] == "website") { ?>
                                                                        <i class="fa fa-file-word-o"></i>
                                                                    <? } else if ($type["type"] == "image") { ?>
                                                                        <i class="fa fa-picture-o"></i>
                                                                    <? } else if ($type["type"] == "rss") { ?>
                                                                        <i class="fa fa-rss"></i>
                                                                    <? } ?>
                                                                    <p class="resourceContent"><?echo $type["name"].", "?></p>
                                                                <? } else { ?>
                                                                <p class="resourceContent"></p>
                                                                <? } ?>
                                                            </i>
                                                            <p class="monitorName"><? echo $row["name"] ?></p>
                                                        </label>
                                                    </li><?
                                                    $countMonitors++;
                                                }?>
                                            </ul>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="previewPanel" class="panel panel-default">
                    <div class="panel-body">
                        <h2>Details</h2>
                        <p id="monDetails"></p>
                        <button id="editButton" type="submit" onclick="$('#monitorForm').submit()" class="btn btn-large btn-primary logout" href="#">
                            <i class="fa fa-pencil" aria-hidden="true"> Change Content</i>
                        </button>
                    </div>
                </div>
            </div>
        <!-- </div> -->
        <!-- /.panel-body -->

        <!-- Alerts -->
        <div class="alert alert-success" id="success-alert">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <h4 class="alert-heading glyphicon glyphicon-ok"> Success!</h4>
            <p>The system has updated the resource(s) of the monitor(s)</p>
        </div>
        <div class="alert alert-warning" id="warning-alert">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <h4 class="alert-heading">Warning!</h4>
            <p>Something went wrong there</p>
        </div>
        <!-- /.Alerts -->

    </div>

</div>

<!-- Main JS Script -->
<script src="../libs/jquery-3.2.1.js"></script>
<script src="../libs/dropzone.js"></script>
<script src="../libs/bootstrap.js"></script>
<script src="../libs/vendor/datetimer/moment.js"></script>
<script src="../libs/vendor/datetimer/bootstrap-datetimepicker.min.js"></script>
<script src="../js/modules.min.js"></script>
<script src="../js/main.js"></script>
</body>
</html>
<? } ?>