<?php
/**
 * Created by PhpStorm.
 * User: Esha
 * Date: 6/26/2017
 * Time: 10:55 PM
 */
include('../php/server_login.php');?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../main.css">
    <meta charset="UTF-8">
    <title>CMS-K</title>
</head>
<body>
<div id="login" class="header">
    <h1 align="center" class="text-primary"> Welcome to CMS-K</h1>
    <form action="login.php" method="POST" class="input" align="center"><br/>
        <?php include('../php/errors.php'); ?>
        <h3><label>Username</label>
            <input type="text" name="username"></h3>

        <h3><label>Password</label>
            <input type="password" name="password"></h3>

        <button type="submit" name ="login" class="btn btn-large btn-primary">Login</button>
    </form>
</div>
</body>
</html>