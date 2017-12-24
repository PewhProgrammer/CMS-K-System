<?php
/**
 * Created by PhpStorm.
 * User: Thinh-Laptop
 * Date: 13.07.2017
 * Time: 21:22
 */

use PHPUnit\Framework\TestCase;

require '../../src/php/Attach.php';

class AttachTest extends TestCase
{
    public function testReason(){
        $attach = new Attach();
        $resources = array(1,2);
        $monitors = array(18,19);
        $attach->setResources($resources, $monitors, "2018-06-13 21:30:11");
        $response = $attach->execute();

        $this->assertEquals(200,$response->getCode(),"Response code was wrong");
    }

    public function testEmptyConstructor() {
        $attach = new Attach();
        $this->assertEquals(null,$attach->getMonitors(),"There where monitors, where there shouldn't be some.");
        $this->assertEquals(null,$attach->getResources(),"There where resources, where there shouldn't be some.");
        $this->assertEquals(null,$attach->getUntil(),"There was an until, where there shouldn't be one.");
    }

    public function testConstructor() {
        $_POST["resources"] = array(1,2,3);
        $_POST["monitors"] = array(17,18,19,20);
        $_POST["until"] = "testUntil";
        $attach = new Attach();

        $this->assertEquals(20,$attach->getMonitors()[3],"There should be monitors.");
        $this->assertEquals(1,$attach->getResources()[0],"There should be resources.");
        $this->assertEquals("testUntil", $attach->getUntil(), "Wrong until");
    }
}
