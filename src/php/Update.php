<?php
/**
 * Created by PhpStorm.
 * User: Marc
 * Date: 27.07.2017
 * Time: 10:35
 */
require_once("Events.php");

class Update extends Events
{
    private $monID;
    private $newName;

    /**
     * Events constructor.
     */
    public function __construct()
    {
        if(isset($_POST["monID"]) && isset($_POST["newName"])) {
            $this->monID = $_POST["monID"];
            $this->newName = $_POST["newName"];
            return;
        }
    }

    /**
     * @return Response The return value shall be a Response
     */
    public function execute()
    {
        if(!$this->verify()) return new Response('404','Verification went wrong');
        $this->query = new Query("UPDATE monitors SET name='".$this->newName."' WHERE mID=".$this->monID);
        $this->query->getQuery();
        return $this->query->getResponse();
    }

    /**
     * Checks if the params are set correctly
     * @return bool The return value shall be a Boolean
     */
    protected function verify()
    {
        return true;
    }

}

$a = new Update();
echo $a->execute();
?>