<?php

/**
 * Created by PhpStorm.
 * User: Thinh-Laptop
 * Date: 13.07.2017
 * Time: 17:48
 */
require_once('../../src/php/Update.php');

class UpdateTest extends \PHPUnit\Framework\TestCase
{

    public function testSuccess(){
        $update = new Update();
        $_POST["monID"] = 20;
        $_POST["newName"] = 'testMonitor';

        $update = new Update();
        $response = $update->execute();

        $this->assertEquals(200,$response->getCode(),"Response code was wrong: ".$response->getMsg());

        $_POST["monID"] = null;
        $_POST["newName"] = null;
    }

}
