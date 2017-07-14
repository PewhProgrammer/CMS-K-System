<?php

/**
 * Created by PhpStorm.
 * User: Thinh-Laptop
 * Date: 13.07.2017
 * Time: 17:48
 */
require_once('../../src/php/add.php');

class AddTest extends \PHPUnit\Framework\TestCase
{

    public function testReason(){
        $add = new Add();
        $add->setResource(new Resource("test","test","test"));
        $response = $add->execute();

        $this->assertEquals(200,$response->getCode(),"Response code was wrong");
    }
}
