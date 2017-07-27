<?php
require '../php/Query.php';

if(session_status()!=PHP_SESSION_ACTIVE)
session_start();
$chk = new Query("SELECT * FROM users WHERE name='" .$_SESSION['user']. "'");
$res=$chk->getQuery();
$sess = $res->fetch_array()['session_id'];
if(!isset($_SESSION['user'])) {
    header('location: login.php');
    exit();
}elseif ($sess!=$_COOKIE['sess']){
    setcookie('sess','val',time()-(120),"/");
    session_unset();
    session_destroy();
    header('location: login.php?error=1');
}

else {

$query = new Query("SELECT * FROM monitors WHERE new = 0");
$mon = $query->getQuery();

$floorReq1 = new Query("SELECT mID, name FROM monitors NATURAL JOIN monitorhaslabel WHERE lID = 3 AND new = 0");
$groundFloor = $floorReq1->getQuery();

$floorReq2 = new Query("SELECT mID, name FROM monitors NATURAL JOIN monitorhaslabel WHERE lID = 4 AND new = 0");
$firstFloor = $floorReq2->getQuery();

$floorReq3 = new Query("SELECT mID, name FROM monitors NATURAL JOIN monitorhaslabel WHERE lID = 5 AND new = 0");
$secondFloor = $floorReq3->getQuery();

$floorReq4 = new Query("SELECT mID, name FROM monitors NATURAL JOIN monitorhaslabel WHERE lID = 6 AND new = 0");
$thirdFloor = $floorReq4->getQuery();

//Retrieves all possible labels
$labelQuery = new Query("SELECT * FROM labels ");
$label = $labelQuery->getQuery();

//contains all monitors with labels
$monClassQuery = new Query("SELECT * FROM monitors NATURAL JOIN monitorhaslabel");
$monClass = $monClassQuery->getQuery();

//contains all unregistered monitors
$newMonQuery = new Query("SELECT * FROM monitors WHERE new <> 0");
$newMon = $newMonQuery->getQuery();

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
        <a id="logoutButton" type="submit" class="btn btn-primary pull-right" href="login.php?logout=1"><i class="fa fa-sign-out" aria-hidden="true"></i>
            Logout</a>

        <ul class="nav navbar-top-links navbar-right">
            <!-- /.dropdown -->
            <li class="dropdown" id="newMon">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                    <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i> <span class="badge"><?echo mysqli_num_rows($newMon)?></span>
                </a>
                <ul class="dropdown-menu dropdown-alerts">
                    <? while($row = $newMon->fetch_assoc()){ ?>
                        <li>
                            <a href="#" class='unregisteredMonitors' id="newMon-<? echo $row['mID']?>" data-value="<? echo $row['mID']?>" data-time="<? echo $row['new']?>">
                                <div>
                                    <i class="fa fa-television fa-fw"> </i> New monitor with id <? echo $row['mID']?>
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <?
                    }?>
                </ul>
                <!-- /.dropdown-alerts -->
            </li>
            <!-- /.dropdown -->
        </ul>

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
                                <a class="filter option" id="filterLabel-<? echo $row["lID"] ?>"><? echo $row["name"] ?></a>
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
                                                   <? $monClassQuery = new Query("SELECT * FROM (SELECT lID FROM monitors NATURAL JOIN monitorhaslabel WHERE mID = ".$row["mID"].") ".
                                                        "AS labelid NATURAL JOIN labels WHERE lID < 3 OR lID > 6");
                                                    $monClass = $monClassQuery->getQuery();
                                                    $resCountQuery = new Query("SELECT COUNT(mID) AS counter FROM resources NATURAL JOIN monitorhasresource WHERE mID = ".$row["mID"]);
                                                    $resCount = $resCountQuery->getQuery();
                                                    $resTypeQuery = new Query("SELECT name, type FROM resources NATURAL JOIN monitorhasresource WHERE mID = ".$row["mID"]);
                                                    $resType = $resTypeQuery->getQuery();?>
                                                    <li class="monLi filter Ground Floor <? while($label = $monClass->fetch_assoc()){ echo $label["name"];?> <?}?>" >
                                                        <label class="monitor_overview">
                                                            <input type="checkbox" name="m" value="<? echo $row["mID"] ?>" id="monInput-<?echo $countMonitors?>">
                                                            <i class="fa fa-television fa-4x" aria-hidden="true">
                                                                <? $counter = $resCount->fetch_assoc();
                                                                if ($counter["counter"] > 1) { ?>
                                                                    <i class="fa fa-files-o" aria-hidden="true"></i>
                                                                    <!-- write resource names in hidden <p> -->
                                                                    <p class="resourceContent"><? while($type = $resType->fetch_assoc()){ echo $type["name"].", "; }?></p>
                                                                <? } else if ($counter["counter"] == 1) {
                                                                    $type = $resType->fetch_assoc();

                                                                    if ($type["type"] == "pdf") { ?>
                                                                        <i class="fa fa-file-pdf-o"></i>
                                                                    <? } else if ($type["type"] == "website") { ?>
                                                                        <i class="fa fa-globe" aria-hidden="true"></i>
                                                                    <? } else if ($type["type"] == "image") { ?>
                                                                        <i class="fa fa-picture-o"></i>
                                                                    <? } else if ($type["type"] == "rss") { ?>
                                                                        <i class="fa fa-rss"></i>
                                                                    <? } else if ($type["type"] == "caldav") { ?>
                                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                    <? } else if ($type["type"] == "mensa") { ?>
                                                                        <i class="fa fa-cutlery" aria-hidden="true"></i>
                                                                    <? } else if ($type["type"] == "bus") { ?>
                                                                        <i class="fa fa-bus" aria-hidden="true"></i>
                                                                    <? } ?>
                                                                    <p class="resourceContent"><?echo $type["name"].", "?></p>
                                                                <? } else { ?>
                                                                    <p class="resourceContent"></p>
                                                               <? } ?>
                                                            </i>
                                                            <p class="monitorName"><? echo $row["name"] ?></p>
                                                            <p class="monitorID" style="display: none"><? echo $row["mID"] ?></p>
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
                                            <? $monClassQuery = new Query("SELECT * FROM (SELECT lID FROM monitors NATURAL JOIN monitorhaslabel WHERE mID = " . $row["mID"] . ") " .
                                                "AS labelid NATURAL JOIN labels WHERE lID < 3 OR lID > 6");
                                            $monClass = $monClassQuery->getQuery();
                                            $resCountQuery = new Query("SELECT COUNT(mID) AS counter FROM resources NATURAL JOIN monitorhasresource WHERE mID = " . $row["mID"]);
                                            $resCount = $resCountQuery->getQuery();
                                            $resTypeQuery = new Query("SELECT name, type FROM resources NATURAL JOIN monitorhasresource WHERE mID = " . $row["mID"]);
                                            $resType = $resTypeQuery->getQuery(); ?>
                                                <li class="monLi filter 1st Floor <? while ($label = $monClass->fetch_assoc()) {
                                                    echo $label["name"]; ?> <? } ?>">
                                                    <label class="monitor_overview">
                                                        <input type="checkbox" name="m" value="<? echo $row["mID"] ?>"
                                                               id="monInput-<? echo $countMonitors ?>">
                                                        <i class="fa fa-television fa-4x" aria-hidden="true">
                                                            <? $counter = $resCount->fetch_assoc();
                                                            if ($counter["counter"] > 1) { ?>
                                                                <i class="fa fa-files-o" aria-hidden="true"></i>
                                                                <!-- write resource names in hidden <p> -->
                                                                <p class="resourceContent"><? while ($type = $resType->fetch_assoc()) {
                                                                        echo $type["name"] . ", ";
                                                                    } ?></p>
                                                            <? } else if ($counter["counter"] == 1) {
                                                                $type = $resType->fetch_assoc();
                                                                if ($type["type"] == "pdf") { ?>
                                                                    <i class="fa fa-file-pdf-o"></i>
                                                                <? } else if ($type["type"] == "website") { ?>
                                                                    <i class="fa fa-globe" aria-hidden="true"></i>
                                                                <? } else if ($type["type"] == "image") { ?>
                                                                    <i class="fa fa-picture-o"></i>
                                                                <? } else if ($type["type"] == "rss") { ?>
                                                                    <i class="fa fa-rss"></i>
                                                                <? } else if ($type["type"] == "caldav") { ?>
                                                                    <i class="fa fa-calendar"></i>
                                                                <? } else if ($type["type"] == "mensa") { ?>
                                                                    <i class="fa fa-cutlery" aria-hidden="true"></i>
                                                                <? } else if ($type["type"] == "bus") { ?>
                                                                    <i class="fa fa-bus" aria-hidden="true"></i>
                                                                <? } ?>
                                                                <p class="resourceContent"><? echo $type["name"] . ", " ?></p>
                                                            <? } else { ?>
                                                                <p class="resourceContent"></p>
                                                            <? } ?>
                                                            </i>
                                                            <p class="monitorName"><? echo $row["name"] ?></p>
                                                            <p class="monitorID" style="display: none"><? echo $row["mID"] ?></p>
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
                                                    <? $monClassQuery = new Query("SELECT * FROM (SELECT lID FROM monitors NATURAL JOIN monitorhaslabel WHERE mID = ".$row["mID"].") ".
                                                        "AS labelid NATURAL JOIN labels WHERE lID < 3 OR lID > 6");
                                                    $monClass = $monClassQuery->getQuery();
                                                    $resCountQuery = new Query("SELECT COUNT(mID) AS counter FROM resources NATURAL JOIN monitorhasresource WHERE mID = ".$row["mID"]);
                                                    $resCount = $resCountQuery->getQuery();
                                                    $resTypeQuery = new Query("SELECT name, type FROM resources NATURAL JOIN monitorhasresource WHERE mID = ".$row["mID"]);
                                                    $resType = $resTypeQuery->getQuery();?>
                                                <li class="monLi filter 2nd Floor <? while($label = $monClass->fetch_assoc()){ echo $label["name"];?> <?}?>" >
                                                        <label class="monitor_overview">
                                                            <input type="checkbox" name="m" value="<? echo $row["mID"] ?>" id="monInput-<?echo $countMonitors?>">
                                                            <i class="fa fa-television fa-4x" aria-hidden="true">
                                                                <? $counter = $resCount->fetch_assoc();
                                                                if ($counter["counter"] > 1) { ?>
                                                                    <i class="fa fa-files-o" aria-hidden="true"></i>
                                                                    <!-- write resource names in hidden <p> -->
                                                                    <p class="resourceContent"><? while($type = $resType->fetch_assoc()){ echo $type["name"].", "; }?></p>
                                                                <? } else if ($counter["counter"] == 1) {
                                                                    $type = $resType->fetch_assoc();
                                                                    if ($type["type"] == "pdf") { ?>
                                                                        <i class="fa fa-file-pdf-o"></i>
                                                                    <? } else if ($type["type"] == "website") { ?>
                                                                        <i class="fa fa-globe" aria-hidden="true"></i>
                                                                    <? } else if ($type["type"] == "image") { ?>
                                                                        <i class="fa fa-picture-o"></i>
                                                                    <? } else if ($type["type"] == "rss") { ?>
                                                                        <i class="fa fa-rss"></i>
                                                                    <? } else if ($type["type"] == "caldav") { ?>
                                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                    <? } else if ($type["type"] == "mensa") { ?>
                                                                        <i class="fa fa-cutlery" aria-hidden="true"></i>
                                                                    <? } else if ($type["type"] == "bus") { ?>
                                                                        <i class="fa fa-bus" aria-hidden="true"></i>
                                                                    <? } ?>
                                                                    <p class="resourceContent"><?echo $type["name"].", "?></p>
                                                                <? } else { ?>
                                                                <p class="resourceContent"></p>
                                                                <? } ?>
                                                            </i>
                                                            <p class="monitorName"><? echo $row["name"] ?></p>
                                                            <p class="monitorID" style="display: none"><? echo $row["mID"] ?></p>
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
                                                    <? $monClassQuery = new Query("SELECT * FROM (SELECT lID FROM monitors NATURAL JOIN monitorhaslabel WHERE mID = ".$row["mID"].") ".
                                                        "AS labelid NATURAL JOIN labels WHERE lID < 3 OR lID > 6");
                                                    $monClass = $monClassQuery->getQuery();
                                                    $resCountQuery = new Query("SELECT COUNT(mID) AS counter FROM resources NATURAL JOIN monitorhasresource WHERE mID = ".$row["mID"]);
                                                    $resCount = $resCountQuery->getQuery();
                                                    $resTypeQuery = new Query("SELECT name, type, until FROM resources NATURAL JOIN monitorhasresource WHERE mID = ".$row["mID"]);
                                                    $resType = $resTypeQuery->getQuery();?>
                                                <li class="monLi filter 3rd Floor <? while($label = $monClass->fetch_assoc()){ echo $label["name"];?> <?}?>" >
                                                        <label class="monitor_overview">
                                                            <input type="checkbox" name="m" value="<? echo $row["mID"] ?>" id="monInput-<?echo $countMonitors?>">
                                                            <i class="fa fa-television fa-4x" aria-hidden="true">
                                                                <? $counter = $resCount->fetch_assoc();
                                                                if ($counter["counter"] > 1) { ?>
                                                                    <i class="fa fa-files-o" aria-hidden="true"></i>
                                                                    <!-- write resource names in hidden <p> -->
                                                                    <p class="resourceContent"><? while($type = $resType->fetch_assoc()){ echo $type["name"].", "; }?></p>
                                                                <? } else if ($counter["counter"] == 1) {
                                                                    $type = $resType->fetch_assoc();
                                                                    if ($type["type"] == "pdf") { ?>
                                                                        <i class="fa fa-file-pdf-o"></i>
                                                                    <? } else if ($type["type"] == "website") { ?>
                                                                        <i class="fa fa-globe" aria-hidden="true"></i>
                                                                    <? } else if ($type["type"] == "image") { ?>
                                                                        <i class="fa fa-picture-o"></i>
                                                                    <? } else if ($type["type"] == "rss") { ?>
                                                                        <i class="fa fa-rss"></i>
                                                                    <? } else if ($type["type"] == "caldav") { ?>
                                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                    <? } else if ($type["type"] == "mensa") { ?>
                                                                        <i class="fa fa-cutlery" aria-hidden="true"></i>
                                                                    <? } else if ($type["type"] == "bus") { ?>
                                                                        <i class="fa fa-bus" aria-hidden="true"></i>
                                                                    <? } ?>
                                                                    <p class="resourceContent"><?echo $type["name"].", "?></p>
                                                                <? } else { ?>
                                                                <p class="resourceContent"></p>
                                                                <? } ?>
                                                            </i>
                                                            <p class="monitorName"><? echo $row["name"] ?></p>
                                                            <p class="monitorID" style="display: none"><? echo $row["mID"] ?></p>
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
                        <div class="dropup">
                            <button class="btn btn-primary btn-large dropdown-toggle" type="button" data-toggle="dropdown">Add Label
                                <span class="caret"></span></button>
                            <ul class="dropdown-menu" style="width: 200px;">
                                <? $label = $labelQuery->getQuery();
                                while ($row = $label->fetch_assoc()) { ?>
                                    <li><a href="#"><?echo $row["name"]?></li>
                               <? } ?>
                                <li>
                                    <input class="form-control" style="display: inline-block; float: left; width: 80%" placeholder="New Label..." name="newlabel" type="text" autofocus>
                                    <button id="submitLabelButton" class="btn btn-primary" type="submit" method="post"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <!-- </div> -->
        <!-- /.panel-body -->

        <!-- Register New Monitor Modal -->
        <div class="modal fade" id="newMonitorModal" tabindex="1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Registering a new monitor</h4>
                    </div>
                    <div class="modal-body">
                        <p>A new monitor with <code class="highlighter-rouge">id <span id="newMonitorIDModal"></span></code> will be registered in the database. <br> Complete the following form.</p>
                        <div class="row">&nbsp;</div>
                        <label for="url" id="urlHeader">Monitor Display Name:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="newMonitorInput" aria-label="...">
                        </div><!-- /input-group -->
                        <div class="row">&nbsp;</div>
                        <label for="url" id="urlHeader">Location:</label>
                        <div class="input-group-btn">
                            <button type="button" id='dropdownMenuNewMon' class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                 Ground Floor <i class="fa fa-caret-down"></i> </button>
                            <ul id="newMonPrefixDrop" class="dropdown-menu">
                                <li><a href="#" data-value="3">Ground Floor </a></li>
                                <li><a href="#" data-value="4">1st Floor </a></li>
                                <li><a href="#" data-value="5">2nd Floor </a></li>
                                <li><a href="#" data-value="6">3rd Floor </a></li>
                            </ul>
                        </div><!-- /btn-group -->

                        <div class="row">&nbsp;</div>
                        <label for="url" id="urlHeader">Monitor Alignment:</label>
                        <div class="input-group-btn">
                            <button type="button" id='dropdownMenuAlignment' class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">vertical</button>
                        </div><!-- /btn-group -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button id="newMonitorSubmit" type="button" class="btn btn-primary">Confirm</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alerts -->
        <div class="alert alert-success" id="success-alert">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <h4 class="alert-heading glyphicon glyphicon-ok"> Success!</h4>
            <p id="alertSuccessText"></p>
        </div>
        <div class="alert alert-warning" id="warning-alert">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <h4 class="alert-heading">Warning!</h4>
            <p id="alertWarningText">Something went wrong there</p>
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