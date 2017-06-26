<?php
/**
 * Created by PhpStorm.
 * User: Esha
 * Date: 6/26/2017
 * Time: 10:55 PM
 */
session_start();

$username="";
$password="";
$errors=array();

$db=mysqli_connect('localhost','root', 'root', 'cms_k');

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    if (count($errors) == 0) {
        //$password = md5($password);
        $query = "SELECT * FROM users WHERE name='$username' AND pass='$password'";
        $result = mysqli_query($db, $query);
        if (mysqli_num_rows($result) == 1) {
            //$_SESSION['success']="You are now logged in";
            header('location:./index.php');
        }else{
            array_push($errors, "Incorrect username/password");
            //header('location:./login.php');
        }
    }
}

//logout
//if(isset($_GET['logout'])){
   // session_destroy();
    //unset($_SESSION['username']);
    //header('location: login.html');
//}
?>