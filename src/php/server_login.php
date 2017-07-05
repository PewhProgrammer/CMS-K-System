<?php

require "dbquery.php";
include_once "User.php";

class Login extends Query
{
    private $response;
    private $user;
    public static $errors = [];

    function __construct()
    {
        //Check if keys exists
        if (isset($_POST["login"])) {

            $this->user = new User($_POST['username'], $_POST['password']);

            if (empty($this->user->getUsername())) {
                array_push(self::$errors, "Username is required");
            }
            if (empty($this->user->getPassword())) {
                array_push(self::$errors, "Password is required");
            }
            if (count(self::$errors) == 0) {
                $this->response = new Response(200, "Success");
                $this->login();
            }

        } else if (isset($_GET["logout"])) {
            session_destroy();
            unset($_SESSION['user']);
            header('location: login.php');
        } else {
            $this->response = new Response(400, "Got no parameters.");
        }

    }

    public function login()
    {

        $this->user->setPassword(hash('sha256', $this->user->getPassword()));
        $query = new Query("SELECT * FROM users WHERE name='" .$this->user->getUsername(). "' AND pass='" . $this->user->getPassword() . "'");
        $result = $query->getQuery();

        if (mysqli_num_rows($result) == 1) {
            $_SESSION['user'] = $this->user->getUsername();
            header('location:./index.php');
        } else {
            array_push(self::$errors, "Incorrect username/password");
        }

}

}

$a = new Login();

?>