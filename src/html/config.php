<?php
require '../php/dbconnect.php';

$query = new Query("SELECT * FROM resources");
$res = $query->getQuery();

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
            <a class="navbar-brand" href="index.php">CMS-K Admin v0.1</a>
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
                        <a href="index.php"><i class="fa fa-television fa-fw"></i> Monitor Overview</a>
                    </li>
                    <li>
                        <a href="index.php"><i class="fa fa-folder fa-fw"></i> Resource Overview</a>
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
                <h1 class="page-header">Configuration</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                Choose resource to add
            </div>
            <!-- /.panel-heading -->
            <i class="fa fa-television fa-4x" aria-hidden="true"></i>
            <p id="chosenMonitor"></p>
            <form action="#" id="resForm">
                <h3>Select the resource you want to attach to the monitor</h3>
                <fieldset>
                    <ul id="ressourceList">
                        <? while ($row = $res->fetch_assoc()) { ?>
                            <li>
                                <label class="k-selectable">
                                    <? if($row["type"] == "pdf") { ?>
                                        <i class="fa fa-file-pdf-o" style="font-size: 2em;"></i>
                                    <? } else if($row["type"] == "website") {?>
                                        <i class="fa fa-file-word-o" style="font-size: 2em;"></i>
                                    <? } else if($row["type"] == "image") {?>
                                        <i class="fa fa-file-picture-o" style="font-size: 2em;"></i>
                                    <? } else {?>
                                        <i class="fa fa-file-o" style="font-size: 2em;"></i>
                                    <? } ?>
                                    <input id="res-<? echo $row["rID"] ?>" class="res" type="checkbox" name="resource"
                                           value="<? echo $row["name"] ?>">
                                    <? echo $row["name"] ?>

                                </label>
                                <i class="fa fa-trash-o" data-id="<? echo $row["rID"] ?>"></i>
                            </li>
                        <? } ?>
                    </ul>
                </fieldset>
            </form>

        </div>
        <!-- /.panel-body -->

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#uploadModal"
                id="addResource">
            Add new resource
        </button>
        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#confModal"
                id="continueConfig" disabled="disabled">
            Continue
        </button>

        <!-- Confirmation Modal -->
        <div class="modal fade" id="confModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Are you sure?</h4>
                    </div>
                    <div class="modal-body">
                        <h2> Following resource(s) will be applied:</h2>
                        <div id="modalResourceList">
                        </div>

                        <hr style="width:50%;border-width:0.1em;border-color:grey">
                        <div class="container">
                            <div class="row">
                                <div class='col-sm-6'>
                                    <div class="checkbox">
                                        <label><input type="checkbox" id="timeSpanCheck">Add time span</label>
                                    </div>
                                    <div class="form-group" style="display:none" id="timeSpan">
                                        <div class='input-group date' id='datetimepicker1'>
                                            <input id="timeSpanText" type='text' class="form-control"  placeholder="MM/DD/YY H:MM AM or PM"/>
                                            <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button id="attachSubmit" type="button" class="btn btn-primary">Save
                            changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Confirmation Modal -->

        <!-- Upload Modal -->
        <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Add new resource</h4>
                    </div>
                    <div class="modal-body">
                        <div class="dropdown">
                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                File type
                                <span class="caret"></span>
                            </button>
                            <ul id="fileTypeDrop" class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <li><a>PDF / Image</a></li>
                                <li><a href="#">Website</a></li>
                                <li><a href="#">RSS Feed</a></li>
                            </ul>
                        </div>

                        <div class="form-group" id="urlForm">
                            <label for="url" id="urlHeader">Name:</label>
                            <input type="text" class="form-control" id="url">
                        </div>
                        <div id="fileForm">
                            <form id="droppy" action="../php/upload.php" class="dropzone"></form>
                        </div>

                        <div class="alert alert-warning" id="warning" style="display:none">
                            <strong>Warning!</strong>
                            <p id="warningInput">Indicates a warning that might need attention.</p>
                        </div>

                        <div class="alert alert-success" id="success" style="display:none">
                            <strong>Success!</strong>
                            <p id="successInput">Indicates a success that might need attention.</p>
                        </div>

                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="addResourceSubmit">Add resource</button>
                    </div>
                </div>
            </div>

        </div>
        <!-- End Upload Modal -->

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