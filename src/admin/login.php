<?php
/**
 * Created by PhpStorm.
 * User: Esha
 * Date: 6/26/2017
 * Time: 10:55 PM
 */
require '../php/Query.php';
include_once('../php/UserHandler.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../main.css">
    <meta charset="UTF-8">
    <title>CMS-K</title>
</head>
<body>
<div id="login" class="header">
    <img src="https://cispa.saarland/wp-content/themes/cispa/images/cispa-logo.png" alt="logo" style="float: left;width: 150px;height: 90px;">
    </br></br></br></br><h1 align="center" class="text-primary"> Welcome to CMS-K</h1>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-body">
                        <form action="login.php" method="POST" class="input" align="center"><br/>
                            <div class="form-group">
                                <input class="form-control" placeholder="Username" name="username" type="text" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password" value="">
                            </div>
                            <?php if(isset($_GET['error'])){?>
                                <h4 class="panel text-danger"><?php echo "You have logged in elsewhere. "?><br><br><?php echo "Please enter your credentials again to log out previous session";?></h4>
                                <?php $query2 = new Query("UPDATE users SET attempt=1 WHERE uID='" .$_GET['error']. "'");
                                      $result3= $query2->getQuery();
                                 } unset($_GET['error']);
                            foreach (UserHandler::$errors as $error): ?>
                                <h4 class="panel text-danger"><?php echo $error; ?></h4>
                            <?php endforeach;?>
                            <button type="submit" name ="login" class="btn btn-lg btn-block btn-primary"><i class="fa fa-sign-in" aria-hidden="true"></i>
                                Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>