<?php
require '../php/dbconnect.php';

$query = new Query("SELECT * FROM monitors");
$mon = $query->getQuery();

$floorReq1 = new Query("SELECT * FROM monitors NATURAL JOIN monitorhaslabel WHERE lID = 3");
$groundFloor = $floorReq1->getQuery();

$floorReq2 = new Query("SELECT * FROM monitors NATURAL JOIN monitorhaslabel WHERE lID = 4");
$firstFloor = $floorReq2->getQuery();

$floorReq3 = new Query("SELECT * FROM monitors NATURAL JOIN monitorhaslabel WHERE lID = 5");
$secondFloor = $floorReq3->getQuery();

$floorReq4 = new Query("SELECT * FROM monitors NATURAL JOIN monitorhaslabel WHERE lID = 6");
$thirdFloor = $floorReq4->getQuery();

//Retrieves all possible labels
$labelQuery = new Query("SELECT * FROM labels WHERE lID < 3 || lID > 6");
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
            <a class="navbar-brand" href="index.html">CMS-K Admin v0.1</a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
            <!-- right nav header content -->
            <button id="selectAll" type="submit" class="btn btn-large btn-primary logout">
                <i id="selectAllDescription" class="fa fa-pencil" aria-hidden="true">  Select all</i>
            </button>
        </ul>


        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search">
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        <!-- /input-group -->
                    </li>
                    <li>
                        <a href="index.html"><i class="fa fa-television fa-fw"></i> Monitor Overview</a>
                    </li>
                    <li>
                        <a href="index.html"><i class="fa fa-folder fa-fw"></i> Resource Overview</a>
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
                <h1 class="page-header">Monitor Overview</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> All monitors in the CISPA building
            </div>
            <!-- /.panel-heading -->
            <div id="monitorPanel" class="panel-body">
                <? $countMonitors = 0; ?>
                <div id="headingDiv">
                    <h3>Select the monitor you want to change</h3>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                            Filter
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu pull-right" role="menu">
                            <li><a href="#">Filter</a></li>
                            <li class="divider"></li>
                            <? while($row = $label->fetch_assoc()){ ?>
                                <li>
                                <a class="filter" id="filterLabel-<? echo $row["lID"] ?>"><? echo $row["name"] ?></a>
                                </li> <?
                                $countMonitors++;
                            }?>
                        </ul>
                    </div>
                </div>
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
                                    <fieldset>
                                        <ul>
                                            <? while($row = $groundFloor->fetch_assoc()){ ?>
                                               <? $monClassQuery = new Query("SELECT * FROM (SELECT lID FROM monitors NATURAL JOIN monitorhaslabel WHERE mID = ".($countMonitors-1).") ".
                                                    "AS labelid NATURAL JOIN labels WHERE lID < 3 OR lID > 6");
                                                $monClass = $monClassQuery->getQuery(); ?>
                                                <li class="monLi groundFloor  <? while($label = $monClass->fetch_assoc()){ echo $label["name"];?> <?}?>" >
                                                    <label class="monitor_overview">
                                                        <input type="checkbox" name="monitor" value="<? echo $row["mID"] ?>" id="monInput-<?echo $countMonitors?>">
                                                        <i class="fa fa-television fa-4x" aria-hidden="true"></i><br>
                                                        <p><? echo $row["name"] ?></p>
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
                                    <fieldset>
                                        <ul>
                                            <? while($row = $firstFloor->fetch_assoc()){ ?>
                                                <? $monClassQuery = new Query("SELECT * FROM (SELECT lID FROM monitors NATURAL JOIN monitorhaslabel WHERE mID = ".($countMonitors-1).") ".
                                                    "AS labelid NATURAL JOIN labels WHERE lID < 3 OR lID > 6");
                                                $monClass = $monClassQuery->getQuery(); ?>
                                            <li class="monLi firstFloor  <? while($label = $monClass->fetch_assoc()){ echo $label["name"];?> <?}?>" >
                                                    <label class="monitor_overview">
                                                        <input type="checkbox" name="monitor" value="<? echo $row["mID"] ?>" id="monInput-<?echo $countMonitors?>">
                                                        <i class="fa fa-television fa-4x" aria-hidden="true"></i><br>
                                                        <p><? echo $row["name"] ?></p>
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
                                    <fieldset>
                                        <ul>
                                            <? while($row = $secondFloor->fetch_assoc()){ ?>
                                                <? $monClassQuery = new Query("SELECT * FROM (SELECT lID FROM monitors NATURAL JOIN monitorhaslabel WHERE mID = ".($countMonitors-1).") ".
                                                    "AS labelid NATURAL JOIN labels WHERE lID < 3 OR lID > 6");
                                                $monClass = $monClassQuery->getQuery(); ?>
                                            <li class="monLi secondFloor  <? while($label = $monClass->fetch_assoc()){ echo $label["name"];?> <?}?>" >
                                                    <label class="monitor_overview">
                                                        <input type="checkbox" name="monitor" value="<? echo $row["mID"] ?>" id="monInput-<?echo $countMonitors?>">
                                                        <i class="fa fa-television fa-4x" aria-hidden="true"></i><br>
                                                        <p><? echo $row["name"] ?></p>
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
                                    <fieldset>
                                        <ul>
                                            <? while($row = $thirdFloor->fetch_assoc()){ ?>
                                                <? $monClassQuery = new Query("SELECT * FROM (SELECT lID FROM monitors NATURAL JOIN monitorhaslabel WHERE mID = ".($countMonitors-1).") ".
                                                    "AS labelid NATURAL JOIN labels WHERE lID < 3 OR lID > 6");
                                                $monClass = $monClassQuery->getQuery(); ?>
                                            <li class="monLi thirdFloor  <? while($label = $monClass->fetch_assoc()){ echo $label["name"];?> <?}?>" >
                                                    <label class="monitor_overview">
                                                        <input type="checkbox" name="monitor" value="<? echo $row["mID"] ?>" id="monInput-<?echo $countMonitors?>">
                                                        <i class="fa fa-television fa-4x" aria-hidden="true"></i><br>
                                                        <p><? echo $row["name"] ?></p>
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
                <div id="previewPanel" class="panel panel-default">
                    <div class="panel-body">
                        <h2>Details</h2>
                        <button id="editButton" type="submit" onclick="$('#monitorForm').submit()" class="btn btn-large btn-primary logout" href="#">
                            <i class="fa fa-pencil" aria-hidden="true">  Continue</i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
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