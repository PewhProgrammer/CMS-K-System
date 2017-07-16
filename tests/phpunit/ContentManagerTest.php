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

    public function testExecute(){
        $_POST["mID"] = 1;
        $cM = new ContentManager();
        $response = $cM->execute();
        $this->assertEquals(200,$response->getCode(),"Response code was wrong");

        $cM->initTestData(2);
        $response = $cM->execute();
        $this->assertEquals(200,$response->getCode(),"Response code was wrong");
        $cM->initTestData(3);
        $response = $cM->execute();
        $this->assertEquals(200,$response->getCode(),"Response code was wrong");
        $cM->initTestData(4);
        $response = $cM->execute();
        $this->assertEquals(200,$response->getCode(),"Response code was wrong");
        $cM->initTestData(5);
        $response = $cM->execute();
        $this->assertEquals(200,$response->getCode(),"Response code was wrong");
    }

}
