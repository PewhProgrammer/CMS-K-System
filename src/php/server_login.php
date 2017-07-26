<?php

require("ServerWrapper.php");
include "User.php";

class UserHandler extends ServerWrapper
{
    private $user;
    private $testData;
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
            $query2 = new Query("UPDATE users SET session_id='".null."' WHERE name='" .$_SESSION['user']. "'");
            $result3= $query2->getQuery();
            setcookie('sess','val',time()-(120),"/");
            session_destroy();
            session_unset();
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

        $this->query = new Query("SELECT * FROM users WHERE name='" . $this->user->getUsername() . "' AND pass='" . $this->user->getPassword() . "'");
        $result = $this->query->getQuery();

        if (mysqli_num_rows($result) == 1) {
            if(!$result->fetch_array()['session_id']) {
                session_start();
                session_regenerate_id(true);
                $t=session_id();
                $query2 = new Query("UPDATE users SET session_id='".$t."' WHERE name='" .$this->user->getUsername(). "'");
                $result3= $query2->getQuery();
                $_SESSION['user'] = $this->user->getUsername();
                setcookie('sess',$t,time() + (1800), "/");
                if (!$this->testData)
                    header('location:./index.php');
            } else{
                $query2 = new Query("UPDATE users SET session_id='".null."' WHERE name='" .$this->user->getUsername(). "'");
                $result3= $query2->getQuery();
                array_push(self::$errors, "Previous session was not logged out. To start new session please enter your credentials again:");
                return new Response('404', 'Incorrect session logout');
            }
        } else {
            array_push(self::$errors, "Incorrect username/password");
            return new Response('404', 'Incorrect username/password');
        }

        return $this->query->getResponse();
    }

    private function verify(){
        return !($this->user === null);
    }

    public function initTestData($usr){
        $this->testData = true;
        $this->user = $usr;
    }
}

$a = new UserHandler();

?>