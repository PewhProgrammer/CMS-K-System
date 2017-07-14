<?php

require_once("ServerWrapper.php");
include_once "User.php";

class UserHandler extends ServerWrapper
{
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
                $this->execute();
                return;
            }

        } else if (isset($_GET["logout"])) {
            session_destroy();
            unset($_SESSION['user']);
            header('location: login.php');
        } else {
            echo "";
        }

    }

    /**
     * @return Response The return value shall be a Response
     */
    public function execute()
    {
        if(!$this->verify()) return new Response('404','No user found');
        $this->user->setPassword(hash('sha256', $this->user->getPassword()));
        $this->query = new Query("SELECT * FROM users WHERE name='" .$this->user->getUsername(). "' AND pass='" . $this->user->getPassword() . "'");
        $result = $this->query->getQuery();

        if (mysqli_num_rows($result) == 1) {
            $_SESSION['user'] = $this->user->getUsername();
            header('location:./index.php');
        } else {
            array_push(self::$errors, "Incorrect username/password");
        }

        return $this->query->getResponse();
    }

    private function verify(){
        return !$this->user === null;
    }

    public function initTestData($usr){
        $this->user = $usr;
    }
}

$a = new UserHandler();

?>