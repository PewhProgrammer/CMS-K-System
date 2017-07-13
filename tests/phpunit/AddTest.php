<?php

/**
 * Created by PhpStorm.
 * User: Thinh-Laptop
 * Date: 13.07.2017
 * Time: 17:48
 */
require '../../src/php/add.php';

class AddTest extends \PHPUnit\Framework\TestCase
{

    public function testReason(){
        $add = new Add();
        $response = $add->execute();
        echo $response;

        $this->assertEquals(0,1,"It was right");
    }

}
