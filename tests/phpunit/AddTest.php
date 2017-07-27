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

        $query = new Query("DELETE FROM resources WHERE name = 'google'");
        $query->executeQuery();
        $response = $query->getResponse();
        $this->assertEquals(200,$response->getCode(),"Response code was wrong: ".$response->getMsg());
    }

    public function testAddNewLabel(){
        $_POST['newLabel'] = 'testLabel';
        $add = new Add();

        $query = new Query("DELETE FROM labels WHERE name = 'testLabel'");
        $query->executeQuery();
        $response = $query->getResponse();
        $this->assertEquals(200,$response->getCode(),"Response code was wrong: ".$response->getMsg());
    }

    public function testConstructor() {
        $_POST["name"] = "Test.txt";
        $_POST["type"] = "NoType";
        $_POST["path"] = 'C:\Users\Thinh-Laptop\Desktop\Test.txt';
        $add = new Add();
        $this->assertEquals("Test.txt", $add->getResource()->getName(), "Wrong resource name");
        $this->assertEquals("NoType", $add->getResource()->getType(), "Wrong resource name");
        $this->assertEquals("C:\Users\Thinh-Laptop\Desktop\Test.txt", $add->getResource()->getData(), "Wrong resource name");

        $query = new Query("DELETE FROM resources WHERE name = 'Test.txt'");
        $query->executeQuery();
        $response = $query->getResponse();
        $this->assertEquals(200,$response->getCode(),"Response code was wrong: ".$response->getMsg());
    }
}
