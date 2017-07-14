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
        $cM = new ContentManager();
        $response = $cM->execute();
        $this->assertEquals(404,$response->getCode(),"Response code was wrong");

        $cM->initTestData(1);
        $response = $cM->execute();
        $this->assertEquals(200,$response->getCode(),"Response code was wrong");
    }

}
