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
            You have chosen Monitor 1  <i class="fa fa-television fa-4x" aria-hidden="true"></i>

            <form action="#">
                <h3>Select the resource you want to attach to the monitor</h3>
                <fieldset>
                    <ul>
                        <? while($row = $res->fetch_assoc()){ ?>
                            <li>
                            <label class="k-selectable">
                                <input id="res-<? echo $row["rID"] ?>" class="res" type="checkbox" name="resource" value="<? echo $row["rID"] ?>">
                              <? echo $row["name"] ?>
                            </label>
                        </li>
                        <?}?>
                    </ul>
                </fieldset>
            </form>

        </div>
        <!-- /.panel-body -->

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#uploadModal" id="addResource">
            Add new resource
        </button>
        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#confModal" id="continueConfig" disabled="disabled">
            Continue
        </button>

        <!-- Confirmation Modal -->
        <div class="modal fade" id="confModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Are you sure?</h4>
                    </div>
                    <div class="modal-body">
                    <h2> Do you really want to apply the following changes:</h2>
                       <p> The resource "ImportantPDF.pdf" is going to be attached to monitor "Monitor 1"</p>

                       <p> Preview:</p>
                           <i class="fa fa-television fa-5x" style="font-size:20em" aria-hidden="true"></i>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button onclick="location.href = 'index.php';" type="button" class="btn btn-primary">Save changes</button>
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
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Add new resource</h4>
                    </div>
                    <div class="modal-body">
                        <div class="dropdown">
                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                File type
                                <span class="caret"></span>
                            </button>
                            <ul id="fileTypeDrop" class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <li><a >PDF</a></li>
                                <li><a href="#">Image</a></li>
                                <li><a href="#">Website</a></li>
                                <li><a href="#">RSS Feed</a></li>
                            </ul>
                        </div>

                        <div class="form-group" id="urlForm" style="display:none">
                            <label for="url" id="urlHeader">Name:</label>
                            <input type="text" class="form-control" id="url">
                        </div>
                    </div>
                    <div class="alert alert-warning" id="warning" style="display:none">
                        <strong>Warning!</strong><p id="warningInput">Indicates a warning that might need attention.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="addResourceSubmit" >Add resource</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Upload Modal -->
    </div>
</div>

<!-- Main JS Script -->
<script src="../libs/jquery-3.2.1.js"></script>
<script src="../libs/bootstrap.js"></script>
<script src="../js/resourceModule.js"></script>
<script src="../js/exampleModule.js"></script>
<script src="../js/main.js"></script>
</body>
</html>