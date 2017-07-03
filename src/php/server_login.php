<?php

require "dbquery.php";

class Login extends Query
{
    private $responseCode = 200;
    private $username = "";
    private $password = "";
    public static $errors = [];

    function __construct()
    {
        //Check if keys exists
        if (isset($_POST["login"])) {

            $this->username = $_POST['username'];
            $this->password = $_POST['password'];

            if (empty($this->username)) {
                array_push(self::$errors, "Username is required");
            }
            if (empty($this->password)) {
                array_push(self::$errors, "Password is required");
            }
            if (count(self::$errors) == 0) {
                $this->login();
            }
        } else if (isset($_GET["logout"])) {
            session_destroy();
            unset($_SESSION['user']);
            header('location: login.php');
        } else {
            $this->responseCode = 400;
        }

    }

    public function login()
    {

        $this->password = hash('sha256', $this->password);
        $query = new Query("SELECT * FROM users WHERE name='" .$this->username. "' AND pass='" . $this->password . "'");
        $result = $query->getQuery();

        if (mysqli_num_rows($result) == 1) {
            $_SESSION['user'] = $this->username;
            header('location:./index.php');
        } else {
            array_push(self::$errors, "Incorrect username/password");
        }


}

}

$a = new Login();

?>