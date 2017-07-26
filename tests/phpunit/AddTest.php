<?php

/**
 * Created by PhpStorm.
 * User: Thinh-Laptop
 * Date: 13.07.2017
 * Time: 17:48
 */
require_once('../../src/php/Add.php');

class AddTest extends \PHPUnit\Framework\TestCase
{

    public function testSuccess(){
        $add = new Add();
        $this->assertEquals(null, $add->getResource(), "There is a resource where there shouldn't be one");

        $add->setResource(new Resource("google","www.google.de","website"));
        $response = $add->execute();

        $this->assertEquals(200,$response->getCode(),"Response code was wrong");
    }

    public function testConstructor() {
        $_POST["name"] = "Test.txt";
        $_POST["type"] = "NoType";
        $_POST["path"] = "C:\Users\Marc\Desktop\Test.txt";
        $add = new Add();
        $this->assertEquals("Test.txt", $add->getResource()->getName(), "Wrong resource name");
        $this->assertEquals("NoType", $add->getResource()->getType(), "Wrong resource name");
        $this->assertEquals("C:\Users\Marc\Desktop\Test.txt", $add->getResource()->getData(), "Wrong resource name");
    }
}
