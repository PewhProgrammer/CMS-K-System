<?php
/**
 * Created by PhpStorm.
 * User: Thinh-Laptop
 * Date: 14.07.2017
 * Time: 16:09
 */

use PHPUnit\Framework\TestCase;

require_once('../../src/php/ContentManager.php');

class ContentManagerTest extends TestCase
{

    public function testID(){
        $_POST["mID"] = 1;
        $cM = new ContentManager();
        $response = $cM->execute();
        $this->assertEquals(200,$response->getCode(),"Response code was wrong");

        $cM->initTestData(2);
        $response = $cM->execute();
        $this->assertEquals(200,$response->getCode(),"Response code was wrong: ".$response->getMsg());
        $cM->initTestData(3);
        $response = $cM->execute();
        $this->assertEquals(200,$response->getCode(),"Response code was wrong: ".$response->getMsg());
        $cM->initTestData(4);
        $response = $cM->execute();
        $this->assertEquals(200,$response->getCode(),"Response code was wrong: ".$response->getMsg());
        $cM->initTestData(5);
        $response = $cM->execute();
        $this->assertEquals(200,$response->getCode(),"Response code was wrong: ".$response->getMsg());
        $cM->initTestData(6);
        $response = $cM->execute();
        $this->assertEquals(200,$response->getCode(),"Response code was wrong: ".$response->getMsg());
        $cM->initTestData(7);
        $response = $cM->execute();
        $this->assertEquals(200,$response->getCode(),"Response code was wrong: ".$response->getMsg());
    }

    public function testNoID(){
        $_POST["mID"] = null;
        $cM = new ContentManager();
        $response = $cM->execute();
        $this->assertEquals(404,$response->getCode(),"Response code was wrong");
    }

    public function testUntil(){
        $_POST["mID"] = 1;
        $cM = new ContentManager();
        $response = $cM->execute();
        $cM->initTestData(6);
        $this->assertEquals(200,$response->getCode(),"Response code was wrong");
    }

}
