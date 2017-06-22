<?php
require '../php/dbconnect.php';

$query = new Query("SELECT * FROM monitors");
$mon = $query->getQuery();

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
                <div class="pull-right">
                    <button id="editButton" type="submit" onclick="$('#monitorForm').submit()" class="btn btn-large btn-primary logout" href="#">
                        <i class="fa fa-pencil" aria-hidden="true">  Continue</i>
                    </button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                            Filter
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu pull-right" role="menu">
                            <li><a href="#">Location</a></li>
                            <li class="divider"></li>
                            <li><a href="#">1st floor</a>
                            </li><li><a href="#">2nd floor</a>
                        </li>
                            <li><a href="#">3rd floor</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /.panel-heading -->

            <form action="config.php" id="monitorForm">
                <h3>Select the monitor you want to change</h3>
                <fieldset>
                    <ul>
                        <? while($row = $mon->fetch_assoc()){ ?>
                        <li>
                            <label class="monitor_overview">
                                <input type="checkbox" name="monitor" value="<? echo $row["mID"] ?>">
                                <i class="fa fa-television fa-4x" aria-hidden="true"></i><br><? echo $row["name"] ?>
                            </label>
                        </li>
                        <?}?>
                    </ul>
                </fieldset>
            </form>

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
<script src="../js/attachModule.js"></script>
 <script src="../js/resourceModule.js"></script>
<script src="../js/monitorModule.js"></script>
<script src="../js/resFormModule.js"></script>
<script src="../js/feedbackModule.js"></script>
<script src="../js/exampleModule.js"></script>
<script src="../js/globalModule.js"></script>
<script src="../js/dropzone.js"></script>
<script src="../js/modules.min.js"></script>
<script src="../js/main.js"></script>
</body>
</html>